<?php

namespace App\Http\Controllers;

use App\Models\KartuMatch;

class MatchController extends Controller
{
    // Halaman permainan Musiverse Match: ambil semua kartu dari database
    // (JavaScript yang memilih 18 pasang acak dari kartu-kartu ini)
    public function main()
    {
        $kartu = KartuMatch::orderBy('nomor')
            ->get()
            ->map(fn ($k) => [
                'id'         => $k->id,
                'nama'       => $k->nama,
                'kategori'   => $k->kategori,
                'penjelasan' => $k->penjelasan,
                'gambar'     => asset(sprintf('images/games/match/%02d-%s.svg', $k->nomor, $k->slug)),
            ])
            ->values();

        abort_if(
            $kartu->count() < 18,
            503,
            'Kartu belum ada. Jalankan: php artisan db:seed --class=KartuMatchSeeder'
        );

        return view('games.match', [
            'kartu'      => $kartu,
            'namaPemain' => auth()->check() ? auth()->user()->name : 'Pemain 1',
        ]);
    }
}