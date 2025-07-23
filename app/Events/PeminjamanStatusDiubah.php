<?php

namespace App\Events;

use App\Models\Peminjaman; // <-- Import Peminjaman
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PeminjamanStatusDiubah
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $peminjaman; // <-- Buat properti publik

    /**
     * Create a new event instance.
     */
    public function __construct(Peminjaman $peminjaman) // <-- Terima data Peminjaman
    {
        $this->peminjaman = $peminjaman; // <-- Simpan datanya
    }
}