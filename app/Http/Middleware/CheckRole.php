<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
{
    // Cek apakah user sudah login DAN rolenya ada di dalam daftar role yang diizinkan
    if (!Auth::check() || !in_array(Auth::user()->role->name, $roles)) {
        // Jika tidak, tolak akses
        abort(403, 'ANDA TIDAK PUNYA AKSES.');
    }

    return $next($request);
}
}
