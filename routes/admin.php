<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Semua route admin dengan prefix /admin dan middleware auth, verified, role:admin.
*/

Route::middleware(['role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // Kelola User (Admin)
    Route::resource('/user', \App\Http\Controllers\Admin\UserController::class)
        ->except(['show']);

    // Data Alumni
    Route::get('/alumni/import', [\App\Http\Controllers\Admin\AlumniController::class, 'importForm'])
        ->name('alumni.import');
    Route::post('/alumni/import', [\App\Http\Controllers\Admin\AlumniController::class, 'importProcess'])
        ->name('alumni.import.process');
    Route::get('/alumni/export', [\App\Http\Controllers\Admin\AlumniController::class, 'export'])
        ->name('alumni.export');
    Route::get('/alumni/template', [\App\Http\Controllers\Admin\AlumniController::class, 'downloadTemplate'])
        ->name('alumni.template');
    Route::resource('/alumni', \App\Http\Controllers\Admin\AlumniController::class)
        ->parameters(['alumni' => 'alumni']);

    // Kuesioner
    Route::resource('/kuesioner', \App\Http\Controllers\Admin\KuesionerController::class);

    // Pertanyaan (nested di bawah kuesioner)
    Route::post('/kuesioner/{kuesioner}/pertanyaan', [\App\Http\Controllers\Admin\KuesionerController::class, 'storePertanyaan'])
        ->name('kuesioner.pertanyaan.store');
    Route::delete('/kuesioner/pertanyaan/{pertanyaan}', [\App\Http\Controllers\Admin\KuesionerController::class, 'destroyPertanyaan'])
        ->name('kuesioner.pertanyaan.destroy');

    // Verifikasi Alumni
    Route::get('/verifikasi', [\App\Http\Controllers\Admin\VerifikasiController::class, 'index'])
        ->name('verifikasi.index');
    Route::post('/verifikasi/{alumni}/setujui', [\App\Http\Controllers\Admin\VerifikasiController::class, 'setujui'])
        ->name('verifikasi.setujui');
    Route::post('/verifikasi/{alumni}/tolak', [\App\Http\Controllers\Admin\VerifikasiController::class, 'tolak'])
        ->name('verifikasi.tolak');

    // Hasil Kuesioner
    Route::get('/hasil', [\App\Http\Controllers\Admin\HasilKuesionerController::class, 'index'])
        ->name('hasil.index');
    Route::get('/hasil/{kuesioner}', [\App\Http\Controllers\Admin\HasilKuesionerController::class, 'show'])
        ->name('hasil.show');
    Route::get('/hasil/{kuesioner}/alumni/{pengisian}', [\App\Http\Controllers\Admin\HasilKuesionerController::class, 'detail'])
        ->name('hasil.detail');

    // Grafik Statistik
    Route::get('/statistik', [\App\Http\Controllers\Admin\StatistikController::class, 'index'])
        ->name('statistik.index');

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])
        ->name('laporan.index');
    Route::get('/laporan/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])
        ->name('laporan.pdf');
    Route::get('/laporan/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])
        ->name('laporan.excel');

    // Pengumuman
    Route::resource('/pengumuman', \App\Http\Controllers\Admin\PengumumanController::class)
        ->except(['show']);

    // Master Data
    Route::resource('/master/jurusan', \App\Http\Controllers\Admin\MasterDataController::class)
        ->names('master.jurusan')
        ->parameters(['jurusan' => 'jurusan']);
    Route::resource('/master/tahun-lulus', \App\Http\Controllers\Admin\MasterDataController::class)
        ->names('master.tahun-lulus')
        ->parameters(['tahun-lulus' => 'tahunLulus']);

    // Log Aktivitas
    Route::get('/log', [\App\Http\Controllers\Admin\LogAktivitasController::class, 'index'])
        ->name('log.index');

    // Profil Admin
    Route::get('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'index'])
        ->name('profil.index');
    Route::put('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'update'])
        ->name('profil.update');
    Route::put('/profil/password', [\App\Http\Controllers\Admin\ProfilController::class, 'updatePassword'])
        ->name('profil.password');
});
