<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
    ...$this->profileRules(),

    'contact_number' => ['required', 'string', 'max:20'],

    'sex' => ['required', 'in:Male,Female'],

    'department_id' => ['required', 'exists:departments,id'],

    'section' => ['required', 'string', 'max:50'],

    'password' => $this->passwordRules(),

    ])->validate();

            return User::create([
        'name' => $input['name'],

        'email' => $input['email'],

        'contact_number' => $input['contact_number'],

        'sex' => $input['sex'],

        'department_id' => $input['department_id'],

        'section' => $input['section'],

        'password' => $input['password'],
    ]);
    }
}
