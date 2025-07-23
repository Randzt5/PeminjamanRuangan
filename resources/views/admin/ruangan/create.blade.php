@extends('layouts.app')

@section('title', 'Tambah Ruangan Baru')
@section('header-title', 'Tambah Ruangan Baru')

@section('navbar')
    <div class="navbar">
        <a href="{{ route('admin.ruangan.index') }}">Manajemen Ruangan</a>
        {{-- ... link admin lainnya nanti ... --}}
        <form action="{{ route('logout') }}" method="POST" style="float:right;">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; padding:14px 20px; cursor:pointer; font-size:16px;">Logout</button>
        </form>
    </div>
@endsection

@section('content')
    <div class="card">
        {{-- Form akan mengirim data ke route 'admin.ruangan.store' menggunakan method POST --}}
        <form action="{{ route('admin.ruangan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_ruangan">Nama Ruangan</label>
                <input type="text" id="nama_ruangan" name="nama_ruangan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" class="form-control">
            </div>
            <div class="form-group">
                <label for="kapasitas">Kapasitas (Orang)</label>
                <input type="number" id="kapasitas" name="kapasitas" class="form-control">
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;">Simpan Ruangan</button>
            <a href="{{ route('admin.ruangan.index') }}" style="background-color: #6c757d; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">Batal</a>
        </form>
    </div>
@endsection