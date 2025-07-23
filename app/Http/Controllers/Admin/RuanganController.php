<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data ruangan dari database, urutkan berdasarkan nama
        $daftar_ruangan = \App\Models\Ruangan::orderBy('nama_ruangan', 'asc')->get();

        // Kirim data tersebut ke sebuah view yang akan kita buat
        return view('admin.ruangan.index', ['daftar_ruangan' => $daftar_ruangan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('admin.ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validasi data yang masuk
    $request->validate([
        'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
        'lokasi' => 'nullable|string|max:255',
        'kapasitas' => 'nullable|integer|min:1',
        'deskripsi' => 'nullable|string',
    ]);

    // 2. Simpan data ke database
    \App\Models\Ruangan::create($request->all());

    // 3. Arahkan kembali ke halaman daftar ruangan dengan pesan sukses
    return redirect()->route('admin.ruangan.index')
                     ->with('success', 'Ruangan baru berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Ruangan $ruangan)
    {
    // Laravel akan otomatis mencari data ruangan berdasarkan ID di URL
    // dan kita kirimkan data tersebut ke view 'edit'
    return view('admin.ruangan.edit', ['ruangan' => $ruangan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Ruangan $ruangan)
{
    // 1. Validasi data
    $request->validate([
        // Rule unique diubah agar mengabaikan nama ruangan ini sendiri saat divalidasi
        'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $ruangan->id,
        'lokasi' => 'nullable|string|max:255',
        'kapasitas' => 'nullable|integer|min:1',
        'deskripsi' => 'nullable|string',
    ]);

    // 2. Update data di database
    $ruangan->update($request->all());

    // 3. Arahkan kembali ke halaman daftar ruangan dengan pesan sukses
    return redirect()->route('admin.ruangan.index')
                     ->with('success', 'Data ruangan berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Ruangan $ruangan)
{
    // Hapus data ruangan dari database
    $ruangan->delete();

    // Arahkan kembali ke halaman daftar dengan pesan sukses
    return redirect()->route('admin.ruangan.index')
                     ->with('success', 'Ruangan berhasil dihapus.');
}
}
