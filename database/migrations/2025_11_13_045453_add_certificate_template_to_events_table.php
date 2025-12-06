<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom certificate_template di tabel events
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Tambahkan kolom baru untuk menyimpan path file sertifikat template
            $table->string('certificate_template')->nullable()->after('status');
        });
    }

    /**
     * Kembalikan perubahan jika rollback
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Hapus kolom certificate_template jika rollback
            $table->dropColumn('certificate_template');
        });
    }
};
