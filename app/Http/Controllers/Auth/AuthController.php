<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import class Auth

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login dengan memeriksa ke database.
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // LOGIKA PENGALIHAN BERDASARKAN ROLE
        $user = Auth::user();
        if ($user->role->name === 'Admin') {
        return redirect()->route('admin.ruangan.index'); // <-- Arahkan ke halaman daftar ruangan
        } elseif ($user->role->name === 'BIMA')  {
            return redirect()->route('bima.dashboard');
        } elseif ($user->role->name === 'PIC Ruangan') { // TAMBAHKAN INI
            return redirect()->route('pic.dashboard');
        }

        // Jika bukan BIMA, arahkan ke dashboard biasa
        return redirect()->intended('dashboard');

    }

    return back()->withErrors([
        'email' => 'Email atau Password yang Anda masukkan salah!',
    ])->onlyInput('email');
}
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
}}