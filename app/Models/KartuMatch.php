<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuMatch extends Model
{
    protected $fillable = ['nomor', 'slug', 'nama', 'kategori', 'penjelasan'];
}
