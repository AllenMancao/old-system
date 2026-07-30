<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $role = $request->user()->role;

        return match ($role) {
            'intern' => redirect()->intended('/intern/scan'),
            'hte_supervisor' => redirect()->intended('/supervisor/attendance'),
            default => redirect()->intended('/dashboard'),
        };
    }
}