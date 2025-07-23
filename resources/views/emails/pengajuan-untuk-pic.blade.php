<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pengajuan Memerlukan Persetujuan Final</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { padding: 20px; }
        .content { border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        strong { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>Halo Tim PIC Ruangan,</h2>
            <p>Pengajuan peminjaman berikut telah diverifikasi oleh BIMA dan sekarang memerlukan persetujuan final dari Anda.</p>
            <hr>
            <p><strong>Nama Pemohon:</strong> {{ $peminjaman->user->name }}</p>
            <p><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan }}</p>
            <p><strong>Ruangan:</strong> {{ $peminjaman->ruangan->nama_ruangan }}</p>
            <hr>
            <p>Silakan login ke sistem untuk melihat detail dan memberikan persetujuan final.</p>
        </div>
    </div>
</body>
</html>