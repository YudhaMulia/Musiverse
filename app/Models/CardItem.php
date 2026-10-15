<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardItem extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'gambar',
        'deskripsi',
    ];
}
