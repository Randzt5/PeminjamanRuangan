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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel peminjaman, jika peminjaman dihapus, form ikut terhapus
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            // Kolom untuk menyimpan path/nama file
            $table->string('file_form');
            // Kolom untuk catatan dari admin, boleh kosong
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};