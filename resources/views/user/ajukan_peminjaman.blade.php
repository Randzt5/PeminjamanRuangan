<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman - Sistem Reservasi Ruangan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        body{font-family:Arial,sans-serif;background-color:#f4f7fa;margin:0;color:#333}.header{background-color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.05)}.header .logo{font-weight:bold;font-size:20px}.header .user-info{font-weight:bold}.navbar{background-color:#333;overflow:hidden}.navbar a{float:left;display:block;color:white;text-align:center;padding:14px 20px;text-decoration:none}.navbar a.active{background-color:#007BFF}.navbar a:hover{background-color:#575757}.container{padding:25px}.card{background-color:white;padding:20px 30px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.05)}.card h3{margin-top:0;padding-bottom:15px;border-bottom:1px solid #eee}.form-group{margin-bottom:20px}.form-group label{display:block;margin-bottom:8px;font-weight:bold}.form-group input[type=text],.form-group input[type=datetime-local],.form-group select{width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;box-sizing:border-box;background-color:white;cursor:pointer;}.form-group input[type=file]{padding:3px}.btn{padding:12px 20px;border:none;border-radius:4px;cursor:pointer;font-size:16px}.btn-primary{background-color:#007BFF;color:white}.btn-secondary{background-color:#6c757d;color:white}.footer{text-align:center;padding:20px;margin-top:30px;font-size:14px;color:#888}
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">Dashboard Peminjaman Ruangan</div>
        <div class="user-info">Nama User</div>
    </div>

    <div class="navbar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="#" class="active">Ajukan Peminjaman</a>
        <a href="#" style="float:right;">Logout</a>
    </div>

    <div class="container">
        <div class="card">
            <h3>Ajukan Peminjaman Ruangan Universitas Bakrie</h3>
            {{-- Tampilkan pesan error validasi jika ada --}}
            @if ($errors->any())
            <div style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <strong>Oops! Ada yang salah dengan input Anda:</strong>
                <ul style="margin-top: 10px; margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf  {{-- Tampilkan pesan error validasi jika ada --}}
    @if ($errors->any())
        <div style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            <strong>Oops! Ada yang salah dengan input Anda:</strong>
            <ul style="margin-top: 10px; margin-bottom: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan">
                </div>
                <div class="form-group">
                    <label for="jenis_kegiatan">Jenis Kegiatan</label>
                    <input type="text" id="jenis_kegiatan" name="jenis_kegiatan">
                </div>
                <div class="form-group">
                    <label for="ruangan_id">Pilih Ruangan</label>
                    {{-- Nama input sekarang adalah 'ruangan_id' --}}
                    <select id="ruangan_id" name="ruangan_id" class="form-control" required>
                        <option value="">-- Pilih Ruangan --</option>
                        {{-- Lakukan perulangan pada data ruangan yang dikirim dari controller --}}
                        @foreach ($daftar_ruangan as $ruangan)
                            <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }} orang)</option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Tanggal & Waktu yang digabung --}}
                <div class="form-group">
                    <label for="waktu_mulai">Waktu Mulai</label>
                    <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" placeholder="Pilih Tanggal dan Waktu Mulai">
                </div>
                <div class="form-group">
                    <label for="waktu_selesai">Waktu Selesai</label>
                    <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" placeholder="Pilih Tanggal dan Waktu Selesai">
                </div>

                <div class="form-group">
                    <label for="upload_form">Upload Form Kegiatan</label>
                    <input type="file" id="upload_form" name="upload_form">
                </div>
                <button type="submit" class="btn btn-primary">KIRIM PENGAJUAN</button>
                <button type="reset" class="btn btn-secondary">RESET</button>
            </form>
        </div>
    </div>

    <div class="footer">
        Footer / Hak Cipta Randy Zenas Tanjung 2025
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Inisialisasi Flatpickr pada input waktu mulai
        flatpickr("#waktu_mulai", {
            enableTime: true, // Mengaktifkan pilihan waktu
            dateFormat: "Y-m-d H:i", // Format tanggal dan waktu
            time_24hr: true, // Menggunakan format 24 jam
            minuteIncrement: 30, // Kelipatan menit
        });

        // Inisialisasi Flatpickr pada input waktu selesai
        flatpickr("#waktu_selesai", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minuteIncrement: 30,
        });
    </script>

</body>
</html>