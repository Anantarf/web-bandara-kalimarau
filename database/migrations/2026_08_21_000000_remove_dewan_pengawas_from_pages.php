<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')
            ->where(function ($query): void {
                $query->where('content', 'like', '%Dewan Pengawas%')
                    ->orWhere('content', 'like', '%struktur-dewas%');
            })
            ->orderBy('id')
            ->select(['id', 'content'])
            ->cursor()
            ->each(function ($page): void {
                DB::table('pages')->where('id', $page->id)->update([
                    'content' => $this->cleanContent($page->content ?? ''),
                ]);
            });
    }

    public function down(): void
    {
        // Historical imported content cleanup. Removed image blocks cannot be reconstructed safely.
    }

    private function cleanContent(string $content): string
    {
        $content = str_replace(
            'Berikut adalah bagan susunan Struktur Organisasi serta susunan Dewan Pengawas pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
            'Berikut adalah bagan susunan Struktur Organisasi pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
            $content
        );
        $content = str_replace(
            'Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) serta susunan Dewan Pengawas pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
            'Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
            $content
        );

        $content = str_replace([' serta susunan Dewan Pengawas', ' dan Dewan Pengawas'], '', $content);
        $content = preg_replace('/<h[23][^>]*>\s*Dewan Pengawas\s*<\/h[23]>/i', '', $content) ?? $content;
        $content = preg_replace('/<figure[^>]*>.*?struktur-dewas.*?<\/figure>/is', '', $content) ?? $content;

        return preg_replace('/<img[^>]*struktur-dewas[^>]*>/i', '', $content) ?? $content;
    }
};
