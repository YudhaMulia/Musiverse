<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Era extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_year',
        'end_year',
        'color_code',
    ];

    public function cagarBudayas(): HasMany
    {
        return $this->hasMany(CagarBudaya::class);
    }
}
