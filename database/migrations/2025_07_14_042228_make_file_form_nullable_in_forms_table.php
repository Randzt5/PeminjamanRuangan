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
        Schema::table('forms', function (Blueprint $table) {
            // Ubah kolom 'file_form' menjadi boleh null (nullable)
            $table->string('file_form')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            // Jika migrasi di-rollback, kembalikan menjadi tidak boleh null
            $table->string('file_form')->nullable(false)->change();
        });
    }
};