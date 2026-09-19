<?php

namespace Database\Seeders;

use App\Models\PpidDocument;
use Illuminate\Database\Seeder;

class PpidDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dokumen PPID lengkap untuk seluruh kategori layanan PPID
        $documents = [
            [
                'title' => 'Standar Pelayanan Publik UPBU Kelas I Kalimarau 2023',
                'category' => 'informasi-berkala',
                'description' => 'Dokumen resmi standar pelayanan publik dan maklumat pelayanan di Bandar Udara Kelas I Kalimarau.',
                'file_path' => 'media/legacy/2024/09/Standar-Pelayanan-2023.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Daftar Informasi Publik Kementerian Perhubungan 2023',
                'category' => 'informasi-setiap-saat',
                'description' => 'Daftar Informasi Publik (DIP) Kementerian Perhubungan sebagai rujukan informasi publik yang tersedia.',
                'file_path' => 'ppid/20230704130923.KP_593_Thn_2023_-_DIP_Kemenhub_2023.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Daftar Informasi yang Dikecualikan Kementerian Perhubungan 2023',
                'category' => 'informasi-setiap-saat',
                'description' => 'Dokumen informasi publik yang dikecualikan sesuai ketentuan Kementerian Perhubungan.',
                'file_path' => 'ppid/20230704131331.KP_591_Thn_2023_-_Informasi_yang_Dikecualikan.pdf',
                'sort_order' => 2,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik',
                'category' => 'regulasi',
                'description' => 'Regulasi dasar keterbukaan informasi publik.',
                'file_path' => 'ppid/20200728111256.uu14-2008_keterbukaan_informasi_publikascas.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Undang-Undang Nomor 25 Tahun 2009 tentang Pelayanan Publik',
                'category' => 'regulasi',
                'description' => 'Regulasi pelayanan publik sebagai dasar penyelenggaraan layanan informasi.',
                'file_path' => 'ppid/20200728111618.UU_25_Tahun_2009dsd.pdf',
                'sort_order' => 2,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Undang-Undang Nomor 43 Tahun 2009 tentang Kearsipan',
                'category' => 'regulasi',
                'description' => 'Regulasi kearsipan untuk pengelolaan dokumentasi informasi publik.',
                'file_path' => 'ppid/20200728111804.UU_43_Tahun_2009cxzaaa.pdf',
                'sort_order' => 3,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Undang-Undang Nomor 40 Tahun 1999 tentang Pers',
                'category' => 'regulasi',
                'description' => 'Regulasi pers terkait hak memperoleh dan menyampaikan informasi.',
                'file_path' => 'ppid/20200728111403.UU_No._40_Tahun_1999_Tentang_Pers_sdcds.pdf',
                'sort_order' => 4,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Peraturan Komisi Informasi Nomor 1 Tahun 2021',
                'category' => 'regulasi',
                'description' => 'Standar layanan informasi publik berdasarkan Peraturan Komisi Informasi.',
                'file_path' => 'ppid/PerKI-No-1-Tahun-2021.pdf',
                'sort_order' => 5,
                'is_active' => true,
                'published_at' => now(),
            ],
        ];
        foreach ($documents as $doc) {
            PpidDocument::firstOrCreate(
                ['title' => $doc['title']],
                $doc
            );
        }
    }
}
