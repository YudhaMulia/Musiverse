<?php

use App\Models\RoomPlayer;
use Illuminate\Support\Facades\Broadcast;

// Hanya pemain yang terdaftar di ruangan itu yang boleh mendengarkan channel-nya
Broadcast::channel('ruang.{code}', function ($user, string $code) {
    return RoomPlayer::where('user_id', $user->id)
        ->whereHas('room', fn ($q) => $q->where('code', $code))
        ->exists();
});