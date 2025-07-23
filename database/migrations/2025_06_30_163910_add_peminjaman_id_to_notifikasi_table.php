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
    Schema::table('notifikasi', function (Blueprint $table) {
        // Tambahkan kolom setelah kolom 'user_id'
        $table->foreignId('peminjaman_id')->after('user_id')->constrained('peminjaman')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            //
        });
    }
};
