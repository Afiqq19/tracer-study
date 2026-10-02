<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Landing page dan halaman publik.
| Route auth, admin, dan alumni di-load dari bootstrap/app.php.
*/

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Redirect /dashboard berdasarkan role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('alumni.dashboard');
})->middleware(['auth'])->name('dashboard');

// Halaman menunggu verifikasi (untuk alumni yang belum disetujui)
Route::get('/menunggu-verifikasi', function () {
    return view('auth.menunggu-verifikasi');
})->middleware(['auth'])->name('menunggu.verifikasi');
