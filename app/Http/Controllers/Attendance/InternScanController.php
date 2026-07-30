<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\QRSession;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InternScanController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('intern/scan');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $qrSession = QRSession::where('token', $validated['token'])->first();

        if (! $qrSession) {
            return back()->withErrors(['token' => 'Invalid QR code.']);
        }

        if ($qrSession->isExpired()) {
            return back()->withErrors(['token' => 'This QR code has expired. Ask your supervisor to refresh it.']);
        }

        $profile = $request->user()->internProfile;

        if (! $profile) {
            return back()->withErrors(['token' => 'No intern profile is set up for your account yet.']);
        }

        $today = now()->toDateString();

        $log = AttendanceLog::where('intern_profile_id', $profile->id)
            ->whereDate('date', $today)
            ->first();

        if (! $log) {
            $log = new AttendanceLog([
                'intern_profile_id' => $profile->id,
                'date' => $today,
                'time_in' => now(),
                'status' => 'Incomplete',
            ]);
            $log->save();

            return back()->with('success', 'Timed in successfully at '.now()->format('g:i A'));
        }

        if ($log->status === 'Incomplete' && ! $log->time_out) {
            $log->time_out = now();
            // TODO: Present vs Late needs a cutoff time the team hasn't defined yet.
            $log->status = 'Present';
            $log->rendered_hours = round($log->time_out->diffInMinutes($log->time_in) / 60, 2);
            $log->save();

            $profile->increment('current_hours', $log->rendered_hours);

            return back()->with('success', 'Timed out successfully at '.now()->format('g:i A'));
        }

        return back()->withErrors(['token' => 'You have already completed your attendance for today.']);
    }
}