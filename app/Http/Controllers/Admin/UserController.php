<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Ambil semua user beserta relasi rolenya, urutkan berdasarkan nama
    $daftar_user = \App\Models\User::with('role')->orderBy('name', 'asc')->get();

    // Kirim data ke view yang akan kita buat
    return view('admin.users.index', ['daftar_user' => $daftar_user]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\User $user)
{
    // Logika keamanan untuk mencegah admin menghapus akunnya sendiri
    if ($user->id === auth()->id()) {
        return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
    }

    // Hapus data pengguna dari database
    $user->delete();

    // Arahkan kembali ke halaman daftar dengan pesan sukses
    return redirect()->route('admin.users.index')
                     ->with('success', 'Pengguna berhasil dihapus.');
}
}
