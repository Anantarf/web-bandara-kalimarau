<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Profil Bandara Kalimarau',
                'slug' => 'profil-bandara-kalimarau',
                'excerpt' => 'Profil lengkap Badan Layanan Umum Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau Berau.',
                'content' => '<p>Bandar Udara Kelas I Kalimarau merupakan pintu gerbang udara utama Kabupaten Berau, Kalimantan Timur.</p>',
                'template' => 'default',
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'excerpt' => null,
                'content' => '<p class="text-gray-700 text-base md:text-lg leading-relaxed mb-8">Berikut adalah bagan susunan Struktur Organisasi pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.</p>',
                'template' => 'default',
            ],
            [
                'title' => 'Struktur Organisasi PPID Pelaksana UPT',
                'slug' => 'struktur-organisasi-ppid-pelaksana-upt',
                'excerpt' => 'Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Pelaksana UPT.',
                'content' => '<h2>Struktur Organisasi PPID</h2><p>Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Fasilitas Bandara',
                'slug' => 'fasilitas-bandara',
                'excerpt' => 'Fasilitas dan sarana prasarana di Bandar Udara Kelas I Kalimarau.',
                'content' => '<p>Fasilitas utama dan pendukung di Bandara Kalimarau.</p>',
                'template' => 'default',
            ],
            [
                'title' => 'Maklumat Pelayanan dan Standar Biaya',
                'slug' => 'maklumat-pelayanan-dan-standar-biaya',
                'excerpt' => 'Maklumat pelayanan publik dan standar biaya layanan informasi.',
                'content' => '<h2>Maklumat Pelayanan</h2><p>Komitmen UPBU Kelas I Kalimarau dalam menyelenggarakan pelayanan publik secara profesional dan transparan.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Layanan PPID',
                'slug' => 'ppid',
                'excerpt' => 'Portal resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) BLU UPBU Kelas I Kalimarau Berau.',
                'content' => '<p>Selamat datang di portal layanan Pejabat Pengelola Informasi dan Dokumentasi (PPID) BLU UPBU Kelas I Kalimarau. Kami berkomitmen untuk memberikan pelayanan informasi publik yang transparan, cepat, akurat, dan dapat dipertanggungjawabkan sesuai amanat Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</p><p>Gunakan menu navigasi untuk mengakses profil PPID, struktur organisasi, maklumat pelayanan, regulasi, daftar informasi berkala, informasi setiap saat, serta pengajuan formulir permohonan informasi publik secara online.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Profile PPID',
                'slug' => 'profile-ppid',
                'excerpt' => 'Profil Pejabat Pengelola Informasi dan Dokumentasi UPBU Kelas I Kalimarau.',
                'content' => '<p>Pejabat Pengelola Informasi dan Dokumentasi (PPID) UPBU Kelas I Kalimarau bertanggung jawab dalam penyimpanan, pendokumentasian, penyediaan, dan/atau pelayanan informasi publik.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Visi & Misi PPID',
                'slug' => 'visi-misi-ppid',
                'excerpt' => 'Visi dan Misi Pelayanan Informasi Publik PPID Kalimarau.',
                'content' => '<p>Mewujudkan pelayanan informasi publik yang cepat, tepat, transparan, dan akuntabel.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Tugas dan Fungsi',
                'slug' => 'tugas-dan-fungsi',
                'excerpt' => 'Tugas dan fungsi PPID UPBU Kelas I Kalimarau.',
                'content' => '<p>Mengelola dan melayani permohonan informasi publik secara efisien dan transparan.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Regulasi',
                'slug' => 'regulasi',
                'excerpt' => 'Regulasi dan payung hukum Keterbukaan Informasi Publik.',
                'content' => '',
                'template' => 'ppid',
            ],
            [
                'title' => 'Informasi Berkala',
                'slug' => 'informasi-berkala',
                'excerpt' => 'Daftar informasi publik yang disediakan dan diumumkan secara berkala.',
                'content' => '<p>Informasi berkala mengenai laporan kinerja, keuangan, dan kegiatan operasional bandara.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Informasi Setiap Saat',
                'slug' => 'informasi-setiap-saat',
                'excerpt' => 'Daftar informasi publik yang wajib tersedia setiap saat.',
                'content' => '<p>Informasi yang wajib disediakan dan dapat diakses oleh publik setiap saat.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Informasi Serta Merta',
                'slug' => 'informasi-serta-merta',
                'excerpt' => 'Informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum.',
                'content' => '<p>Informasi mengenai keadaan darurat atau pengumuman keselamatan penerbangan.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Formulir Pengajuan Informasi',
                'slug' => 'formulir-pengajuan-informasi',
                'excerpt' => 'Formulir permohonan informasi publik PPID.',
                'content' => '<p>Silakan isi formulir untuk mengajukan permohonan informasi publik.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Prosedur Permohonan Informasi',
                'slug' => 'prosedur-permohonan-informasi',
                'excerpt' => 'Tata cara dan tahapan permohonan informasi publik.',
                'content' => '<p>Alur permohonan informasi dari pengajuan hingga penyampaian tanggapan.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Prosedur Permohonan Keberatan Informasi',
                'slug' => 'prosedur-permohonan-keberatan-informasi',
                'excerpt' => 'Tata cara pengajuan keberatan atas permohonan informasi.',
                'content' => '<p>Alur penyampaian keberatan kepada Atasan PPID.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Prosedur Pengajuan Sengketa Informasi Publik',
                'slug' => 'prosedur-pengajuan-sengketa-informasi-publik',
                'excerpt' => 'Alur penyelesaian sengketa informasi publik.',
                'content' => '<p>Tata cara pengajuan sengketa informasi ke Komisi Informasi.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Kritik & Saran',
                'slug' => 'kritik-saran',
                'excerpt' => 'Kanal masukan, kritik, dan saran pelayanan.',
                'content' => '<p>Kirimkan masukan dan kritik konstruktif Anda untuk kemajuan pelayanan Bandara Kalimarau.</p>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Survey Kepuasan & Hasil Tindak Lanjut',
                'slug' => 'survey-kepuasan-masyarakat-internal',
                'excerpt' => 'Kanal partisipasi survey kepuasan masyarakat serta publikasi laporan berkala hasil dan tindak lanjut peningkatan mutu pelayanan Bandara Kalimarau.',
                'content' => '<h2>Survey Kepuasan & Hasil Tindak Lanjut</h2><p>Kanal partisipasi survey dan laporan hasil kepuasan layanan Bandara Kalimarau.</p>',
                'template' => 'default',
            ],
            [
                'title' => 'Survey Kepuasan Eksternal (Kemenhub)',
                'slug' => 'survey-kepuasan-eksternal-kemenhub',
                'excerpt' => 'Hasil survey kepuasan pelanggan eksternal Kementerian Perhubungan.',
                'content' => '<h2>Survey Kepuasan Eksternal (Kemenhub)</h2><p>Survey kepuasan pengoperasian bandar udara oleh Kementerian Perhubungan.</p>',
                'template' => 'default',
            ],
            [
                'title' => 'Tarif Kebandarudaraan',
                'slug' => 'tarif-kebandarudaraan',
                'excerpt' => 'Informasi tarif jasa kebandarudaraan UPBU Kelas I Kalimarau.',
                'content' => '<h2>Tarif Kebandarudaraan</h2><p>Daftar tarif pelayanan jasa pendaratan, penempatan, dan penyimpanan pesawat udara (PJP4U) serta pelayanan jasa penumpang pesawat udara (PJP2U).</p>',
                'template' => 'default',
            ],
            [
                'title' => 'Standar Pelayanan',
                'slug' => 'standar-pelayanan',
                'excerpt' => 'Dokumen resmi mengenai pedoman operasional, tolak ukur jaminan mutu, serta prosedur standar pelayanan publik yang diselenggarakan oleh Kantor BLU UPBU Kelas I Kalimarau demi kepuasan dan kenyamanan seluruh pengguna jasa bandar udara.',
                'content' => '',
                'template' => 'default',
            ],
            [
                'title' => 'SP4N Lapor',
                'slug' => 'sp4n-lapor',
                'excerpt' => 'Layanan Pengaduan Pelayanan Publik Nasional.',
                'content' => '<h2>SP4N LAPOR!</h2><p>Sampaikan pengaduan layanan publik secara online melalui SP4N LAPOR!</p>',
                'template' => 'default',
            ],
            [
                'title' => 'SIMADU',
                'slug' => 'simadu',
                'excerpt' => 'Sistem Informasi Manajemen Pengaduan Terpadu.',
                'content' => '<h2>SIMADU</h2><p>Sistem Manajemen Pengaduan Internal Kementerian Perhubungan.</p>',
                'template' => 'default',
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'excerpt' => $p['excerpt'],
                    'content' => $p['content'],
                    'template' => $p['template'],
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }
}
