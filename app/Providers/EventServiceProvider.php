<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// Pastikan semua Event dan Listener kita di-import di sini
use App\Events\PeminjamanStatusDiubah;
use App\Listeners\KirimNotifikasiInternal;
use App\Events\PengajuanBaruDibuat;
use App\Listeners\KirimNotifikasiKeAdmin;
use App\Events\BimaMenyetujui;
use App\Listeners\KirimNotifikasiKePic;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Ini untuk notifikasi ke user saat status berubah (sudah ada)
        PeminjamanStatusDiubah::class => [
            KirimNotifikasiInternal::class,
        ],

        // PASTIKAN BLOK INI ADA: Untuk notifikasi ke BIMA saat ada pengajuan baru
        PengajuanBaruDibuat::class => [
            KirimNotifikasiKeAdmin::class,
        ],

        BimaMenyetujui::class => [
            KirimNotifikasiKePic::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}