<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAturanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminGejalaController;
use App\Http\Controllers\AdminPenyakitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\PenyakitController;

Route::get('/', fn() => view('welcome'))->name('home');

// ========= Halaman Publik =========
Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.public.index');
Route::get('/penyakit/{penyakit}', [PenyakitController::class, 'show'])->name('penyakit.public.show');

// ========= Auth Admin =========
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.attempt');
});
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

// ========= Admin =========
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('penyakit', AdminPenyakitController::class)->except(['show']);
    Route::resource('gejala', AdminGejalaController::class)->except(['show']);
    Route::resource('aturan', AdminAturanController::class)->only(['index', 'create', 'store', 'destroy']);
});

// ========= Konsultasi User =========
Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
Route::post('/konsultasi/proses', [KonsultasiController::class, 'proses'])->name('konsultasi.proses');
Route::get('/konsultasi/{id}', [KonsultasiController::class, 'hasil'])->name('konsultasi.hasil');
