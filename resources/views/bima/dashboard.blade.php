@extends('layouts.app')

@section('title', 'Dashboard BIMA')

@section('header-title', 'Dashboard Verifikasi BIMA')

@section('navbar')
    <div class="navbar">
        <a href="#" class="active">Dashboard</a>
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

    <div class="card">
        <div class="card-header">
            <h3>Tabel Daftar Pengajuan</h3>
            <form action="{{ route('bima.dashboard') }}" method="GET" style="display: flex; gap: 10px;">
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
                    <th>Pemohon</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar_pengajuan as $pengajuan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengajuan->nama_kegiatan }}</td>
                        <td>{{ $pengajuan->ruangan->nama_ruangan ?? 'Ruangan Tidak Ditemukan' }}</td>
                        <td>{{ $pengajuan->user->name }}</td>.
                        <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_peminjaman)->format('d-m-Y') }}</td>
                        <td><span style="background-color: orange; color: white; padding: 5px; border-radius: 5px;">{{ $pengajuan->status }}</span></td>
                        <td style="display: flex; gap: 5px; justify-content: flex-start; align-items: center;">

                            {{-- TOMBOL LIHAT --}}
                            <a href="{{ route('peminjaman.show', $pengajuan) }}" style="background-color: #007bff; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 14px;">
                                Lihat
                            </a>

                            {{-- Tombol Setujui --}}
                            <form action="{{ route('bima.verifikasi', $pengajuan) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="aksi" value="Setujui">
                                <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                                    Setujui
                                </button>
                            </form>

                            {{-- Tombol Tolak --}}
                            <form action="{{ route('bima.verifikasi', $pengajuan) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="aksi" value="Tolak">
                                <input type="text" name="catatan" placeholder="Alasan penolakan..." style="padding: 4px; font-size: 12px; border-radius: 4px; border: 1px solid #ccc;">

                                <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Tidak ada pengajuan yang perlu diverifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $daftar_pengajuan->appends(['search' => $searchQuery])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection