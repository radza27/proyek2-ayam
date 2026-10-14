<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\DashboardController;

// Route Halaman Utama & Menu Sesuai Mockup


// Route Halaman Login & Autentikasi
Route::get('/login', [DashboardController::class, 'showLogin'])->name('login');
Route::post('/login', [DashboardController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

// Route yang dilindungi middleware auth (hanya bisa diakses jika sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('monitoring');
    Route::get('/riwayat', [DashboardController::class, 'riwayat'])->name('riwayat');
    Route::get('/aktuator', [DashboardController::class, 'aktuator'])->name('aktuator');
    Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])->name('pengaturan');

    Route::post('/aktuator/{id}/toggle', [DashboardController::class, 'toggleAktuator'])->name('aktuator.toggle');
    Route::post('/pengaturan/update', [DashboardController::class, 'updateAmbang'])->name('ambang.update');
});