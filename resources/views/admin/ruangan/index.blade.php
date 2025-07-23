@extends('layouts.app')

@section('title', 'Manajemen Ruangan')
@section('header-title', 'Manajemen Ruangan')

@section('navbar')
    {{-- Navbar khusus untuk Admin --}}
    <div class="navbar">
        <div class="navbar">
            <a href="{{ route('admin.ruangan.index') }}">Manajemen Ruangan</a>
            <a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a>
            <a href="{{ route('admin.laporan.index') }}">Laporan</a>
            {{-- Form logout --}}
        </div>

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
            <h3>Daftar Ruangan</h3>
            {{-- Link ini akan mengarah ke form tambah ruangan, yang akan kita buat nanti --}}
            <a href="{{ route('admin.ruangan.create') }}" style="background-color: #007bff; color: white; padding: 8px 12px; text-decoration: none; border-radius: 5px;">
                + Tambah Ruangan Baru
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Ruangan</th>
                    <th>Lokasi</th>
                    <th>Kapasitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar_ruangan as $ruangan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ruangan->nama_ruangan }}</td>
                        <td>{{ $ruangan->lokasi }}</td>
                        <td>{{ $ruangan->kapasitas }} orang</td>
                        <td>
                            <a href="{{ route('admin.ruangan.edit', $ruangan->id) }}">Edit</a> |
                            <form action="{{ route('admin.ruangan.destroy', $ruangan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini? Semua data peminjaman terkait ruangan ini juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red; background: none; border: none; padding: 0; cursor: pointer; font-size: 1em;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data ruangan. Silakan tambahkan ruangan baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection