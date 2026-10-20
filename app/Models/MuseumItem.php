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

    // Alamat gambar dihitung ulang tiap halaman dibuka,
    // supaya ikut domain yang sedang dipakai (localhost, tunnel, atau hosting)
    public function getImageUrlAttribute($value)
    {
        if (! $value) {
            return null;
        }

        // Ambil path-nya saja, misalnya "images/galeri/xxx.jpg"
        $path = ltrim(parse_url($value, PHP_URL_PATH) ?? '', '/');

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        // Gambar dari luar (misalnya picsum.photos) dibiarkan apa adanya
        return $value;
    }
}