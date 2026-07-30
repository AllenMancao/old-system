<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\HTEUnit;
use App\Models\InternProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AttendanceTestSeeder extends Seeder
{
    public function run(): void
    {
        $supervisor = User::updateOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Test Supervisor',
                'password' => Hash::make('password'),
                'role' => 'hte_supervisor',
                'email_verified_at' => now(),
            ]
        );

        $course = Course::firstOrCreate(
            ['course_code' => 'BSIT-BTM'],
            [
                'course_name' => 'BSIT - Business Technology Management',
                'required_hours' => 486,
            ]
        );

        $hteUnit = HTEUnit::firstOrCreate(
            ['unit_name' => 'Sample Host Company Inc.'],
            ['hte_supervisor_id' => $supervisor->id]
        );

        $intern1 = User::updateOrCreate(
            ['email' => 'intern1@example.com'],
            [
                'name' => 'Test Intern One',
                'password' => Hash::make('password'),
                'role' => 'intern',
                'email_verified_at' => now(),
            ]
        );

        InternProfile::updateOrCreate(
            ['user_id' => $intern1->id],
            [
                'course_id' => $course->id,
                'hte_unit_id' => $hteUnit->id,
                'student_number' => '2021-00123',
                'start_date' => '2026-06-01',
                'end_date' => '2026-09-30',
                'required_hours' => $course->required_hours,
                'current_hours' => 0,
                'status' => 'Active',
            ]
        );

        $intern2 = User::updateOrCreate(
            ['email' => 'intern2@example.com'],
            [
                'name' => 'Test Intern Two',
                'password' => Hash::make('password'),
                'role' => 'intern',
                'email_verified_at' => now(),
            ]
        );

        InternProfile::updateOrCreate(
            ['user_id' => $intern2->id],
            [
                'course_id' => $course->id,
                'hte_unit_id' => $hteUnit->id,
                'student_number' => '2021-00124',
                'start_date' => '2026-06-01',
                'end_date' => '2026-09-30',
                'required_hours' => $course->required_hours,
                'current_hours' => 0,
                'status' => 'Active',
            ]
        );
    }
}