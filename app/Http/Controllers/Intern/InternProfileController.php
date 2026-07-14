<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InternProfileController extends Controller
{
    public function index(Request $request): Response
    {
        // TODO: replace with real query once intern_profiles migration
        // (Suboan-Branch) is merged: IternProfile::where('user_id', $request->user()->id)->first()
        $profile = [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'student_number' => '2021-00123',
            'course' => 'BSIT - Business Technology Management',
            'company' => 'Sample Host Company Inc.',
            'supervisor' => 'Test Supervisor',
            'year_level' => 4,
            'start_date' => '2026-06-01',
            'end_date' => '2026-09-30',
            'required_hours' => 486,
            'current_hours' => 128.5,
            'status' => 'Active',
        ];

        return Inertia::render('intern/profile', [
            'profile' => $profile,
        ]);
    }
}