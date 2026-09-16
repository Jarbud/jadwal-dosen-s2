<?php

use App\Http\Controllers\JadwalController;
use Illuminate\Support\Facades\Route;

// Mengakses halaman utama langsung memanggil fungsi index di JadwalController
Route::get('/', [JadwalController::class, 'index'])->name('jadwal.index');