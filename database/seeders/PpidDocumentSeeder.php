<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\PpidDocument;
use Illuminate\Database\Seeder;

class PpidDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Hapus isi pesan pengaduan lama dari database CMS
        ContactMessage::query()->delete();

        // 2. Data dokumen PPID lengkap untuk seluruh kategori layanan PPID
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
                'title' => 'Laporan Kinerja Akuntabilitas Instansi Pemerintah (LAKIP)',
                'category' => 'informasi-berkala',
                'description' => 'Laporan capaian kinerja tahunan UPBU Kelas I Kalimarau sebagai bentuk transparansi publik.',
                'file_path' => 'documents/laporan-kinerja-kalimarau.pdf',
                'sort_order' => 2,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'SOP Layanan Informasi dan Pengaduan Masyarakat',
                'category' => 'informasi-setiap-saat',
                'description' => 'Standard Operating Procedure (SOP) permohonan informasi publik dan penanganan pengaduan masyarakat.',
                'file_path' => 'documents/sop-layanan-informasi.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Daftar Informasi Publik (DIP) Bandara Kalimarau',
                'category' => 'informasi-setiap-saat',
                'description' => 'Daftar rincian informasi publik yang dikuasai dan disediakan oleh PPID UPBU Kelas I Kalimarau.',
                'file_path' => 'documents/daftar-informasi-publik.pdf',
                'sort_order' => 2,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Prosedur Keselamatan & Tanggap Darurat Penerbangan',
                'category' => 'informasi-serta-merta',
                'description' => 'Panduan dan prosedur tanggap darurat keselamatan penerbangan di lingkungan Bandara Kalimarau.',
                'file_path' => 'documents/prosedur-keselamatan-darurat.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Peraturan Menteri Perhubungan Pelayanan Kebandarudaraan',
                'category' => 'regulasi',
                'description' => 'Himpunan peraturan dan regulasi menteri perhubungan terkait standar pelayanan bandar udara.',
                'file_path' => 'documents/regulasi-pelayanan-bandara.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Formulir Permohonan Informasi Publik PPID Kalimarau',
                'category' => 'formulir-pengajuan-informasi',
                'description' => 'Formulir resmi bagi masyarakat atau perorangan untuk mengajukan permohonan informasi publik.',
                'file_path' => 'documents/formulir-permohonan-informasi.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'SOP Permohonan dan Penyampaian Informasi Publik',
                'category' => 'prosedur-permohonan-informasi',
                'description' => 'Bagan alur dan mekanisme langkah permohonan informasi publik dari pemohon hingga penyerahan berkas.',
                'file_path' => 'documents/sop-permohonan-informasi.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Prosedur & Tata Cara Pengajuan Keberatan Informasi Publik',
                'category' => 'prosedur-keberatan-informasi',
                'description' => 'Panduan dan mekanisme pengajuan keberatan atas tanggapan permohonan informasi publik.',
                'file_path' => 'documents/prosedur-pengajuan-keberatan.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Panduan Tata Cara Penyelesaian Sengketa Informasi Publik',
                'category' => 'prosedur-sengketa-informasi-publik',
                'description' => 'Prosedur penyelesaian sengketa informasi publik melalui Komisi Informasi sesuai undang-undang.',
                'file_path' => 'documents/prosedur-sengketa-informasi.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($documents as $doc) {
            PpidDocument::updateOrCreate(
                ['title' => $doc['title']],
                $doc
            );
        }
    }
}
