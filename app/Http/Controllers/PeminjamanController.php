<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Form;
use App\Models\Ruangan;
use App\Rules\NoTimeOverlap;
use App\Events\PengajuanBaruDibuat;
use App\Events\BimaMenyetujui;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function create()
    {
        $daftar_ruangan = Ruangan::orderBy('nama_ruangan')->get();
        return view('peminjaman.create', ['daftar_ruangan' => $daftar_ruangan]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tanggal_peminjaman' => 'required|date',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'waktu_mulai' => [
                'required', 'date_format:H:i',
                new NoTimeOverlap($request->ruangan_id, $request->tanggal_peminjaman, $request->waktu_selesai)
            ],
        ];

        if ($user->role->name == 'Staff') {
            $rules['upload_form'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
            $statusAwal = 'Telah Diverifikasi BIMA';
        } else {
            // Asumsikan peran lain (Mahasiswa) wajib upload
            $rules['upload_form'] = 'required|file|mimes:pdf,doc,docx|max:2048';
            $statusAwal = 'Menunggu Verifikasi BIMA';
        }
        $validatedData = $request->validate($rules);

        $path = null;
        if ($request->hasFile('upload_form')) {
            $file = $request->file('upload_form');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/proposals', $namaFile);
        }

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'ruangan_id' => $validatedData['ruangan_id'],
            'nama_kegiatan' => $validatedData['nama_kegiatan'],
            'jenis_kegiatan' => $validatedData['jenis_kegiatan'],
            'tanggal_peminjaman' => $validatedData['tanggal_peminjaman'],
            'waktu_mulai' => $validatedData['waktu_mulai'],
            'waktu_selesai' => $validatedData['waktu_selesai'],
            'status' => $statusAwal,
        ]);

        if ($peminjaman) {
            $peminjaman->form()->create(['file_form' => $path]);
            if ($statusAwal == 'Menunggu Verifikasi BIMA') {
                event(new PengajuanBaruDibuat($peminjaman));
            } else {
                event(new BimaMenyetujui($peminjaman));
            }
        }

        return redirect()->route('dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load('user', 'ruangan', 'form');
        return view('peminjaman.show', ['peminjaman' => $peminjaman]);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if (auth()->id() !== $peminjaman->user_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }
        if ($peminjaman->status !== 'Menunggu Verifikasi BIMA') {
            return back()->with('error', 'Pengajuan ini sudah diproses dan tidak bisa dibatalkan lagi.');
        }
        if ($peminjaman->form && $peminjaman->form->file_form) {
            Storage::delete($peminjaman->form->file_form);
        }
        $peminjaman->delete();
        return redirect()->route('dashboard')->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function cetakBukti(Peminjaman $peminjaman)
    {
        $user = auth()->user();
        if ($user->id !== $peminjaman->user_id && $user->role->name !== 'Admin') {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }
        if ($peminjaman->status !== 'Disetujui') {
            return back()->with('error', 'Bukti peminjaman hanya bisa dicetak untuk pengajuan yang sudah disetujui.');
        }
        $peminjaman->load('user', 'ruangan');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('peminjaman.bukti-pdf', ['peminjaman' => $peminjaman]);
        $fileName = 'bukti-peminjaman-' . Str::slug($peminjaman->nama_kegiatan) . '.pdf';
        return $pdf->download($fileName);
    }
}