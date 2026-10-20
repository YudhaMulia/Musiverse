<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Get accessible audio file URL.
     */
    protected function audioFileUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                if (! $value) {
                    return null;
                }

                if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                    return $value;
                }

                return asset(ltrim($value, '/'));
            }
        );
    }

    public function cagarBudaya(): BelongsTo
    {
        return $this->belongsTo(CagarBudaya::class);
    }
}
