<?php

namespace App\Listeners;

use App\Events\BimaMenyetujui;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanUntukPic; // <-- Import Mailable baru

class KirimNotifikasiKePic
{
    public function handle(BimaMenyetujui $event): void
    {
        $peminjaman = $event->peminjaman;
        $pemohon = $peminjaman->user;
        $role_target = 'PIC Ruangan';

        $pic_users = User::whereHas('role', function ($query) use ($role_target) {
            $query->where('name', $role_target);
        })->get();

        $pesan = "Pengajuan '{$peminjaman->nama_kegiatan}' dari {$pemohon->name} telah diverifikasi BIMA dan memerlukan persetujuan final dari Anda.";

        foreach ($pic_users as $pic) {
            Notifikasi::create([
                'user_id' => $pic->id,
                'peminjaman_id' => $peminjaman->id,
                'pesan' => $pesan,
            ]);

            // AKTIFKAN BARIS INI
            if ($pic->email) {
                Mail::to($pic->email)->send(new PengajuanUntukPic($peminjaman));
            }
        }
    }
}