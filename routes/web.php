<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manajemen\ManajemenController;
use Illuminate\Support\Facades\Route;

Route::prefix('docs_engine')->group(function () {
    // Home route (Dashboard)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Authentication routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Password reset routes
    Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
    Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
    Route::get('/password/email', [AuthController::class, 'showEmailForm'])->name('password.email');

    // Protected routes - these require authentication
    Route::middleware('auth')->group(function () {
        // Add your protected routes here
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        // Add other protected routes as needed
        //ManajemenGroup
        Route::get('/manajemen', [ManajemenController::class, 'index'])->name('manajemen.index');
    });
});