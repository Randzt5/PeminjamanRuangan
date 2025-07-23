<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Reservasi Ruangan Universitas Bakrie</title>
    <style>
        /* CSS Sederhana untuk menata halaman login agar mirip wireframe */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .logo {
            width: 100px; /* Sesuaikan ukuran logo */
            margin-bottom: 20px;
        }
        h2 {
            margin-bottom: 25px;
            color: #333;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Penting agar padding tidak menambah lebar */
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #007BFF; /* Warna biru yang umum untuk tombol aksi */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .extra-links {
            font-size: 14px;
        }
        .extra-links a {
            color: #007BFF;
            text-decoration: none;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="https://www.bakrie.ac.id/images/logo-ubakrie.png" alt="Logo Universitas Bakrie" class="logo">

        <h2>Website Peminjaman Ruangan anjing<br>Universitas Bakrie</h2>
{{-- Di dalam file login.blade.php --}}

{{-- Tampilkan pesan error jika ada --}}
@if ($errors->any())
    <div style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    {{-- sisa kode form Anda --}}
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="input-group">
                <label for="username">Username</label>
                {{-- Di dokumen TA, Anda menggunakan email, jadi kita ganti 'name'-nya --}}
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">LOGIN</button>
            <div class="extra-links">
                <a href="#">Lupa password?</a> | <a href="#">Belum punya akun?</a>
            </div>
        </form>
    </div>

</body>
</html>