<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')
            ->where('slug', 'struktur-organisasi')
            ->update([
                'content' => '<p class="text-gray-700 text-base md:text-lg leading-relaxed mb-8">Berikut adalah bagan susunan Struktur Organisasi pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.</p>',
            ]);

        DB::table('pages')
            ->where('slug', 'struktur-organisasi-ppid-pelaksana-upt')
            ->update([
                'content' => '<p class="text-gray-700 text-base md:text-lg leading-relaxed mb-8">Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.</p>',
            ]);
    }

    public function down(): void
    {
        // No rollback needed for content cleanup
    }
};
