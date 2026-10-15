<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'address',
        'district',
        'postal_code',
        'description',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function cagarBudayas(): HasMany
    {
        return $this->hasMany(CagarBudaya::class);
    }
}
