<?php

namespace App\Http\Controllers;

use App\Models\KuisQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Jumlah soal tiap permainan
    private const JUMLAH_SOAL = 15;

    // Halaman permainan Musiverse Quiz: ambil 15 soal acak dari database
    public function main(Request $request)
    {
        // Main bersama: acakannya "dikunci" oleh kode ruangan + ronde, jadi saat halaman
        // di-refresh, soal & urutan pilihannya SAMA PERSIS (tidak berubah).
        // Main sendiri (tanpa kode ruangan): tetap acak biasa.
        $ruang = strtoupper((string) $request->query('ruang'));
        if ($ruang !== '') {
            mt_srand(crc32($ruang.'|'.$request->query('ronde')));
        }

        $semua = KuisQuestion::orderBy('id')->get()->all();
        shuffle($semua);

        $soal = collect(array_slice($semua, 0, self::JUMLAH_SOAL))
            ->map(function ($q) {
                // Kumpulkan 4 pilihan, lalu acak urutannya supaya huruf A-D
                // jawaban benar tidak selalu di tempat yang sama.
                $pilihan = [
                    'a' => $q->opsi_a,
                    'b' => $q->opsi_b,
                    'c' => $q->opsi_c,
                    'd' => $q->opsi_d,
                ];
                $kunci = array_keys($pilihan);
                shuffle($kunci);

                $opsi = [];
                $benar = 0;   // posisi jawaban benar (0 = A, 1 = B, 2 = C, 3 = D)
                foreach ($kunci as $posisi => $huruf) {
                    $opsi[] = $pilihan[$huruf];
                    if ($huruf === $q->jawaban_benar) {
                        $benar = $posisi;
                    }
                }

                return [
                    'id'         => $q->id,
                    'kategori'   => $q->kategori,
                    'pertanyaan' => $q->pertanyaan,
                    'opsi'       => $opsi,
                    'benar'      => $benar,
                    'penjelasan' => $q->penjelasan,
                ];
            })
            ->values();

         mt_srand();   

        // Kalau tabel masih kosong, beri pesan yang jelas (bukan halaman rusak)
        abort_if(
            $soal->isEmpty(),
            503,
            'Soal kuis belum ada. Jalankan: php artisan db:seed --class=KuisQuestionSeeder'
        );

        return view('games.quiz', ['soal' => $soal]);
    }
}