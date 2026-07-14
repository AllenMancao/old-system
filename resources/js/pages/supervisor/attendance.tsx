import { router } from '@inertiajs/react';
import { QRCodeSVG } from 'qrcode.react';
import { useEffect, useState } from 'react';

interface QrData {
    token: string;
    expires_at: string;
}

interface Props {
    qr: QrData;
}

export default function Attendance({ qr }: Props) {
    const [secondsLeft, setSecondsLeft] = useState(20);

    // Countdown display, recalculated whenever a fresh qr prop arrives
    useEffect(() => {
        const expiresAt = new Date(qr.expires_at).getTime();

        const tick = () => {
            const diff = Math.max(0, Math.round((expiresAt - Date.now()) / 1000));
            setSecondsLeft(diff);
        };

        tick();
        const countdown = setInterval(tick, 1000);
        return () => clearInterval(countdown);
    }, [qr.expires_at]);

    // Every 20s, ask the server for a fresh QR via a partial Inertia reload
    useEffect(() => {
        const refresh = setInterval(() => {
            router.reload({ only: ['qr'] });
        }, 20000);
        return () => clearInterval(refresh);
    }, []);

    return (
        <div className="flex min-h-screen flex-col items-center justify-center gap-6 p-8">
            <h1 className="text-xl font-semibold">Attendance QR Code</h1>

            <div className="rounded-lg border p-4">
                <QRCodeSVG value={qr.token} size={240} />
            </div>

            <p className="text-sm text-muted-foreground">
                Refreshes in <span className="font-mono font-medium">{secondsLeft}s</span>
            </p>

            <p className="max-w-xs text-center text-xs text-muted-foreground">
                If a device can't scan, it can manually type this token instead:
            </p>
            <code className="rounded bg-muted px-3 py-1 text-xs">{qr.token}</code>
        </div>
    );
}