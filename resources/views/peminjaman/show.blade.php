@extends('layouts.app')

@section('title', 'Detail Peminjaman')
@section('header-title', 'Detail Pengajuan Peminjaman')

@section('navbar')
    <div class="navbar">
        <a href="{{ url()->previous() }}"> &larr; Kembali ke Dashboard</a>
    </div>
@endsection

@section('content')
    @if(session('error'))
        <div class="notification-bar" style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <h3>Detail untuk Kegiatan: {{ $peminjaman->nama_kegiatan }}</h3>

        <table style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="width: 30%; padding: 10px; text-align: left; background-color: #f8f9fa;">Nama Pemohon</th>
                    <td style="padding: 10px;">{{ $peminjaman->user->name }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 10px; text-align: left; background-color: #f8f9fa;">Jenis Kegiatan</th>
                    <td style="padding: 10px;">{{ $peminjaman->jenis_kegiatan }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 10px; text-align: left; background-color: #f8f9fa;">Ruangan Dipesan</th>
                    <td style="padding: 10px;">{{ optional($peminjaman->ruangan)->nama_ruangan ?? 'N/A' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 10px; text-align: left; background-color: #f8f9fa;">Tanggal</th>
                    <td style="padding: 10px;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d F Y') }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 10px; text-align: left; background-color: #f8f9fa;">Waktu</th>
                    <td style="padding: 10px;">{{ \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 10px; text-align: left; background-color: #f8f9fa;">Status Saat Ini</th>
                    <td style="padding: 10px;">{{ $peminjaman->status }}</td>
                </tr>
                @if(optional($peminjaman->form)->catatan)
                    <tr style="border-bottom: 1px solid #eee;">
                        <th style="padding: 10px; text-align: left; background-color: #f8d7da;">Catatan Penolakan</th>
                        <td style="padding: 10px;">{{ $peminjaman->form->catatan }}</td>
                    </tr>
                @endif
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 10px; text-align: left; background-color: #f8f9fa;">Form Kegiatan</th>
                    <td style="padding: 10px;">
                        @if(optional($peminjaman->form)->file_form)
                            <a href="{{ Storage::url($peminjaman->form->file_form) }}" target="_blank" style="background-color: #17a2b8; color: white; padding: 8px 12px; text-decoration: none; border-radius: 5px;">
                                Download Form Kegiatan
                            </a>
                        @else
                            <span>Tidak ada file yang di-upload.</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{-- ====================================================== --}}
            {{-- TOMBOL CETAK PDF MUNCUL DI SINI --}}
            {{-- ====================================================== --}}
            @if($peminjaman->status == 'Disetujui')
                <a href="{{ route('peminjaman.cetak', $peminjaman->id) }}" target="_blank" style="background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;">
                    Cetak Bukti Peminjaman
                </a>
            @endif
        </div>
    </div>
@endsection