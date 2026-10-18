<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'game', 'host_id', 'status', 'started_at'])]
class Room extends Model
{
    public const MAKS_PEMAIN = 4;

    protected function casts(): array
    {
        return ['started_at' => 'datetime'];
    }

    // Alamat ruangan memakai kode, bukan id: /ruang/BDY7K2
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(RoomPlayer::class)->orderBy('id');
    }

    public function sedangMenunggu(): bool
    {
        return $this->status === 'waiting';
    }

    // 6 karakter acak, tanpa huruf/angka yang mirip (O, 0, I, 1), dan belum dipakai ruangan lain
    public static function buatKode(): string
    {
        $huruf = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        do {
            $kode = '';
            for ($i = 0; $i < 6; $i++) {
                $kode .= $huruf[random_int(0, strlen($huruf) - 1)];
            }
        } while (static::where('code', $kode)->exists());

        return $kode;
    }
}