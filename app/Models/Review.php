<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'cagar_budaya_id',
        'rating',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cagarBudaya(): BelongsTo
    {
        return $this->belongsTo(CagarBudaya::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ReviewPhoto::class);
    }
}
