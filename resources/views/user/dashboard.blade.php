@extends('layouts.app')

@section('title', 'Dashboard Pengguna')
@section('header-title', 'Dashboard Peminjaman Ruangan')

@section('navbar')
<div class="navbar">
    <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
    <a href="{{ route('peminjaman.create') }}">Ajukan Peminjaman</a>
    <a href="{{ route('jadwal.index') }}">Jadwal Ruangan</a>
    <form action="{{ route('logout') }}" method="POST" style="float:right;">
        @csrf
        <button type="submit" style="background:none; border:none; color:white; padding:14px 20px; cursor:pointer; font-size:16px;">Logout</button>
    </form>
</div>
@endsection

@section('content')
    @if(session('success'))
        <div class="notification-bar">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="notification-bar" style="background-color: #f8d7da; color: #721c24;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Status Peminjaman</h3>
            <form action="{{ route('dashboard') }}" method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="Cari nama kegiatan..." class="search-bar" value="{{ $searchQuery ?? '' }}">
                <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Cari</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Kegiatan</th>
                    <th>Ruangan</th>
                    <th>Status</th>
                    <th>Tanggal Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar_peminjaman as $peminjaman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $peminjaman->nama_kegiatan }}</td>
                        <td>{{ optional($peminjaman->ruangan)->nama_ruangan ?? 'N/A' }}</td>
                        <td>{{ $peminjaman->status }}</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 10px; align-items: center; justify-content: center;">
                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}" style="background-color:#007bff; color:white; padding: 5px 10px; border-radius:5px; text-decoration:none;">Lihat</a>
                                @if($peminjaman->status == 'Menunggu Verifikasi BIMA')
                                    <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-batal">Batalkan</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Anda belum memiliki riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $daftar_peminjaman->appends(['search' => $searchQuery])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection