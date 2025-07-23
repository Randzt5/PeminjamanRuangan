@extends('layouts.app')

@section('title', 'Laporan & Statistik')
@section('header-title', 'Laporan & Statistik')

@section('navbar')
    <div class="navbar">
        <a href="{{ route('admin.ruangan.index') }}">Manajemen Ruangan</a>
        <a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a>
        <a href="{{ route('admin.laporan.index') }}" class="active">Laporan</a>
        <form action="{{ route('logout') }}" method="POST" style="float:right;">@csrf<button type="submit" style="background:none; border:none; color:white; padding:14px 20px; cursor:pointer; font-size:16px;">Logout</button></form>
    </div>
@endsection

@section('content')
    <style>
        .stats-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .stat-card {
            flex: 1;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
            min-width: 200px;
        }
        .stat-card h4 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #6c757d;
        }
        .stat-card .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
    </style>

    <div class="stats-container">
        <div class="stat-card" style="border-left: 5px solid #007bff;">
            <h4>Total Pengajuan</h4>
            <p class="stat-number">{{ $total_pengajuan }}</p>
        </div>
        <div class="stat-card" style="border-left: 5px solid #28a745;">
            <h4>Total Disetujui</h4>
            <p class="stat-number">{{ $total_disetujui }}</p>
        </div>
        <div class="stat-card" style="border-left: 5px solid #dc3545;">
            <h4>Total Ditolak</h4>
            <p class="stat-number">{{ $total_ditolak }}</p>
        </div>
    </div>
    <div class="card" style="margin-top: 30px;">
        <div class="card-header">
            <h3>Ruangan Terpopuler (Top 5)</h3>
        </div>

        <div class="card" style="margin-top: 30px;">
            <div class="card-header">
                <h3>Grafik Peminjaman per Bulan (12 Bulan Terakhir)</h3>
            </div>
            <canvas id="peminjamanChart"></canvas>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Peringkat</th>
                    <th>Nama Ruangan</th>
                    <th>Total Peminjaman</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ruangan_terpopuler as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        {{-- Cek jika relasi ruangan ada untuk menghindari error --}}
                        <td>{{ $item->ruangan->nama_ruangan ?? 'Ruangan Dihapus' }}</td>
                        <td>{{ $item->total }} kali dipinjam</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">Belum ada data peminjaman untuk ditampilkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Nanti kita tambahkan grafik dan tabel laporan lainnya di sini --}}
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('peminjamanChart');

    new Chart(ctx, {
        type: 'bar', // Tipe grafik: batang
        data: {
            labels: @json($labels_chart), // Label sumbu X (Jan, Feb, Mar, ...)
            datasets: [{
                label: '# Jumlah Peminjaman',
                data: @json($data_chart), // Data sumbu Y (total peminjaman per bulan)
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Memastikan sumbu Y hanya menampilkan bilangan bulat
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush