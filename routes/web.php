<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manajemen\ManajemenController;
use App\Http\Controllers\Manajemen\MKategoriController;
use App\Http\Controllers\Manajemen\MModulController;
use App\Http\Controllers\Manajemen\MPostsController;
use App\Http\Controllers\Posts\DokController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/docs');
});

Route::prefix('docs_engine')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('');
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

        Route::get('/', [HomeController::class, 'index'])->name('empty');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/manajemen', [ManajemenController::class, 'index'])->name('manajemen.index');


        // KATEGORI MANAJEMEN
        Route::post('/storekategori', [MKategoriController::class, 'store'])->name('storekategori');
        Route::delete('/destroykategori/{id}', [MKategoriController::class, 'destroy'])->name('destroykategori');
        Route::put('/updatekategori/{id}', [MKategoriController::class, 'update'])->name('updatekategori');
        Route::get('/kategori/data', [MKategoriController::class, 'getKategori'])->name('datakategori');


        // MODUL MANAJEMEN
        Route::post('/storemodul', [MModulController::class, 'store'])->name('storemodul');
        Route::delete('/destroymodul/{id}', [MModulController::class, 'destroy'])->name('destroymodul');
        Route::put('/updatemodul/{id}', [MModulController::class, 'update'])->name('updatemodul');
        Route::get('/modul/data', [MModulController::class, 'getModul'])->name('datamodul');

        // KONTEN MANAJEMEN
        Route::post('/storekonten', [MPostsController::class, 'store'])->name('storekonten');
        Route::delete('/destroykonten/{id}', [MPostsController::class, 'destroy'])->name('destroykonten');
        Route::put('/updatekonten/{id}', [MPostsController::class, 'update'])->name('updatekonten');
        Route::get('/konten/data', [MPostsController::class, 'getPosts'])->name('datakonten');

        // BUAT POST
        Route::get('/buatpost', [DokController::class, 'index'])->name('buatpost');
    });
});