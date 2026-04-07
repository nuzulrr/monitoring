<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjekController;
use App\Http\Controllers\SiteController;

Route::post('/projek', [ProjekController::class, 'store'])->name('projek.store');
Route::get('/', [SiteController::class, 'index']);
Route::post('/site', [SiteController::class, 'store'])->name('site.store');
Route::get('/api/check-status', [SiteController::class, 'checkStatus'])->name('check.status');