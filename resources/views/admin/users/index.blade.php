@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('header-title', 'Manajemen Pengguna')

@section('navbar')
    <div class="navbar">
        <a href="{{ route('admin.ruangan.index') }}">Manajemen Ruangan</a>
        <a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a>
        <a href="{{ route('admin.laporan.index') }}">Laporan</a>
        <form action="{{ route('logout') }}" method="POST" style="float:right;">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; padding:14px 20px; cursor:pointer; font-size:16px;">Logout</button>
        </form>
    </div>
@endsection

@section('content')
@if(session('success'))
    <div class="notification-bar" style="background-color: #d4edda; color: #155724; border-color: #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

{{-- Notifikasi untuk pesan ERROR (warna merah) --}}
@if(session('error'))
    <div class="notification-bar" style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;">
        {{ session('error') }}
    </div>
@endif
    <div class="card">
        <div class="card-header">
            <h3>Daftar Pengguna</h3>
            {{-- Nanti kita tambahkan tombol tambah user di sini --}}
        </div>

        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran (Role)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar_user as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="#">Edit</a> |
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red; background: none; border: none; padding: 0; cursor: pointer; font-size: 1em; text-decoration: underline;">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection