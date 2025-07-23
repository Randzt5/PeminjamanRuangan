<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('peminjaman', function (Blueprint $table) {
        // Hapus kolom tanggal mulai dan selesai
        $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);

        // Tambahkan kembali kolom tanggal peminjaman tunggal
        $table->date('tanggal_peminjaman')->after('ruangan_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            //
        });
    }
};
