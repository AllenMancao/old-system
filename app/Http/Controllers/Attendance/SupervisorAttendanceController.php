<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\QrSession;
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
        $session = QrSession::create([
            'token' => Str::random(40),
            'supervisor_id' => $request->user()->id,
            'expires_at' => now()->addSeconds(20),
        ]);

        return [
            'token' => $session->token,
            'expires_at' => $session->expires_at->toIso8601String(),
        ];
    }
}