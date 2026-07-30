<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Course;
use App\Models\InternProfile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'contact_number' => ['required', 'string', 'max:20'],
            'sex' => ['required', 'in:Male,Female'],
            'department_id' => ['required', 'exists:departments,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'student_number' => ['required', 'string', 'max:50', 'unique:intern_profiles,student_number'],
            'password' => $this->passwordRules(),
        ])->validate();

        $course = Course::findOrFail($input['course_id']);

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'contact_number' => $input['contact_number'],
            'sex' => $input['sex'],
            'department_id' => $input['department_id'],
            'role' => 'intern',
            'password' => $input['password'],
        ]);

        InternProfile::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'student_number' => $input['student_number'],
            'required_hours' => $course->required_hours,
        ]);

        return $user;
    }
}