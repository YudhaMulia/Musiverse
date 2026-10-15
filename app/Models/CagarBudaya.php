<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CagarBudaya extends Model
{
    protected $table = 'cagar_budayas';

    protected $fillable = [
        'name',
        'slug',
        'era_id',
        'location_id',
        'short_description',
        'full_description',
        'registration_number',
        'architect',
        'year_built',
        'original_function',
        'current_function',
        'status',
        'image_url',
        'local_image_path',
        'ai_reconstruction_url',
        'is_featured',
        'view_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function era(): BelongsTo
    {
        return $this->belongsTo(Era::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function audioTours(): HasMany
    {
        return $this->hasMany(AudioTour::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
