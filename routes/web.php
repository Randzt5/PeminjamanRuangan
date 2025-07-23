<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BimaController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Api\JadwalController;

Route::middleware('web')->group(function () {

    // Rute untuk tamu (belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/', [AuthController::class, 'showLoginForm']);
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Rute yang memerlukan login
    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/notifikasi/baca/{notifikasi}', [NotifikasiController::class, 'tandaiSudahDibaca'])->name('notifikasi.baca');

        // --- RUTE UNTUK KALENDER DAN API-NYA ---
        Route::get('/jadwal-ruangan', function() {
            return view('jadwal.index');
        })->name('jadwal.index');

        Route::get('/api/cek-ketersediaan', [JadwalController::class, 'cekKetersediaan'])->name('api.cek-ketersediaan');

        // --- Rute Berdasarkan Peran ---
        Route::get('/bima/dashboard', [BimaController::class, 'index'])/*->middleware('role:BIMA')*/->name('bima.dashboard');Route::get('/bima/dashboard', [BimaController::class, 'index'])->middleware('role:BIMA')->name('bima.dashboard');
        Route::patch('/bima/verifikasi/{peminjaman}', [BimaController::class, 'verifikasi'])->middleware('role:BIMA')->name('bima.verifikasi');

        Route::get('/pic/dashboard', [PicController::class, 'index'])->middleware('role:PIC Ruangan')->name('pic.dashboard');
        Route::patch('/pic/approval/{peminjaman}', [PicController::class, 'finalApproval'])->middleware('role:PIC Ruangan')->name('pic.approval');

        // --- Grup Rute Admin ---
        Route::middleware('role:Admin')->prefix('admin')->name('admin.')->group(function () {
            Route::resource('ruangan', RuanganController::class);
            Route::resource('users', UserController::class);
            Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        });
    });
});