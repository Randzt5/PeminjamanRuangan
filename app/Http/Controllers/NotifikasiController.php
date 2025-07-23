<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function tandaiSudahDibaca(Notifikasi $notifikasi)
    {
        // Tandai notifikasi sebagai sudah dibaca
        $notifikasi->status_baca = true;
        $notifikasi->save();

        // Arahkan pengguna ke halaman detail peminjaman yang sesuai
        return redirect()->route('peminjaman.show', ['peminjaman' => $notifikasi->peminjaman_id]);
    }
}