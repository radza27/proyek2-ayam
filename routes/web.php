<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KendaliController;
use App\Http\Controllers\BatasAmbangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Login & Autentikasi
Route::get('/login', [DashboardController::class, 'showLogin'])->name('login');
Route::post('/login', [DashboardController::class, 'processLogin']);
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

// Route yang dilindungi middleware 'auth' (Menggunakan Controller Terpisah)
Route::middleware('auth')->group(function () {
    // Menu Dashboard Utama
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Menu Monitoring (Dipegang MonitoringController)
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');

    // Menu Riwayat Data (Dipegang RiwayatController)
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

    // Menu Kendali Aktuator (Dipegang KendaliController)
    Route::get('/aktuator', [KendaliController::class, 'index'])->name('aktuator');
    Route::post('/aktuator/{id}/toggle', [KendaliController::class, 'toggle'])->name('aktuator.toggle');

    // Menu Pengaturan Ambang Batas (Dipegang BatasAmbangController)
    Route::get('/pengaturan', [BatasAmbangController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan/update', [BatasAmbangController::class, 'update'])->name('ambang.update');
});

// Endpoint API untuk ESP32
Route::post('/api/sensor/store', [DashboardController::class, 'apiStoreSensor']);