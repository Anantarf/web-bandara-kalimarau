<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $page = DB::table('pages')->where('slug', 'struktur-organisasi')->first();
        if ($page) {
            $content = $page->content;
            $content = str_replace(
                'Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) serta susunan Dewan Pengawas pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
                'Berikut adalah bagan susunan Struktur Organisasi serta susunan Dewan Pengawas pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
                $content
            );
            $content = str_replace(
                '<h2>Struktur Organisasi PPID</h2>',
                '<h2>Struktur Organisasi Bandara Kalimarau</h2>',
                $content
            );
            $content = str_replace(
                'Bagan Struktur Organisasi PPID BLU Kantor UPBU Kelas I Kalimarau',
                'Bagan Struktur Organisasi BLU Kantor UPBU Kelas I Kalimarau',
                $content
            );
            DB::table('pages')->where('slug', 'struktur-organisasi')->update(['content' => $content]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $page = DB::table('pages')->where('slug', 'struktur-organisasi')->first();
        if ($page) {
            $content = $page->content;
            $content = str_replace(
                'Berikut adalah bagan susunan Struktur Organisasi serta susunan Dewan Pengawas pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
                'Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) serta susunan Dewan Pengawas pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
                $content
            );
            $content = str_replace(
                '<h2>Struktur Organisasi Bandara Kalimarau</h2>',
                '<h2>Struktur Organisasi PPID</h2>',
                $content
            );
            $content = str_replace(
                'Bagan Struktur Organisasi BLU Kantor UPBU Kelas I Kalimarau',
                'Bagan Struktur Organisasi PPID BLU Kantor UPBU Kelas I Kalimarau',
                $content
            );
            DB::table('pages')->where('slug', 'struktur-organisasi')->update(['content' => $content]);
        }
    }
};
