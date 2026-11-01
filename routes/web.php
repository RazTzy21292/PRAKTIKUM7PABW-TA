<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/', [AuthController::class, 'landing']);
Route::get('/landing', [AuthController::class, 'landing'])->name('landing');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/lokasi', [LokasiController::class, 'index']);
    Route::get('/point', [PointController::class, 'index']);


    Route::get('/edukasi', [EdukasiController::class, 'index']);
    Route::post('/edukasi/klaim/{id}', [EdukasiController::class, 'klaim']);


    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);


    Route::get('/foto/{path}', function (string $path) {
        abort_unless(Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response($path);
    })->where('path', 'laporan/[A-Za-z0-9._-]+')->name('foto.laporan');

    Route::resource('laporan', LaporanController::class)->except(['show']);


    Route::prefix('api')->group(function () {
        Route::get('/stats', [ApiController::class, 'stats']);
        Route::get('/tong', [ApiController::class, 'tong']);
        Route::get('/laporan', [ApiController::class, 'laporanIndex']);
        Route::post('/laporan', [ApiController::class, 'laporanStore']);
        Route::post('/laporan/delete/{id}', [ApiController::class, 'laporanDelete']);
        Route::get('/leaderboard', [ApiController::class, 'leaderboard']);
        Route::post('/edukasi/klaim/{id}', [ApiController::class, 'edukasiKlaim']);
        Route::get('/profile', [ApiController::class, 'profileShow']);
        Route::post('/profile', [ApiController::class, 'profileUpdate']);
    });
});