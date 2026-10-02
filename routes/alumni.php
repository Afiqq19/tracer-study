<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Alumni Routes
|--------------------------------------------------------------------------
| Semua route alumni dengan prefix /alumni dan middleware auth, verified, role:alumni, alumni.disetujui.
*/

Route::middleware(['role:alumni', 'alumni.disetujui'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Alumni\DashboardController::class, 'index'])
        ->name('dashboard');

    // Data Diri
    Route::get('/data-diri', [\App\Http\Controllers\Alumni\DataDiriController::class, 'index'])
        ->name('data-diri.index');
    Route::get('/data-diri/edit', [\App\Http\Controllers\Alumni\DataDiriController::class, 'edit'])
        ->name('data-diri.edit');
    Route::put('/data-diri', [\App\Http\Controllers\Alumni\DataDiriController::class, 'update'])
        ->name('data-diri.update');

    // Status Kegiatan (Saat Ini)
    Route::get('/status-kegiatan', [\App\Http\Controllers\Alumni\StatusKegiatanController::class, 'index'])
        ->name('status-kegiatan.index');
    Route::get('/status-kegiatan/create', [\App\Http\Controllers\Alumni\StatusKegiatanController::class, 'create'])
        ->name('status-kegiatan.create');
    Route::post('/status-kegiatan', [\App\Http\Controllers\Alumni\StatusKegiatanController::class, 'store'])
        ->name('status-kegiatan.store');
    Route::delete('/status-kegiatan/{id}', [\App\Http\Controllers\Alumni\StatusKegiatanController::class, 'destroy'])
        ->name('status-kegiatan.destroy');

    // Kuesioner
    Route::get('/kuesioner', [\App\Http\Controllers\Alumni\KuesionerController::class, 'index'])
        ->name('kuesioner.index');
    Route::get('/kuesioner/{kuesioner}/isi', [\App\Http\Controllers\Alumni\KuesionerController::class, 'show'])
        ->name('kuesioner.show');
    Route::post('/kuesioner/{kuesioner}/kirim', [\App\Http\Controllers\Alumni\KuesionerController::class, 'store'])
        ->name('kuesioner.store');

    // Riwayat Pengisian
    Route::get('/riwayat', [\App\Http\Controllers\Alumni\KuesionerController::class, 'riwayat'])
        ->name('riwayat.index');

    // Pengumuman
    Route::get('/pengumuman', [\App\Http\Controllers\Alumni\PengumumanController::class, 'index'])
        ->name('pengumuman.index');
    Route::get('/pengumuman/{pengumuman}', [\App\Http\Controllers\Alumni\PengumumanController::class, 'show'])
        ->name('pengumuman.show');

    // Akun (Ubah Password)
    Route::get('/akun', [\App\Http\Controllers\Alumni\AkunController::class, 'index'])
        ->name('akun.index');
    Route::put('/akun/password', [\App\Http\Controllers\Alumni\AkunController::class, 'updatePassword'])
        ->name('akun.password');
});
