<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('ruangan')
                            ->where('status', 'Disetujui')
                            ->get();

        $events = $peminjaman->map(function ($item) {
            if ($item->ruangan) {
                return [
                    'title' => $item->ruangan->nama_ruangan . ' - ' . $item->nama_kegiatan,
                    'start' => Carbon::parse($item->tanggal_peminjaman . ' ' . $item->waktu_mulai)->toDateTimeString(),
                    'end' => Carbon::parse($item->tanggal_peminjaman . ' ' . $item->waktu_selesai)->toDateTimeString(),
                    'color' => '#28a745',
                    'textColor' => '#ffffff'
                ];
            }
            return null;
        })->filter();

        return response()->json($events);
    }

    public function cekKetersediaan(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id' => 'required|integer|exists:ruangan,id',
            'tanggal' => 'required|date_format:Y-m-d',
        ]);

        $tanggal = $validated['tanggal'];
        $ruangan_id = $validated['ruangan_id'];

        $jadwalTerisi = Peminjaman::where('ruangan_id', $ruangan_id)
                                ->where('tanggal_peminjaman', $tanggal)
                                ->where('status', 'not like', 'Ditolak%')
                                ->select('waktu_mulai', 'waktu_selesai')
                                ->get();

        return response()->json($jadwalTerisi);
    }
}