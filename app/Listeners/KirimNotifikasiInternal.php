<?php

namespace App\Listeners;

use App\Events\PeminjamanStatusDiubah;
use App\Models\Notifikasi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail; // <-- Import Mail facade
use App\Mail\PeminjamanStatusUpdated; // <-- Import Mailable kita

class KirimNotifikasiInternal
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PeminjamanStatusDiubah $event): void
    {
        $peminjaman = $event->peminjaman;

        // 1. Logika untuk notifikasi internal (yang sudah ada)
        $pesan = "Status pengajuan '{$peminjaman->nama_kegiatan}' Anda telah diperbarui menjadi: '{$peminjaman->status}'.";
        Notifikasi::create([
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'pesan' => $pesan,
        ]);

        // 2. LOGIKA BARU UNTUK MENGIRIM EMAIL
        $penerima = $peminjaman->user; // Dapatkan objek user penerima

        // Kirim email jika user punya alamat email
        if ($penerima && $penerima->email) {
            Mail::to($penerima->email)->send(new PeminjamanStatusUpdated($peminjaman));
        }
    }
}