<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CagarBudayaController;
use App\Http\Controllers\AudioTourController;
use App\Http\Controllers\Admin\CagarBudayaAdminController;
use App\Http\Controllers\Api\CagarBudayaApiController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('welcome'); // Landing page
Route::get('/home', [HomeController::class, 'index'])->name('home'); // Halaman home asli

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login'); // Assuming you have a login view
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::prefix('cagar-budaya')->group(function () {
    Route::get('/', [CagarBudayaController::class, 'index'])->name('cagar-budaya.index');
    Route::get('/{slug}', [CagarBudayaController::class, 'show'])->name('cagar-budaya.show');
});

Route::prefix('audio-tour')->group(function () {
    Route::get('/{cagarBudaya}', [AudioTourController::class, 'show'])->name('audio-tour.show');
    Route::get('/play/{id}', [AudioTourController::class, 'play'])->name('audio-tour.play');
});

// Review Routes
Route::prefix('review')->middleware('auth')->group(function () {
    Route::get('/create/{cagarBudaya}', [\App\Http\Controllers\ReviewController::class, 'create'])->name('review.create');
    Route::post('/store/{cagarBudaya}', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
    Route::get('/{review}/edit', [\App\Http\Controllers\ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('review.update');
    Route::delete('/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('review.destroy');
    Route::delete('/photo/{photoId}', [\App\Http\Controllers\ReviewController::class, 'deletePhoto'])->name('review.deletePhoto');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('cagar-budaya')->name('cagar-budaya.')->group(function () {
        Route::get('/', [CagarBudayaAdminController::class, 'index'])->name('index');
        Route::get('/{cagarBudaya}/edit', [CagarBudayaAdminController::class, 'edit'])->name('edit');
        Route::post('/{cagarBudaya}/upload-image', [CagarBudayaAdminController::class, 'updateImage'])->name('update-image');
        Route::delete('/{cagarBudaya}/image', [CagarBudayaAdminController::class, 'destroy'])->name('destroy-image');
    });
});

Route::prefix('api')->group(function () {
    Route::get('/cagar-budaya', [CagarBudayaApiController::class, 'index']);
    Route::get('/cagar-budaya/era/{eraSlug}', [CagarBudayaApiController::class, 'filterByEra']);
    Route::get('/cagar-budaya/search', [CagarBudayaApiController::class, 'search']);
    Route::get('/cagar-budaya/nearby', [CagarBudayaApiController::class, 'getNearby']);
});
