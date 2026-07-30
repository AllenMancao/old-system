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
        $internProfile = $request->user()
            ->internProfile()
            ->with(['course', 'hteUnit.supervisor'])
            ->first();

        if (! $internProfile) {
            return Inertia::render('intern/profile', [
                'profile' => null,
            ]);
        }

        $profile = [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'student_number' => $internProfile->student_number,
            'course' => $internProfile->course->course_name,
            'company' => $internProfile->hteUnit->unit_name ?? 'Not yet assigned',
            'supervisor' => $internProfile->hteUnit->supervisor->name ?? 'Not yet assigned',
            'year_level' => 4, // TODO: no year_level column exists on intern_profiles yet — flagged to Suboan
            'start_date' => $internProfile->start_date?->toDateString(),
            'end_date' => $internProfile->end_date?->toDateString(),
            'required_hours' => $internProfile->required_hours,
            'current_hours' => (float) $internProfile->current_hours,
            'status' => $internProfile->status,
        ];

        return Inertia::render('intern/profile', [
            'profile' => $profile,
        ]);
    }
}