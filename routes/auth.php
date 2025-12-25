<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController; // Ini kita ganti perannya untuk login
use App\Http\Controllers\UserController; // <--- TAMBAHKAN INI (Controller buatan kita)
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    
    // --- 1. REGISTER (Tetap pakai bawaan) ---
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // --- 2. LOGIN (KITA UBAH PAKAI USER CONTROLLER) ---
    
    // Login Customer (Tampilan Pink - function index)
    Route::get('login', [UserController::class, 'index'])
        ->name('login');

    // Login Staff/Admin (Tampilan Formal - function staffLogin)
    Route::get('staff/login', [UserController::class, 'staffLogin'])
        ->name('staff.login');

    // Proses Login (Satu pintu untuk semua - function authenticate)
    Route::post('login', [UserController::class, 'authenticate']);

    // --------------------------------------------------

    // --- 3. PASSWORD RESET (Tetap pakai bawaan Breeze) ---
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Verifikasi Email
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Konfirmasi Password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Update Password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // --- 4. LOGOUT (KITA UBAH PAKAI USER CONTROLLER) ---
    Route::post('logout', [UserController::class, 'logout'])
        ->name('logout');
});