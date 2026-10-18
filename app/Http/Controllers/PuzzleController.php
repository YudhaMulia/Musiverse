<?php

namespace App\Http\Controllers;

use App\Models\TebakGambar;

class PuzzleController extends Controller
{
    // Jumlah soal tiap permainan
    private const JUMLAH_SOAL = 10;

    // Folder gambar tebak gambar (di dalam folder public)
    private const FOLDER = 'images/games/tebak-gambar';

    // Halaman permainan Musiverse Puzzle: ambil 10 soal acak dari database
    public function main()
    {
        $soal = TebakGambar::inRandomOrder()
            ->limit(self::JUMLAH_SOAL)
            ->get()
            ->map(fn ($t) => [
                'gambar'     => asset(self::FOLDER . '/' . rawurlencode($t->gambar)),
                'jawaban'    => $t->jawaban,
                'penjelasan' => $t->penjelasan,   // dipakai halaman rekap
            ])
            ->values();

        // Kalau tabel masih kosong, beri pesan yang jelas (bukan halaman rusak)
        abort_if(
            $soal->isEmpty(),
            503,
            'Soal belum ada. Jalankan: php artisan db:seed --class=TebakGambarSeeder'
        );

        return view('games.puzzle', ['soal' => $soal]);
    }
}