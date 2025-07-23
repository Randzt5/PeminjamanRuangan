<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;


class LaporanController extends Controller
{
    public function index()
{
    // --- Statistik dan Ruangan Terpopuler (kode yang sudah ada) ---
    $total_pengajuan = Peminjaman::count();
    $total_disetujui = Peminjaman::where('status', 'Disetujui')->count();
    $total_ditolak = Peminjaman::where('status', 'like', 'Ditolak%')->count();
    $ruangan_terpopuler = Peminjaman::with('ruangan')
        ->select('ruangan_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
        ->groupBy('ruangan_id')->orderBy('total', 'desc')->take(5)->get();

    // --- QUERY BARU UNTUK DATA GRAFIK (12 BULAN TERAKHIR) ---
    $peminjaman_per_bulan = Peminjaman::select(
            \Illuminate\Support\Facades\DB::raw('MONTH(created_at) as bulan'),
            \Illuminate\Support\Facades\DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subYear())
        ->groupBy('bulan')
        ->orderBy('bulan', 'asc')
        ->get()
        ->pluck('total', 'bulan') // Hasilnya: [1 => 10, 2 => 15, ...] (Bulan => Total)
        ->all();

    // Siapkan array label (Jan-Des) dan data (total per bulan) untuk dikirim ke chart
    $labels_chart = [];
    $data_chart = [];
    for ($i = 1; $i <= 12; $i++) {
        $labels_chart[] = Carbon::create()->month($i)->format('F'); // "January", "February", dst.
        $data_chart[] = $peminjaman_per_bulan[$i] ?? 0; // Jika bulan tsb tidak ada data, isi dengan 0
    }

    // Kirim semua data ke view
    return view('admin.laporan.index', compact(
        'total_pengajuan',
        'total_disetujui',
        'total_ditolak',
        'ruangan_terpopuler',
        'labels_chart', // <-- Kirim data label
        'data_chart'    // <-- Kirim data total
    ));
}
}