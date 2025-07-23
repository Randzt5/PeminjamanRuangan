<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Formulir Peminjaman Fasilitas</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
        }
        .container {
            border: 2px solid black;
            padding: 15px;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .header-univ {
            font-size: 12px;
            margin: 0;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }
        .main-table td {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
        }
        .main-table .label {
            width: 35%;
            font-weight: bold;
        }
        /* CSS BARU UNTUK TABEL CHECKLIST */
        .checklist-table {
            width: 100%;
            margin-top: 5px;
        }
        .checklist-table td {
            padding: 3px;
        }
        .signature-table {
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }
        .notes {
            margin-top: 20px;
            font-size: 10px;
        }
        .notes-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .notes ol {
            padding-left: 15px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="header-univ">UNIVERSITAS BAKRIE</p>
        <p class="header">FORMULIR PEMINJAMAN FASILITAS</p>

        <table class="main-table">
            {{-- ... (Isi tabel detail peminjaman yang sudah ada) ... --}}
            <tr>
                <td class="label">NAMA PENANGGUNG JAWAB KEGIATAN</td>
                <td>{{ $peminjaman->user->name }}</td>
            </tr>
            <tr>
                <td class="label">BIRO/BAGIAN/UNIT/PRODI/ORMAWA*</td>
                <td>Program Studi Informatika</td>
            </tr>
            <tr>
                <td class="label">NO. HANDPHONE PENANGGUNG JAWAB KEGIATAN</td>
                <td></td>
            </tr>
            <tr>
                <td class="label">TANGGAL DAN WAKTU PEMAKAIAN</td>
                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('l, d F Y') }}, Jam: {{ \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') }}</td>
            </tr>
            <tr>
                <td class="label">NAMA KEGIATAN</td>
                <td>{{ $peminjaman->nama_kegiatan }}</td>
            </tr>
            <tr>
                <td class="label">URAIAN ACARA</td>
                <td>{{ $peminjaman->jenis_kegiatan }}</td>
            </tr>
            <tr>
                <td class="label">RUANGAN</td>
                <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
            </tr>
        </table>

        {{-- ====================================================== --}}
        {{-- BAGIAN BARU UNTUK CHECKLIST FASILITAS --}}
        {{-- ====================================================== --}}
        <p style="margin-top: 20px; font-size: 10px; margin-bottom: 5px;">*Sebutkan nama Biro/Bagian/Unit/Prodi/Ormawa yang melaksanakan kegiatan.</p>
        <p style="font-size: 10px; margin-bottom: 5px;">Pilih fasilitas yang akan digunakan (boleh lebih dari satu):</p>

        <table class="checklist-table">
            <tr>
                <td style="width: 20%;">Sofa Hitam</td>
                <td style="width: 13.3%;">( ..... )</td>
                <td style="width: 20%;">Red Line</td>
                <td style="width: 13.3%;">( ..... )</td>
                <td style="width: 20%;">Kendaraan/Mobil</td>
                <td style="width: 13.3%;">( ..... )</td>
            </tr>
            <tr>
                <td>Kursi</td>
                <td>( ..... )</td>
                <td>Karpet</td>
                <td>( ..... )</td>
                <td colspan="2">Lainnya: ............................</td>
            </tr>
            <tr>
                <td>Meja</td>
                <td>( ..... )</td>
                <td>Podium</td>
                <td>( ..... )</td>
                <td colspan="2"></td>
            </tr>
        </table>
        {{-- ====================================================== --}}
        {{-- AKHIR DARI BAGIAN BARU --}}
        {{-- ====================================================== --}}

        <table class="signature-table">
            {{-- ... (Isi tabel tanda tangan yang sudah ada) ... --}}
            <tr>
                <td style="width: 33.3%;">
                    <p>Jakarta, {{ now()->format('d F Y') }}</p>
                    <p>Penanggung Jawab Kegiatan/<br>Yang mengajukan,</p>
                    <br><br><br><br>
                    <p>( {{ $peminjaman->user->name }} )</p>
                </td>
                <td style="width: 33.3%;">
                    <p>Mengetahui,<br>Kepala Biro/Bagian/Unit/Prodi Terkait</p>
                    <br><br><br><br>
                    <p>( .............................. )</p>
                </td>
                <td style="width: 33.3%;">
                    <p>Menyetujui,<br>Biro Umum,</p>
                    <br><br><br><br>
                    <p>( .............................. )</p>
                </td>
            </tr>
        </table>

        {{-- ... (Bagian Catatan di bawah tetap sama) ... --}}
    </div>
    <div class="notes">
        <p class="notes-title">Catatan:</p>
        <ol>
            <li>Semua fasilitas harus dikembalikan kepada Biro Umum dalam keadaan baik seperti semula. Kerusakan yang terjadi pada fasilitas menjadi tanggung jawab peminjam fasilitas.</li>
            <li>Apabila kegiatan dilaksanakan:
                <ul type="a" style="padding-left: 15px; margin-top:0;">
                    <li>Hingga diatasi jam 21:00</li>
                    <li>Diluar hari kerja (Senin-Jum'at) dan Sabtu</li>
                </ul>
                Maka penanggung jawab kegiatan harus melampirkan memo yang ditujukan kepada Kepala Biro Administrasi Akademik. Memo tersebut harus diketahui dan ditandatangani juga oleh Biro/Bagian/Unit/Prodi yang terkait dengan kegiatan tersebut.
            </li>
            <li>Fotocopy formulir yang sudah diisi lengkap harus diserahkan beserta memo (jika ada, sesuai poin 2) kepada: 1) Biro Umum, 2) Biro/Bagian/Unit/Prodi yang terkait dengan kegiatan tersebut.</li>
            <li>Fotocopy formulir penggunaan fasilitas harus didistribusikan ke pihak-pihak terkait (sesuai poin nomor 3) selambat-lambatnya 5 hari kerja sebelum kegiatan berlangsung.</li>
        </ol>
    </div>
</body>
</html>