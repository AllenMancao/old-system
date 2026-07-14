<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SupervisorDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        // TODO: replace with real query once intern_profiles/attendance_logs
        // migrations (Suboan-Branch) are merged:
        // InternProfile::where('supervisor_id', $request->user()->id)->with('user')->get()
        $interns = [
            [
                'name' => 'Test Intern One',
                'student_number' => '2021-00123',
                'status' => 'Present',
                'time_in' => '08:02 AM',
                'time_out' => null,
                'current_hours' => 128.5,
                'required_hours' => 486,
            ],
            [
                'name' => 'Test Intern Two',
                'student_number' => '2021-00456',
                'status' => 'Absent',
                'time_in' => null,
                'time_out' => null,
                'current_hours' => 96.0,
                'required_hours' => 486,
            ],
            [
                'name' => 'Test Intern Three',
                'student_number' => '2021-00789',
                'status' => 'Late',
                'time_in' => '09:41 AM',
                'time_out' => null,
                'current_hours' => 140.25,
                'required_hours' => 486,
            ],
        ];

        $summary = [
            'total_interns' => count($interns),
            'present_today' => collect($interns)->whereIn('status', ['Present', 'Late'])->count(),
            'absent_today' => collect($interns)->where('status', 'Absent')->count(),
        ];

        return Inertia::render('supervisor/dashboard', [
            'interns' => $interns,
            'summary' => $summary,
        ]);
    }
}