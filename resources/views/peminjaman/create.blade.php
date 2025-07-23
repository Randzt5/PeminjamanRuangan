@extends('layouts.app')

@section('title', 'Ajukan Peminjaman Ruangan')
@section('header-title', 'Ajukan Peminjaman Ruangan')

@section('navbar')
    <div class="navbar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('peminjaman.create') }}" class="active">Ajukan Peminjaman</a>
        <a href="{{ route('jadwal.index') }}">Jadwal Ruangan</a>
        <form action="{{ route('logout') }}" method="POST" style="float:right;">@csrf<button type="submit" style="background:none; border:none; color:white; padding:14px 20px; cursor:pointer; font-size:16px;">Logout</button></form>
    </div>
@endsection

@section('content')
<style>
    .time-slot-container { display: flex; flex-wrap: wrap; gap: 10px; }
    .time-slot-btn { padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa; cursor: pointer; font-size: 14px; transition: all 0.2s; }
    .time-slot-btn:hover { border-color: #007bff; }
    .time-slot-btn.selected { background-color: #007bff; color: white; border-color: #007bff; }
    .time-slot-btn.disabled { background-color: #dc3545; color: white; border-color: #dc3545; cursor: not-allowed; opacity: 0.7; }
</style>
    <div class="card">
        <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="notification-bar" style="background-color: #f8d7da; color: #721c24;">
                    <strong>Oops! Ada yang salah:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="nama_kegiatan">Nama Kegiatan</label>
                <input type="text" id="nama_kegiatan" name="nama_kegiatan" class="form-control" value="{{ old('nama_kegiatan') }}" required>
            </div>
            <div class="form-group">
                <label for="jenis_kegiatan">Jenis Kegiatan</label>
                <input type="text" id="jenis_kegiatan" name="jenis_kegiatan" class="form-control" value="{{ old('jenis_kegiatan') }}" required>
            </div>
            <div class="form-group">
                <label for="ruangan_id">Pilih Ruangan</label>
                <select id="ruangan_id" name="ruangan_id" class="form-control" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach ($daftar_ruangan as $ruangan)
                        <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }} orang)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                <input type="text" id="tanggal_peminjaman" name="tanggal_peminjaman" class="form-control" placeholder="Pilih Tanggal..." value="{{ old('tanggal_peminjaman') }}" required>
            </div>
            <div class="form-group">
                <label for="waktu_mulai">Pilih Waktu Mulai</label>
                <div id="waktu-mulai-container" class="time-slot-container"></div>
                <input type="hidden" id="waktu_mulai" name="waktu_mulai" required>
            </div>
            <div class="form-group">
                <label for="waktu_selesai">Pilih Waktu Selesai</label>
                <div id="waktu-selesai-container" class="time-slot-container"></div>
                <input type="hidden" id="waktu_selesai" name="waktu_selesai" required>
            </div>
            <div class="form-group">
                @if(Auth::user()->role->name == 'Staff')
                    <label for="upload_form">Upload Bukti Surat Acara/GL/Poster (PDF/DOC, maks 2MB)</label>
                    <input type="file" id="upload_form" name="upload_form">
                @else
                    <label for="upload_form">Upload Memo Kegiatan (PDF/DOC, maks 2MB) <span style="color: red;">*Wajib</span></label>
                    <input type="file" id="upload_form" name="upload_form" required>
                @endif
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 15px; border-radius: 5px; border: none; cursor: pointer;">Kirim Pengajuan</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#tanggal_peminjaman", {
                altInput: true, altFormat: "j F Y", dateFormat: "Y-m-d", minDate: "today"
            });

            const ruanganSelect = document.getElementById('ruangan_id');
            const tanggalInput = document.getElementById('tanggal_peminjaman');

            async function updateAvailableTimes() {
                const ruanganId = ruanganSelect.value;
                const tanggal = tanggalInput.value;
                const mulaiContainer = document.getElementById('waktu-mulai-container');
                const selesaiContainer = document.getElementById('waktu-selesai-container');

                if (!ruanganId || !tanggal) {
                    mulaiContainer.innerHTML = '<p style="font-style: italic; color: #6c757d;">Pilih ruangan dan tanggal terlebih dahulu.</p>';
                    selesaiContainer.innerHTML = '';
                    return;
                }

                try {
                    const response = await fetch(`/api/cek-ketersediaan?ruangan_id=${ruanganId}&tanggal=${tanggal}`);
                    const bookedSlots = await response.json();
                    generateTimeSlots(mulaiContainer, document.getElementById('waktu_mulai'), bookedSlots);
                    generateTimeSlots(selesaiContainer, document.getElementById('waktu_selesai'), bookedSlots);
                } catch (error) {
                    console.error('Gagal mengambil jadwal:', error);
                }
            }

            function generateTimeSlots(container, hiddenInput, bookedSlots) {
                container.innerHTML = '';
                let startTime = 7 * 60; let endTime = 21 * 60; let interval = 30;

                for (let time = startTime; time <= endTime; time += interval) {
                    const hours = Math.floor(time / 60).toString().padStart(2, '0');
                    const minutes = (time % 60).toString().padStart(2, '0');
                    const timeString = `${hours}:${minutes}`;

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'time-slot-btn';
                    btn.textContent = timeString;
                    btn.dataset.time = timeString;

                    const isBooked = bookedSlots.some(slot => {
                        const bookedStart = slot.waktu_mulai.substring(0, 5);
                        const bookedEnd = slot.waktu_selesai.substring(0, 5);
                        return timeString >= bookedStart && timeString < bookedEnd;
                    });

                    if (isBooked) {
                        btn.classList.add('disabled');
                        btn.disabled = true;
                        btn.title = 'Slot waktu ini sudah terisi atau sedang dalam proses booking.';
                    }

                    btn.addEventListener('click', function() {
                        container.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('selected'));
                        this.classList.add('selected');
                        hiddenInput.value = this.dataset.time;
                    });

                    container.appendChild(btn);
                }
            }

            ruanganSelect.addEventListener('change', updateAvailableTimes);
            tanggalInput.addEventListener('change', updateAvailableTimes);
            updateAvailableTimes();
        });
    </script>
@endpush