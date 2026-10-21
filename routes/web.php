<?php

use App\Http\Controllers\Api\CagarBudayaApiController;
use App\Http\Controllers\AudioTourController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CagarBudayaController;
use App\Http\Controllers\GaleriBudayaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;

Route::get('/', [LandingPageController::class, 'index'])->name('welcome'); // Landing page
Route::get('/home', [HomeController::class, 'index'])->name('home'); // Halaman home asli

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendLink'])->middleware('throttle:6,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Profil (wajib login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->middleware('throttle:6,1')->name('profile.password');
});

Route::prefix('cagar-budaya')->group(function () {
    Route::get('/', [CagarBudayaController::class, 'index'])->name('cagar-budaya.index');
    Route::get('/{slug}', [CagarBudayaController::class, 'show'])->name('cagar-budaya.show');
});

// Galeri Budaya (museum digital)
Route::get('/galeri-budaya', [GaleriBudayaController::class, 'index'])->name('galeri-budaya.index');

Route::prefix('audio-tour')->group(function () {
    Route::get('/{cagarBudaya}', [AudioTourController::class, 'show'])->name('audio-tour.show');
    Route::get('/play/{id}', [AudioTourController::class, 'play'])->name('audio-tour.play');
});

// Games: semua route games ada di routes/games.php
require __DIR__.'/games.php';

// Musik latar lewat Laravel, supaya browser bisa melompat ke detik tertentu
Route::get('/musik-latar', function () {
    return response()->file(public_path('audio/gending-sriwijaya.mp3'), [
        'Content-Type' => 'audio/mpeg',
    ]);
})->name('musik.latar');

// Review Routes
Route::prefix('review')->middleware('auth')->group(function () {
    Route::get('/create/{cagarBudaya}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/store/{cagarBudaya}', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::delete('/photo/{photoId}', [ReviewController::class, 'deletePhoto'])->name('review.deletePhoto');
});

Route::prefix('api')->group(function () {
    Route::get('/cagar-budaya', [CagarBudayaApiController::class, 'index']);
    Route::get('/cagar-budaya/era/{eraSlug}', [CagarBudayaApiController::class, 'filterByEra']);
    Route::get('/cagar-budaya/search', [CagarBudayaApiController::class, 'search']);
    Route::get('/cagar-budaya/nearby', [CagarBudayaApiController::class, 'getNearby']);
});

Route::middleware('auth')->group(function () {
    Route::post('/visits/{slug}', [VisitController::class, 'store']);
    Route::patch('/visits/{slug}/decor', [VisitController::class, 'decor']);
    Route::get('/visits/{slug}/reviews', [VisitController::class, 'reviews']);
});
