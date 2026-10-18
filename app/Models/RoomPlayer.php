<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['room_id', 'user_id', 'name', 'avatar', 'is_bot', 'is_host'])]
class RoomPlayer extends Model
{
    protected function casts(): array
    {
        return [
            'is_bot'  => 'boolean',
            'is_host' => 'boolean',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}