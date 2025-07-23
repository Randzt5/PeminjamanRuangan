<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman akan dinamis, diisi oleh halaman anak --}}
    <title>@yield('title', 'Sistem Reservasi') - Universitas Bakrie</title>

    {{-- =================================================================== --}}
    {{-- SEMUA KODE CSS TERPUSAT DI SINI --}}
    {{-- =================================================================== --}}
    <style>

        /* General Body Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            color: #333;
        }

        /* Header Styling */
        .header {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .header .logo-container {
            display: flex;
            align-items: center;
        }
        .header .logo-img {
            max-height: 40px;
            width: auto;
        }
        .header .logo-text {
            font-weight: bold;
            font-size: 20px;
            margin-left: 15px;
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 16px;
        }
        .navbar a.active {
            background-color: #007BFF;
        }
        .navbar a:hover {
            background-color: #575757;
        }
        .navbar form button:hover {
            background-color: #575757;
        }

        /* Main Content Styling */
        .container {
            padding: 25px;
        }
        .card {
            background-color: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .card-header h3 {
            margin: 0;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
    text-align: center;      /* Membuat teks menjadi di tengah (horizontal) */
    vertical-align: middle;  /* Membuat teks menjadi di tengah (vertikal) */
    padding: 12px;
    border-bottom: 1px solid #eee;
}

        th {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        /* Form Styling */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; }
        .form-group input[type=text], .form-group input[type=email], .form-group input[type=password], .form-group input[type=number], .form-group input[type=date], .form-group input[type=time], .form-group input[type=datetime-local], .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }

        /* Notification Styling */
        .notification-bar { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .notification-bell { position: relative; cursor: pointer; }
        .notification-bell .badge { position: absolute; top: -5px; right: -10px; padding: 3px 6px; border-radius: 50%; background: red; color: white; font-size: 10px; }
        .notification-dropdown { display: none; position: absolute; top: 100%; right: 0; background-color: white; min-width: 300px; max-width: 350px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px; }
        .notification-dropdown a { color: black; padding: 12px 16px; text-decoration: none; display: block; border-bottom: 1px solid #f1f1f1; font-size: 14px; white-space: normal; }
        .notification-dropdown a:hover { background-color: #f1f1f1; }
        .notification-bell:hover .notification-dropdown { display: block; }

        /* Footer Styling */
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
        .btn-batal {
    color: #dc3545; /* Warna teks merah */
    background-color: transparent;
    border: 1px solid #dc3545; /* Garis tepi merah */
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}
.btn-batal:hover {
    background-color: #dc3545; /* Latar merah saat di-hover */
    color: white; /* Teks putih saat di-hover */
}
      /* ============================================== */
/* CSS BARU UNTUK PAGINATION TEMA BOOTSTRAP 4     */
/* ============================================== */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin-top: 20px;
    border-radius: .25rem;
}
.page-item .page-link {
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
    text-decoration: none;
}
.page-item:first-child .page-link {
    margin-left: 0;
    border-top-left-radius: .25rem;
    border-bottom-left-radius: .25rem;
}
.page-item:last-child .page-link {
    border-top-right-radius: .25rem;
    border-bottom-right-radius: .25rem;
}
.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}
.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: auto;
    background-color: #fff;
    border-color: #dee2e6;
}
.page-item .page-link:hover {
    z-index: 2;
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
/* Mengatur ukuran SVG di dalam .page-link */
.page-link svg {
    display: inline-block;
    width: 1em;
    height: 1em;
    vertical-align: -0.125em;
}
    </style>
</head>
<body>

    <div class="header">
        <div class="logo-container">
            {{-- Gambar Logo --}}
            <img src="{{ asset('images/logo-ubakrie.png') }}" alt="Logo Universitas Bakrie" class="logo-img">
            {{-- Teks Judul Halaman yang Dinamis --}}
            <span class="logo-text">@yield('header-title')</span>
        </div>

        <div style="display: flex; align-items: center; gap: 20px;">
            {{-- Cek jika user sudah login sebelum menampilkan info user & notifikasi --}}
            @auth
                {{-- Notifikasi Bell --}}
                <div class="notification-bell">
                    <span style="font-size: 24px;">🔔</span>
                    @if(isset($notifikasi_belum_dibaca) && $notifikasi_belum_dibaca->count() > 0)
                        <span class="badge">{{ $notifikasi_belum_dibaca->count() }}</span>
                    @endif
                    <div class="notification-dropdown">
                        @forelse($notifikasi_belum_dibaca ?? [] as $notif)
                            <a href="{{ route('notifikasi.baca', $notif) }}">{{ $notif->pesan }}</a>
                        @empty
                            <a href="#">Tidak ada notifikasi baru.</a>
                        @endforelse
                    </div>
                </div>

                {{-- Info Pengguna --}}
                <div class="user-info">
                    {{ Auth::user()->name ?? 'Pengguna' }}
                </div>
            @endauth
        </div>
    </div>

    {{-- Bagian Navbar yang akan diisi oleh halaman anak --}}
    @yield('navbar')

    {{-- Bagian Konten Utama yang akan diisi oleh halaman anak --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Bagian Footer yang sama untuk semua halaman --}}
    <div class="footer">
        Hak Cipta &copy; {{ date('Y') }} Randy Zenas Tanjung - Universitas Bakrie
    </div>
    @stack('scripts')
</body>
</html>