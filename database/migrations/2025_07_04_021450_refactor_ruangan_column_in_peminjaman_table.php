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
        // Hapus kolom string 'ruangan' yang lama
        $table->dropColumn('ruangan');

        // Tambahkan kolom 'ruangan_id' yang baru sebagai foreign key
        // Kita buat nullable() untuk sementara jika ada data lama, tapi lebih baik migrate:fresh
        $table->foreignId('ruangan_id')->after('jenis_kegiatan')->constrained('ruangan')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('peminjaman', function (Blueprint $table) {
        // Logika untuk mengembalikan jika migrasi di-rollback
        $table->dropForeign(['ruangan_id']);
        $table->dropColumn('ruangan_id');
        $table->string('ruangan')->after('jenis_kegiatan');
    });
}
};