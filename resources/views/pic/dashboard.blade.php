@extends('layouts.app')

@section('title', 'Dashboard Approval PIC')
@section('header-title', 'Dashboard Approval Final PIC')

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
        <div class="notification-bar">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Tabel Daftar Pengajuan</h3>
            <form action="{{ route('pic.dashboard') }}" method="GET" style="display: flex; gap: 10px;">
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
                    <th style="text-align: center;">Aksi Final</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar_pengajuan as $pengajuan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengajuan->nama_kegiatan }}</td>
                        <td>{{ $pengajuan->ruangan->nama_ruangan ?? 'N/A' }}.</td>
                        <td>{{ $pengajuan->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_peminjaman)->format('d-m-Y') }}</td>
                        <td><span style="background-color: #17a2b8; color: white; padding: 5px; border-radius: 5px;">{{ $pengajuan->status }}</span></td>
                        <td style="display: flex; gap: 5px; justify-content: center;">
                            <form action="{{ route('pic.approval', $pengajuan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="aksi" value="Setujui Final">
                                <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
                                    Setujui Final
                                </button>
                            </form>
                            <form action="{{ route('pic.approval', $pengajuan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="aksi" value="Tolak Final">
                                <input type="text" name="catatan" placeholder="Alasan penolakan..." style="padding: 4px; font-size: 12px; border-radius: 4px; border: 1px solid #ccc;">
                                <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
                                    Tolak Final
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Tidak ada pengajuan yang perlu persetujuan final.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $daftar_pengajuan->appends(['search' => $searchQuery])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection