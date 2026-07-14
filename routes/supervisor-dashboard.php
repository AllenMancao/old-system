<?php

use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:supervisor'])->group(function () {
    Route::get('supervisor/dashboard', [SupervisorDashboardController::class, 'index'])->name('supervisor.dashboard');
});