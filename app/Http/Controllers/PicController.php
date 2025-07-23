<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Events\PeminjamanStatusDiubah;

class PicController extends Controller
{
    public function index(Request $request) // Jangan lupa tambahkan Request $request
    {
        $searchQuery = $request->query('search');

        // Targetnya adalah pengajuan yang SUDAH diverifikasi BIMA
        $query = Peminjaman::with(['user', 'ruangan'])
                           ->where('status', 'Telah Diverifikasi BIMA');

        if ($searchQuery) {
            $query->where('nama_kegiatan', 'like', '%' . $searchQuery . '%');
        }

        $daftar_pengajuan = $query->latest()->paginate(10);

        return view('pic.dashboard', [
            'daftar_pengajuan' => $daftar_pengajuan,
            'searchQuery' => $searchQuery
        ]);
}
    public function finalApproval(Request $request, Peminjaman $peminjaman)
{
    $request->validate([
        'aksi' => 'required|in:Setujui Final,Tolak Final',
        'catatan' => 'nullable|string|max:500',
    ]);

    if ($request->input('aksi') === 'Setujui Final') {
        $peminjaman->status = 'Disetujui';
    } else {
        $peminjaman->status = 'Ditolak oleh PIC';

        // JIKA DITOLAK DAN ADA CATATAN, GUNAKAN UPDATE OR CREATE
        if ($request->filled('catatan')) {
            $peminjaman->form()->updateOrCreate(
                ['peminjaman_id' => $peminjaman->id], // Kunci untuk mencari
                ['catatan' => $request->catatan]      // Data untuk di-update atau di-create
            );
        }
    }

    $peminjaman->save();
    event(new PeminjamanStatusDiubah($peminjaman));
    return redirect()->route('pic.dashboard')->with('success', 'Status pengajuan berhasil diberi keputusan final!');
}}