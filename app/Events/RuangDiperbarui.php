<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

// Sinyal "ruangan ini berubah". Isinya cuma kode ruangan; data lengkapnya diambil browser lewat /sinkron.
class RuangDiperbarui implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public string $kode)
    {
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('ruang.'.$this->kode)];
    }

    public function broadcastAs(): string
    {
        return 'diperbarui';
    }
}