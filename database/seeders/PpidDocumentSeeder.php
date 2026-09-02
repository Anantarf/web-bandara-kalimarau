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
        $documents = [
            [
                'title' => 'Standar Pelayanan Publik UPBU Kelas I Kalimarau',
                'category' => 'informasi-berkala',
                'description' => 'Dokumen resmi standar pelayanan publik dan maklumat pelayanan di Bandar Udara Kelas I Kalimarau.',
                'file_path' => 'documents/standar-pelayanan-2023.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Prosedur Keselamatan dan Tanggap Darurat Penerbangan',
                'category' => 'informasi-serta-merta',
                'description' => 'Panduan dan prosedur tanggap darurat keselamatan penerbangan di lingkungan Bandara Kalimarau.',
                'file_path' => 'documents/prosedur-keselamatan-darurat.pdf',
                'sort_order' => 1,
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'SOP Layanan Informasi dan Pengaduan Masyarakat',
                'category' => 'informasi-setiap-saat',
                'description' => 'Standard Operating Procedure (SOP) permohonan informasi publik dan penanganan pengaduan.',
                'file_path' => 'documents/sop-layanan-informasi.pdf',
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
