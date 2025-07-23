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
            // Hapus kolom tanggal yang lama
            $table->dropColumn('tanggal_peminjaman');

            // Tambahkan kolom tanggal mulai dan selesai setelah ruangan_id
            $table->date('tanggal_mulai')->after('ruangan_id');
            $table->date('tanggal_selesai')->after('tanggal_mulai');
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
