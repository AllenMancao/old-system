<?php

use App\Http\Controllers\Intern\InternProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:intern'])->group(function () {
    Route::get('intern/profile', [InternProfileController::class, 'index'])->name('intern.profile');
});