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
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Terhubung ke tabel users
        $table->string('nama_kegiatan');
        $table->string('jenis_kegiatan');
        $table->string('ruangan');
        $table->date('tanggal_peminjaman');
        $table->time('waktu_mulai');
        $table->time('waktu_selesai');
        $table->string('status')->default('Menunggu Verifikasi BIMA'); // Status awal
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
