<?php

namespace App\Http\Controllers;

use App\Models\KartuMatch;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    // Halaman permainan Musiverse Match: ambil semua kartu dari database
    // (JavaScript yang memilih 18 pasang acak dari kartu-kartu ini)
    public function main(Request $request)
    {
        // Main sendiri belum punya penanda ronde: buatkan satu, lalu muat ulang halaman
        // dengan penanda itu di alamatnya. Penanda ini dipakai JavaScript sebagai nama
        // simpanan, supaya permainan bisa dilanjutkan saat halaman di-refresh.
        if ($request->query('ruang') === null && $request->query('ronde') === null) {
            return redirect()->to($request->fullUrlWithQuery([
                'ronde' => (string) (time() * 1000 + random_int(0, 999)),
            ]));
        }

        $kartu = KartuMatch::orderBy('nomor')
            ->get()
            ->map(fn ($k) => [
                'id' => $k->id,
                'nama' => $k->nama,
                'kategori' => $k->kategori,
                'penjelasan' => $k->penjelasan,
                'gambar' => asset(sprintf('images/games/match/%02d-%s.svg', $k->nomor, $k->slug)),
            ])
            ->values();

        abort_if(
            $kartu->count() < 18,
            503,
            'Kartu belum ada. Jalankan: php artisan db:seed --class=KartuMatchSeeder'
        );

        return view('games.match', [
            'kartu' => $kartu,
            'namaPemain' => auth()->check() ? auth()->user()->name : 'Pemain 1',
        ]);
    }
}
