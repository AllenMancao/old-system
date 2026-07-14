<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\QrSession;
use Carbon\Carbon;
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

        $qrSession = QrSession::where('token', $validated['token'])->first();

        if (! $qrSession) {
            return back()->withErrors(['token' => 'Invalid QR code.']);
        }

        if ($qrSession->isExpired()) {
            return back()->withErrors(['token' => 'This QR code has expired. Ask your supervisor to refresh it.']);
        }

        $intern = $request->user();
        $today = now()->toDateString();

        $log = AttendanceLog::firstOrNew([
            'intern_id' => $intern->id,
            'date' => $today,
        ]);

        if (! $log->exists) {
            $log->time_in = now()->toTimeString();
            $log->status = 'ongoing';
            $log->save();

            return back()->with('success', 'Timed in successfully at '.now()->format('g:i A'));
        }

        if ($log->status === 'ongoing' && ! $log->time_out) {
            $log->time_out = now()->toTimeString();
            $log->status = 'completed';

            $timeIn = Carbon::parse($log->date->toDateString().' '.$log->time_in);
            $timeOut = Carbon::parse($log->date->toDateString().' '.$log->time_out);
            $log->rendered_hours = round($timeOut->diffInMinutes($timeIn) / 60, 2);

            $log->save();

            return back()->with('success', 'Timed out successfully at '.now()->format('g:i A'));
        }

        return back()->withErrors(['token' => 'You have already completed your attendance for today.']);
    }
}