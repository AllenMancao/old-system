<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AttendanceTestSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Test Supervisor',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'intern1@example.com'],
            [
                'name' => 'Test Intern One',
                'password' => Hash::make('password'),
                'role' => 'intern',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'intern2@example.com'],
            [
                'name' => 'Test Intern Two',
                'password' => Hash::make('password'),
                'role' => 'intern',
                'email_verified_at' => now(),
            ]
        );
    }
}