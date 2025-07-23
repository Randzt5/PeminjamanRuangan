<?php

namespace App\Http\Controllers;
use App\Events\PeminjamanStatusDiubah;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Events\BimaMenyetujui;

class BimaController extends Controller
{
    public function index(Request $request)
{
    $searchQuery = $request->query('search');

    // Mulai query dengan eager loading user dan ruangan
    $query = Peminjaman::with(['user', 'ruangan'])
                       ->where('status', 'Menunggu Verifikasi BIMA');

    // Jika ada input pencarian, tambahkan filter berdasarkan nama kegiatan
    if ($searchQuery) {
        $query->where('nama_kegiatan', 'like', '%' . $searchQuery . '%');
    }

    // Ambil data dengan pagination (10 per halaman)
    $daftar_pengajuan = $query->latest()->paginate(10);

    return view('bima.dashboard', [
        'daftar_pengajuan' => $daftar_pengajuan,
        'searchQuery' => $searchQuery
    ]);
}
    public function verifikasi(Request $request, Peminjaman $peminjaman)
{
    $request->validate([
        'aksi' => 'required|in:Setujui,Tolak',
        'catatan' => 'nullable|string|max:500',
    ]);

    if ($request->input('aksi') === 'Setujui') {
        // Blok jika disetujui
        $peminjaman->status = 'Telah Diverifikasi BIMA';
        $peminjaman->save(); // Simpan status baru

        // TEMBAKKAN EVENT BARU KHUSUS UNTUK PIC
        event(new BimaMenyetujui($peminjaman));

    } else {
        // Blok jika ditolak
        $peminjaman->status = 'Ditolak oleh BIMA';

        if ($request->filled('catatan')) {
            if ($peminjaman->form) {
                $peminjaman->form->update(['catatan' => $request->catatan]);
            } else {
                $peminjaman->form()->create(['catatan' => $request->catatan]);
            }
        }

        $peminjaman->save(); // Simpan status baru

        // TEMBAKKAN EVENT LAMA UNTUK MEMBERITAHU PENGGUNA
        event(new PeminjamanStatusDiubah($peminjaman));
    }

    return redirect()->route('bima.dashboard')->with('success', 'Status pengajuan berhasil diperbarui!');
}
}
