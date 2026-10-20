<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Halaman Games (terbuka untuk semua)
Route::view('/games', 'games.index')->name('games.index');

// Ruang tunggu multiplayer (WAJIB LOGIN)
// Tombol "Main Bersama" -> /games/match/ruang-tunggu -> dialihkan ke /ruang/KODE
Route::middleware('auth')->group(function () {
    Route::get('/games/{game}/ruang-tunggu', [RoomController::class, 'masuk'])
        ->whereIn('game', ['match', 'quiz', 'puzzle'])->name('games.room');
    Route::post('/ruang/gabung', [RoomController::class, 'gabung'])->name('rooms.gabung');
    Route::get('/ruang/{room}/sinkron', [RoomController::class, 'sinkron'])->name('rooms.sinkron');

    Route::get('/ruang/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::put('/ruang/{room}/avatar', [RoomController::class, 'avatar'])->name('rooms.avatar');
    Route::post('/ruang/{room}/bot', [RoomController::class, 'tambahBot'])->name('rooms.bot');
    Route::delete('/ruang/{room}/pemain/{pemain}', [RoomController::class, 'hapusPemain'])->name('rooms.pemain.hapus');
    Route::post('/ruang/{room}/mulai', [RoomController::class, 'mulai'])->name('rooms.mulai');
    Route::get('/ruang/{room}/main-lagi', [RoomController::class, 'mainLagi'])->name('rooms.ulang');
    Route::post('/ruang/{room}/keluar', [RoomController::class, 'keluar'])->name('rooms.keluar');
});

// Musiverse Match
Route::get('/games/match/main', [MatchController::class, 'main'])->name('games.match.play');
Route::view('/games/match/rekap', 'games.match-rekap')->name('games.match.rekap');

// Musiverse Quiz (15 soal acak dari database)
Route::get('/games/quiz/main', [QuizController::class, 'main'])->name('games.quiz.play');
Route::view('/games/quiz/rekap', 'games.quiz-rekap')->name('games.quiz.rekap');

// Musiverse Puzzle (10 gambar acak dari folder)
Route::get('/games/puzzle/main', [PuzzleController::class, 'main'])->name('games.puzzle.play');
Route::view('/games/puzzle/rekap', 'games.puzzle-rekap')->name('games.puzzle.rekap');
