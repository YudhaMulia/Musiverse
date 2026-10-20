<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Visit extends Model
{
    protected $fillable = [
        'user_id', 'site_slug', 'story', 'rating', 'frame',
        'stickers', 'nearby', 'points', 'visited_at',
    ];

    protected $casts = [
        'stickers'   => 'array',
        'nearby'     => 'boolean',
        'visited_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(VisitPhoto::class)->orderBy('sort_order');
    }

    /** Bentuk data yang dibaca oleh peta (JavaScript). */
    public function toMap(): array
    {
    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('foto');

        return [
            'story'    => $this->story ?? '',
            'rating'   => $this->rating ?? 0,
            'frame'    => $this->frame ?: 'polaroid',
            'stickers' => $this->stickers ?? [],
            'nearby'   => (bool) $this->nearby,
            'points'   => $this->points,
            'at'       => ($this->visited_at ?? now())->getTimestamp() * 1000,
            'photos'   => $this->photos->map(fn ($p) => $disk->url($p->path))->all(),
        ];
    }
}