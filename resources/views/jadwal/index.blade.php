@extends('layouts.app')

@section('title', 'Kalender Jadwal Ruangan')
@section('header-title', 'Kalender Jadwal Ruangan')

@section('navbar')
    <div class="navbar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('peminjaman.create') }}">Ajukan Peminjaman</a>
        <a href="{{ route('jadwal.index') }}" class="active">Jadwal Ruangan</a>
        <form action="{{ route('logout') }}" method="POST" style="float:right;">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; padding:14px 20px; cursor:pointer; font-size:16px;">Logout</button>
        </form>
    </div>
@endsection

@section('content')
    <div class="card">
        <p>Kalender ini menampilkan semua jadwal peminjaman ruangan yang telah <strong>Disetujui</strong>.</p>
        <div id='calendar'></div>
    </div>
@endsection

@push('scripts')
    {{-- Load library FullCalendar dari CDN --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                // Panggil API menggunakan URL langsung
                events: '/api/jadwal',
                slotMinTime: '07:00:00',
                slotMaxTime: '22:00:00',
            });
            calendar.render();
        });
    </script>
@endpush