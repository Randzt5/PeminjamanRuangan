<!DOCTYPE html>
<html lang="id">
<head>
    <title>Update Status Peminjaman</title>
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
            <h2>Halo, {{ $peminjaman->user->name }}!</h2>
            <p>Ada pembaruan status untuk pengajuan peminjaman ruangan Anda.</p>
            <hr>
            <p><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan }}</p>
            <p><strong>Ruangan:</strong> {{ $peminjaman->ruangan->nama_ruangan }}</p>
            <p><strong>Status Baru:</strong> <strong>{{ $peminjaman->status }}</strong></p>
            @if(optional($peminjaman->form)->catatan)
                <p style="color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px;">
                    <strong>Catatan:</strong> {{ $peminjaman->form->catatan }}
                </p>
            @endif
            <hr>
            <p>Silakan login ke sistem untuk melihat detail lebih lanjut. Jangan balas email ini karena dikirim secara otomatis.</p>
            <p>Terima kasih.</p>
        </div>
    </div>
</body>
</html>