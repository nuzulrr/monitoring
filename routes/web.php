<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjekController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Root Route: Redirect berdasarkan status login
Route::get('/', function () {
    return auth()->check() ? redirect('/home') : redirect('/login');
});

// 2. Guest Only: Hanya bisa diakses sebelum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
    // Opsional: Jika kamu butuh register
     Route::post('/register', [LoginController::class, 'register'])->name('register');
});

// 3. Auth Only: Harus login untuk akses dashboard dan data
Route::middleware('auth')->group(function () {
    
    // Dashboard & Home
    Route::get('/home', [SiteController::class, 'index'])->name('home');
    
    // Monitoring API
    Route::get('/api/check-status', [SiteController::class, 'checkStatus'])->name('check.status');

    // Data Management (Projek & Site)
    Route::post('/projek', [ProjekController::class, 'store'])->name('projek.store');
    Route::post('/site', [SiteController::class, 'store'])->name('site.store');
    Route::put('/sites/{id_site}', [SiteController::class, 'update'])->name('sites.update');
    Route::delete('/sites/{id_site}', [SiteController::class, 'destroy'])->name('sites.destroy');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});