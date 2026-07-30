<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\QRSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SupervisorAttendanceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('supervisor/attendance', [
            'qr' => $this->freshToken(request()),
        ]);
    }

    public function generateQr(Request $request)
    {
        return response()->json($this->freshToken($request));
    }

    private function freshToken(Request $request): array
    {
        // deactivate this supervisor's previous session, since is_active is new
        QRSession::where('hte_supervisor_id', $request->user()->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $session = QRSession::create([
            'hte_supervisor_id' => $request->user()->id,
            'token' => Str::random(40),
            'expires_at' => now()->addSeconds(20),
            'is_active' => true,
        ]);

        return [
            'token' => $session->token,
            'expires_at' => $session->expires_at->toIso8601String(),
        ];
    }
}