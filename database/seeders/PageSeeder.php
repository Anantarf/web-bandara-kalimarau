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
                'title' => 'Profil PPID',
                'slug' => 'profile-ppid',
                'excerpt' => 'Profil layanan informasi publik PPID Pelaksana UPBU Kelas I Kalimarau.',
                'content' => '<p>PPID Pelaksana UPBU Kelas I Kalimarau mengelola pelayanan informasi publik di lingkungan Bandar Udara Kalimarau. Layanan ini memastikan informasi yang dikuasai badan publik dapat didokumentasikan, diumumkan, dan diberikan kepada pemohon sesuai ketentuan keterbukaan informasi publik.</p>',
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
                'excerpt' => 'Daftar dokumen informasi publik yang diumumkan secara berkala.',
                'content' => '',
                'template' => 'ppid',
            ],
            [
                'title' => 'Informasi Setiap Saat',
                'slug' => 'informasi-setiap-saat',
                'excerpt' => 'Daftar dokumen informasi publik yang tersedia untuk diakses setiap saat.',
                'content' => '',
                'template' => 'ppid',
            ],
            [
                'title' => 'Informasi Serta Merta',
                'slug' => 'informasi-serta-merta',
                'excerpt' => 'Informasi mendesak yang berkaitan dengan keselamatan, keadaan darurat, atau ketertiban umum.',
                'content' => '',
                'template' => 'ppid',
            ],
            [
                'title' => 'Prosedur Permohonan Informasi',
                'slug' => 'prosedur-permohonan-informasi',
                'excerpt' => 'Tata cara pengajuan permohonan informasi publik kepada PPID.',
                'content' => '<ol><li>Pemohon menyampaikan permohonan informasi secara tertulis atau melalui kanal resmi yang tersedia.</li><li>PPID mencatat, memverifikasi, dan menelaah jenis informasi yang dimohonkan.</li><li>PPID memberikan tanggapan sesuai jangka waktu layanan berdasarkan ketentuan keterbukaan informasi publik.</li><li>Informasi diberikan kepada pemohon apabila tersedia dan tidak termasuk informasi yang dikecualikan.</li></ol>',
                'template' => 'ppid',
            ],
            [
                'title' => 'Prosedur Permohonan Keberatan Informasi',
                'slug' => 'prosedur-permohonan-keberatan-informasi',
                'excerpt' => 'Tata cara pengajuan keberatan apabila pemohon belum menerima layanan informasi sesuai ketentuan.',
                'content' => '<ol><li>Pemohon mengajukan keberatan secara tertulis kepada Atasan PPID.</li><li>Keberatan disampaikan dengan menyebutkan alasan, nomor permohonan, dan identitas pemohon.</li><li>Atasan PPID menelaah keberatan dan memberikan tanggapan sesuai jangka waktu yang berlaku.</li></ol>',
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
            [
                'title' => 'Pengajuan Pas Bandara',
                'slug' => 'pengajuan-pas-bandara',
                'excerpt' => null,
                'content' => '<p class="text-gray-700 text-base md:text-lg leading-relaxed mb-8">Berikut adalah bagan alur resmi tata cara pengajuan dan penerbitan Pas Masuk Bandar Udara (Airport Pass) pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.</p>',
                'template' => 'default',
            ],
        ];

        Page::whereIn('slug', [
            'kritik-saran',
            'formulir-pengajuan-informasi',
            'prosedur-pengajuan-sengketa-informasi-publik',
            'visi-misi-ppid',
            'tugas-dan-fungsi',
        ])->delete();

        foreach ($pages as $p) {
            $updateData = [
                'title' => $p['title'],
                'excerpt' => $p['excerpt'],
                'content' => $p['content'],
                'template' => $p['template'],
                'status' => 'published',
                'published_at' => now(),
            ];

            if ($p['slug'] === 'profil-bandara-kalimarau') {
                $updateData['featured_image'] = null;
            }

            Page::updateOrCreate(
                ['slug' => $p['slug']],
                $updateData
            );
        }
    }
}
