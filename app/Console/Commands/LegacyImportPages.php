<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Services\LegacyContentCleaner;
use App\Services\LegacyMediaImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LegacyImportPages extends Command
{
    protected $signature = 'legacy:import-pages';

    protected $description = 'Import a curated whitelist of WordPress pages into pages, per docs/DATA MIGRATION PLAN.md';

    /**
     * legacy post ID => overrides. Deliberately excludes: internal tools
     * (Absensi Online Rapat, Bank Data Mobilisasi...), plugin settings pages
     * (Login Customizer, Maintenance), the empty/duplicate Tarif
     * Kebandarudaraan and Struktur Organisasi rows, and the old WP
     * homepage/berita/kontak pages which Laravel already rebuilt natively.
     */
    /**
     * Only the 15 PPID sub-pages + hub from docs/SITEMAP LARAVEL.md nested
     * under /ppid/{sub}. "Hasil Dan Tindak Lanjut" (2994) is deliberately
     * excluded — the sitemap places it under Pengaduan as a top-level page.
     */
    public const PPID_TEMPLATE_IDS = [
        2811, 2908, 3802, 3846, 3763, 2799, 2492, 2684,
        2835, 2807, 2825, 2787, 2768, 2749, 2761, 314,
    ];

    public const WHITELIST = [
        1355 => [], // Buku Tamu
        452 => [],  // Fasilitas Pelayanan
        2811 => [], // Formulir Pengajuan Informasi
        2994 => [], // Hasil Dan Tindak Lanjut
        2908 => [], // Informasi Berkala
        3802 => [], // Informasi Serta Merta
        3846 => [], // Informasi Setiap Saat
        1778 => [], // Kode Etik Pegawai
        3763 => [], // Kritik & Saran
        301 => [],  // Maklumat Pelayanan
        2799 => [], // Maklumat Pelayanan dan Standar Biaya
        2492 => [], // PPID
        2684 => [], // Profile PPID
        217 => [],  // Profil Bandara Kalimarau
        2835 => [], // Prosedur Pengajuan Sengketa Informasi Publik
        2807 => [], // Prosedur Permohonan Informasi
        2825 => [], // Prosedur Permohonan Keberatan Informasi
        2787 => [], // Regulasi
        1158 => [], // Simadu
        3825 => [], // SP4N Lapor
        3076 => [], // Standar Pelayanan
        314 => [],  // Struktur Organisasi (skip the malformed duplicate slug "s", ID 2755)
        2768 => [], // Struktur Organisasi PPID Pelaksana UPT
        1022 => [], // Survey Kepuasan Eksternal (Kemenhub)
        1013 => [], // Survey Kepuasan Masyarakat (Internal)
        1395 => ['slug' => 'tarif-kebandarudaraan'], // real content; ID 1360 was an empty duplicate
        2761 => [], // Tugas Dan Fungsi
        1169 => [], // Unit Kerja Bandara Kalimaru
        378 => [],  // Visi & Misi
        2749 => [], // Visi Misi PPID
    ];

    public function handle(LegacyMediaImporter $mediaImporter): int
    {
        $created = 0;
        $updated = 0;

        foreach (self::WHITELIST as $legacyId => $overrides) {
            $row = DB::connection('legacy')->table('posts')
                ->where('ID', $legacyId)
                ->where('post_type', 'page')
                ->first();

            if (! $row) {
                $this->warn("Legacy page ID {$legacyId} not found, skipped.");

                continue;
            }

            $thumbnailId = DB::connection('legacy')->table('postmeta')
                ->where('post_id', $legacyId)
                ->where('meta_key', '_thumbnail_id')
                ->value('meta_value');

            $featuredImage = $mediaImporter->resolve($thumbnailId ? (int) $thumbnailId : null);

            $attributes = [
                'featured_image' => $featuredImage?->path,
                'title' => html_entity_decode($row->post_title, ENT_QUOTES),
                'slug' => $overrides['slug'] ?? $row->post_name,
                'content' => $mediaImporter->rewriteInlineImages(LegacyContentCleaner::clean($row->post_content)),
                'status' => 'published',
                'template' => in_array($legacyId, self::PPID_TEMPLATE_IDS, true) ? 'ppid' : 'default',
                'published_at' => $row->post_date,
            ];

            $page = Page::where('legacy_id', $legacyId)->first();

            if ($page) {
                $page->update($attributes);
                $updated++;
            } else {
                Page::create(['legacy_id' => $legacyId, ...$attributes]);
                $created++;
            }
        }

        $this->info('Pages imported: '.$created.' created, '.$updated.' updated (of '.count(self::WHITELIST).' whitelisted).');

        if ($mediaImporter->missingImages) {
            $this->warn(count($mediaImporter->missingImages).' inline image(s) had no local file and were dropped:');
            foreach (array_unique($mediaImporter->missingImages) as $url) {
                $this->line("  - {$url}");
            }
        }

        return self::SUCCESS;
    }
}
