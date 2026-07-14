<?php

use App\Http\Controllers\Attendance\InternScanController;
use App\Http\Controllers\Attendance\SupervisorAttendanceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:supervisor'])->group(function () {
    Route::get('supervisor/attendance', [SupervisorAttendanceController::class, 'index'])->name('supervisor.attendance');
    Route::post('supervisor/attendance/qr', [SupervisorAttendanceController::class, 'generateQr'])->name('supervisor.attendance.qr');
});

Route::middleware(['auth', 'verified', 'role:intern'])->group(function () {
    Route::get('intern/scan', [InternScanController::class, 'index'])->name('intern.scan');
    Route::post('intern/scan', [InternScanController::class, 'store'])->name('intern.scan.store');
});