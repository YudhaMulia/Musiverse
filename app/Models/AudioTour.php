<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioTour extends Model
{
    protected $fillable = [
        'cagar_budaya_id',
        'title',
        'narration',
        'audio_file_url',
        'duration_seconds',
        'narrator',
        'language',
    ];

    public function cagarBudaya(): BelongsTo
    {
        return $this->belongsTo(CagarBudaya::class);
    }
}
