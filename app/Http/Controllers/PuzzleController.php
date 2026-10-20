<?php

namespace App\Http\Controllers;

use App\Models\TebakGambar;
use Illuminate\Http\Request;

class PuzzleController extends Controller
{
    // Jumlah soal tiap permainan
    private const JUMLAH_SOAL = 10;

    // Folder gambar tebak gambar (di dalam folder public)
    private const FOLDER = 'images/games/tebak-gambar';

    // Halaman permainan Musiverse Puzzle: ambil 10 soal acak dari database
    public function main(Request $request)
    {
        $ruang = strtoupper((string) $request->query('ruang'));
        $ronde = (string) $request->query('ronde');

        $semua = TebakGambar::orderBy('id')->get();

        // Main bersama: urutan acak dikunci dari kode ruang + ronde,
        // jadi refresh halaman tidak mengganti soal. Main sendiri tetap acak.
        $soal = ($ruang !== '' && $ronde !== '')
            // Urutan dikunci: tiap soal diberi nilai tetap dari kode ruang + ronde + id soal,
            // lalu diurutkan. Hasilnya sama setiap kali halaman dimuat, di browser mana pun.
            ? $semua->sortBy(fn ($t) => crc32($ruang . '|' . $ronde . '|' . $t->id))
            : $semua->shuffle();
        $soal = $soal
            ->take(self::JUMLAH_SOAL)
            ->map(fn ($t) => [
'gambar' => asset(self::FOLDER.'/'.rawurlencode($t->gambar)),
                'jawaban' => $t->jawaban,
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
