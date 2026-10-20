<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuseumItem extends Model
{
    // Daftar kategori: 'slug di URL' => 'nama yang tampil'
    public const KATEGORI = [
        'permainan' => 'Permainan Tradisional',
        'kuliner'   => 'Kuliner',
        'pakaian'   => 'Pakaian Adat',
        'kain'      => 'Kain Tradisional',
        'seni-tari' => 'Seni dan Tari',
        'cerita'    => 'Cerita Rakyat',
        'kerajinan' => 'Kerajinan',
    ];
    
    // Kalimat pengantar di bawah judul tiap kategori
    public const KATEGORI_DESKRIPSI = [
        'permainan' => 'Permainan rakyat yang diwariskan dari generasi ke generasi.',
        'kuliner'   => 'Rasa khas Palembang yang membuat siapa pun ingin kembali.',
        'pakaian'   => 'Busana adat penuh makna, dari pengantin hingga penutup kepala.',
        'kain'      => 'Tenunan dan celupan yang dikerjakan dengan tangan dan kesabaran.',
        'seni-tari' => 'Gerak, musik, dan panggung yang menjaga cerita Palembang tetap hidup.',
        'cerita'    => 'Legenda yang diceritakan turun-temurun di tepian Sungai Musi.',
        'kerajinan' => 'Karya tangan yang lahir dari kayu, sungai, dan rawa.',
    ];

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'asal_daerah',
        'image_url',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    // Mengubah slug kategori jadi nama yang enak dibaca
    public function getNamaKategoriAttribute(): string
    {
        return self::KATEGORI[$this->kategori] ?? $this->kategori;
    }
}