<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPenyakitController;
use App\Http\Controllers\AdminGejalaController;
use App\Http\Controllers\AdminAturanController;
use App\Http\Controllers\KonsultasiController;

Route::get('/', fn() => view('welcome'));

// ========= Admin =========
Route::prefix('admin')->group(function () {

    Route::resource('penyakit', AdminPenyakitController::class);
    Route::resource('gejala', AdminGejalaController::class);
    Route::resource('aturan', AdminAturanController::class);

});

// ========= Konsultasi User =========
Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
Route::post('/konsultasi/proses', [KonsultasiController::class, 'proses'])->name('konsultasi.proses');
Route::get('/konsultasi/{id}', [KonsultasiController::class, 'hasil'])->name('konsultasi.hasil');

