import { router, usePage } from '@inertiajs/react';
import { Html5Qrcode } from 'html5-qrcode';
import { useEffect, useRef, useState } from 'react';

interface PageProps {
    [key: string]: unknown;
    flash?: {
        success?: string;
    };
    errors?: {
        token?: string;
    };
}

const SCANNER_ELEMENT_ID = 'qr-reader';

export default function Scan() {
    const { props } = usePage<PageProps>();
    const [manualToken, setManualToken] = useState('');
    const [scannerError, setScannerError] = useState<string | null>(null);
    const [cameraActive, setCameraActive] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const scannerRef = useRef<Html5Qrcode | null>(null);
    const lastScannedRef = useRef<{ token: string; time: number } | null>(null);

    const submitToken = (token: string) => {
        if (!token || isSubmitting) return;

        // Guard against the same QR frame being decoded (and submitted)
        // multiple times per second while the camera keeps reading it.
        const now = Date.now();
        if (
            lastScannedRef.current &&
            lastScannedRef.current.token === token &&
            now - lastScannedRef.current.time < 4000
        ) {
            return;
        }
        lastScannedRef.current = { token, time: now };

        setIsSubmitting(true);
        router.post(
            '/intern/scan',
            { token },
            {
                preserveScroll: true,
                onFinish: () => setIsSubmitting(false),
                onSuccess: () => setManualToken(''),
            },
        );
    };

    useEffect(() => {
        let isMounted = true;
        const scanner = new Html5Qrcode(SCANNER_ELEMENT_ID);
        scannerRef.current = scanner;

        Html5Qrcode.getCameras()
            .then((cameras) => {
                if (!isMounted || cameras.length === 0) {
                    setScannerError('No camera found on this device.');
                    return;
                }

                scanner
                    .start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: { width: 220, height: 220 } },
                        (decodedText) => submitToken(decodedText),
                        () => {
                            // Fires on every frame with no QR in view — expected, ignore it.
                        },
                    )
                    .then(() => setCameraActive(true))
                    .catch(() => {
                        setScannerError('Could not start the camera. Check permissions or use manual entry below.');
                    });
            })
            .catch(() => {
                setScannerError('Camera access was denied or unavailable. Use manual entry below.');
            });

        return () => {
            isMounted = false;
            if (scannerRef.current?.isScanning) {
                scannerRef.current
                    .stop()
                    .then(() => scannerRef.current?.clear())
                    .catch(() => {});
            }
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const submitManual = (e: React.FormEvent) => {
        e.preventDefault();
        submitToken(manualToken);
    };

    return (
        <div className="flex min-h-screen flex-col items-center justify-center gap-6 p-8">
            <h1 className="text-xl font-semibold">Scan Attendance QR</h1>

            {props.flash?.success && (
                <div className="rounded bg-green-100 px-4 py-2 text-sm text-green-800">
                    {props.flash.success}
                </div>
            )}

            {props.errors?.token && (
                <div className="rounded bg-red-100 px-4 py-2 text-sm text-red-800">
                    {props.errors.token}
                </div>
            )}

            <div id={SCANNER_ELEMENT_ID} className="w-full max-w-xs overflow-hidden rounded-lg border" />

            {!cameraActive && !scannerError && (
                <p className="text-sm text-muted-foreground">Starting camera…</p>
            )}
            {scannerError && <p className="max-w-xs text-center text-sm text-red-700">{scannerError}</p>}
            {isSubmitting && <p className="text-sm text-muted-foreground">Submitting…</p>}

            <div className="w-full max-w-xs border-t pt-4">
                <p className="mb-2 text-center text-xs text-muted-foreground">
                    Camera not working? Paste the token manually:
                </p>
                <form onSubmit={submitManual} className="flex flex-col gap-3">
                    <input
                        type="text"
                        value={manualToken}
                        onChange={(e) => setManualToken(e.target.value)}
                        placeholder="Paste token here"
                        className="rounded border px-3 py-2 text-sm"
                    />
                    <button
                        type="submit"
                        disabled={isSubmitting}
                        className="rounded bg-black px-4 py-2 text-sm font-medium text-white disabled:opacity-50"
                    >
                        Submit
                    </button>
                </form>
            </div>
        </div>
    );
}