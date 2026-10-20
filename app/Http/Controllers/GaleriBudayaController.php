<?php

namespace App\Http\Controllers;

use App\Models\MuseumItem;

class GaleriBudayaController extends Controller
{
    public function index()
    {
        // 3 budaya populer untuk bagian paling atas (hero)
        $unggulan = MuseumItem::where('is_featured', true)
            ->orderBy('id')
            ->get();

        // Semua koleksi, dikelompokkan per kategori
        // Hasilnya seperti: ['kuliner' => [...], 'kain' => [...], dst]
        $perKategori = MuseumItem::orderBy('id')
            ->get()
            ->groupBy('kategori');

        return view('galeri-budaya.index', compact('unggulan', 'perKategori'));
    }
}