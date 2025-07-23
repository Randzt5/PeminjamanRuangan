<?php

namespace App\Listeners;

use App\Events\PengajuanBaruDibuat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanBaruUntukAdmin;
class KirimNotifikasiKeAdmin
{
    public function handle(PengajuanBaruDibuat $event): void
    {
        $peminjaman = $event->peminjaman;
        $pemohon = $peminjaman->user;
        $role_target = 'BIMA';

        $admins = User::whereHas('role', function ($query) use ($role_target) {
            $query->where('name', $role_target);
        })->get();

        $pesan = "Pengajuan baru '{$peminjaman->nama_kegiatan}' dari {$pemohon->name} memerlukan verifikasi Anda.";

        foreach ($admins as $admin) {
            // Membuat notifikasi internal (kode yang sudah ada)
            Notifikasi::create([
                'user_id' => $admin->id,
                'peminjaman_id' => $peminjaman->id,
                'pesan' => $pesan,
            ]);

            // LOGIKA BARU: Kirim email ke setiap admin BIMA
            if ($admin->email) {
                Mail::to($admin->email)->send(new PengajuanBaruUntukAdmin($peminjaman));
            }
        }
    }
}