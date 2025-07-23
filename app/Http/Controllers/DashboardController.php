<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $searchQuery = $request->query('search');

        $query = Peminjaman::with('ruangan')->where('user_id', $userId);

        if ($searchQuery) {
            $query->where('nama_kegiatan', 'like', '%' . $searchQuery . '%');
        }

        $daftar_peminjaman = $query->latest()->paginate(10);

        return view('user.dashboard', [
            'daftar_peminjaman' => $daftar_peminjaman,
            'searchQuery' => $searchQuery
        ]);
    }
}