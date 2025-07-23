<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JadwalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rute ini akan bisa diakses melalui URL /api/jadwal
Route::get('/jadwal', [JadwalController::class, 'index']);

// TAMBAHKAN RUTE INI: untuk mengecek ketersediaan jam di form
Route::get('/cek-ketersediaan', [JadwalController::class, 'cekKetersediaan']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});