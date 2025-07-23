<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $notifikasi = Notifikasi::where('user_id', Auth::id())
                                  ->where('status_baca', false)
                                  ->latest()
                                  ->get();
            $view->with('notifikasi_belum_dibaca', $notifikasi);
        } else {
            // Jika pengguna belum login, kirim koleksi kosong agar tidak error
            $view->with('notifikasi_belum_dibaca', collect());
        }
    }
}