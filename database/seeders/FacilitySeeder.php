<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::whereIn('name', [
            'Portal Masuk & Keluar Kendaraan Roda 4',
            'Portal Masuk & Keluar Kendaraan Roda 2',
        ])->delete();

        $facilities = [
            ['category' => 'Layanan Terminal', 'name' => 'Area Check-in', 'image' => 'facilities/area-check-in.jpg', 'details' => ['Area layanan check-in penumpang sebelum keberangkatan.', 'Tersedia alur antrean untuk membantu proses layanan lebih tertib.']],
            ['category' => 'Layanan Terminal', 'name' => 'Charging Station', 'image' => 'facilities/charging-station.jpg', 'details' => ['Fasilitas pengisian daya perangkat elektronik.', 'Ditempatkan di area terminal yang mudah dijangkau penumpang.']],
            ['category' => 'Layanan Terminal', 'name' => 'Food Court', 'image' => 'facilities/food-court.jpg', 'details' => ['Area pilihan makanan dan minuman bagi pengguna jasa bandara.', 'Mendukung kebutuhan penumpang dan pengantar selama berada di terminal.']],
            ['category' => 'Layanan Terminal', 'name' => 'Tenant / Kafe', 'image' => 'facilities/tenant-kafe.jpg', 'details' => ['Tenant komersial untuk kebutuhan makan, minum, dan belanja ringan.', 'Berada di area terminal penumpang.']],
            ['category' => 'Layanan Terminal', 'name' => 'Layanan Wrapping Bagasi', 'image' => 'facilities/wrapping-bagasi.jpg', 'details' => ['Layanan perlindungan tambahan untuk barang bawaan penumpang.', 'Membantu menjaga koper dan bagasi tetap rapi selama perjalanan.']],
            ['category' => 'Layanan Terminal', 'name' => 'Passenger Handling Service', 'image' => 'facilities/passenger-handling-service.jpg', 'details' => ['Layanan bantuan bagi penumpang yang membutuhkan pendampingan.', 'Petugas membantu memberi arahan sesuai kebutuhan layanan di terminal.']],
            ['category' => 'Layanan Terminal', 'name' => 'Tangga & Eskalator', 'image' => 'facilities/tangga-escalator.jpg', 'details' => ['Akses perpindahan antar area terminal.', 'Mendukung mobilitas penumpang di dalam gedung terminal.']],

            ['category' => 'Informasi & Pengaduan', 'name' => 'Pusat Informasi', 'image' => 'facilities/pusat-informasi.jpg', 'details' => ['Pusat layanan informasi bagi penumpang dan pengunjung bandara.', 'Membantu kebutuhan arahan, informasi layanan, dan informasi umum terminal.']],
            ['category' => 'Informasi & Pengaduan', 'name' => 'Kotak Saran', 'image' => 'facilities/kotak-saran.jpg', 'details' => ['Sarana penyampaian masukan bagi pengguna jasa bandara.', 'Mendukung peningkatan kualitas layanan secara berkelanjutan.']],
            ['category' => 'Informasi & Pengaduan', 'name' => 'Ruang PPID UPBU Kalimarau', 'image' => 'facilities/ruang-ppid-upbu-kalimarau.jpg', 'details' => ['Ruangan pelayanan Pejabat Pengelola Informasi dan Dokumentasi (PPID) di Kantor Bandara Kalimarau.', 'Mendukung keterbukaan informasi publik dan sarana penyampaian permohonan informasi secara langsung.']],
            ['category' => 'Informasi & Pengaduan', 'name' => 'Meja Petugas PPID', 'image' => 'facilities/meja-petugas-ppid.jpg', 'details' => ['Meja layanan informasi PPID yang dilengkapi petugas frontliner yang siap melayani pemohon informasi.', 'Pelayanan ramah, tertib, dan transparan bagi pengguna jasa bandara dan masyarakat luas.']],
            ['category' => 'Informasi & Pengaduan', 'name' => 'Hotline dan Waktu Pelayanan PPID', 'image' => 'facilities/hotline-dan-waktu-pelayanan-ppid.jpg', 'details' => ['Layanan informasi daring melalui kontak WhatsApp Hotline resmi PPID UPBU Kalimarau (0812-4076-2070).', 'Waktu operasional pelayanan: Senin - Kamis (08.00 - 15.00 WITA) dan Jumat (08.00 - 15.30 WITA).']],
            ['category' => 'Informasi & Pengaduan', 'name' => 'Media Sosial & Informasi Digital PPID', 'image' => 'facilities/medsos-kontak-resmi.jpg', 'details' => ['Kanal media sosial resmi (@ppid.upbukalimarau) dan saluran informasi digital Bandara Kalimarau.', 'Memudahkan publik mengakses informasi terkini, pengumuman, dan transparansi pelayanan secara daring.']],

            ['category' => 'Aksesibilitas', 'name' => 'Kursi Roda, Stroller & Alat Bantu Jalan', 'image' => 'facilities/kursi-roda-stroller-alat-bantu-jalan.jpg', 'details' => ['Sarana bantuan mobilitas bagi penumpang yang membutuhkan pendampingan selama berada di area terminal.', 'Dapat digunakan oleh difabel, lansia, ibu hamil, anak-anak, dan penumpang dengan kebutuhan khusus lainnya.']],
            ['category' => 'Aksesibilitas', 'name' => 'Pintu Masuk Aksesibel', 'image' => 'facilities/pintu-masuk-aksesibel.jpg', 'details' => ['Akses pintu masuk dan keluar terminal dirancang agar lebih mudah dilalui oleh pengguna jasa berkebutuhan khusus.', 'Mendukung pergerakan penumpang kelompok rentan dari area kedatangan, keberangkatan, dan akses utama terminal.']],
            ['category' => 'Aksesibilitas', 'name' => 'Jalan Landai dan Pegangan Rambat', 'image' => 'facilities/jalan-landai-pegangan-rambat.jpg', 'details' => ['Fasilitas jalan landai dilengkapi pegangan rambat untuk membantu mobilitas pengguna jasa di area terminal.', 'Mendukung akses yang lebih aman bagi difabel, lansia, ibu hamil, dan penumpang yang membutuhkan bantuan berjalan.']],
            ['category' => 'Aksesibilitas', 'name' => 'Lift Khusus Kelompok Rentan', 'image' => 'facilities/lift-khusus-kelompok-rentan.jpg', 'details' => ['Lift tersedia untuk membantu perpindahan antar area terminal bagi penumpang kelompok rentan.', 'Dilengkapi tombol dengan penanda braille untuk mendukung aksesibilitas pengguna tunanetra.']],
            ['category' => 'Aksesibilitas', 'name' => 'Selasar Aksesibel', 'image' => 'facilities/selasar-aksesibel.jpg', 'details' => ['Selasar terminal menghubungkan berbagai area layanan dengan jalur yang dapat dilalui pengguna jasa secara lebih nyaman.', 'Mendukung akses menuju area check-in, keberangkatan, kedatangan, dan fasilitas pendukung lainnya.']],
            ['category' => 'Aksesibilitas', 'name' => 'Toilet Khusus Kelompok Rentan', 'image' => 'facilities/toilet-khusus-kelompok-rentan.jpg', 'details' => ['Toilet khusus disediakan untuk mendukung kebutuhan pengguna jasa berkebutuhan khusus.', 'Fasilitas ini membantu memberikan kenyamanan dan kemudahan akses bagi difabel, lansia, dan penumpang prioritas.']],
            ['category' => 'Aksesibilitas', 'name' => 'Loket dan Check-in Khusus', 'image' => 'facilities/loket-check-in-khusus.jpg', 'details' => ['Loket dan area check-in khusus disediakan untuk membantu pelayanan bagi penumpang kelompok rentan.', 'Mendukung proses layanan yang lebih terarah bagi difabel, lansia, ibu hamil, dan penumpang yang membutuhkan prioritas.']],
            ['category' => 'Aksesibilitas', 'name' => 'Ruang Tunggu Prioritas', 'image' => 'facilities/ruang-tunggu-prioritas.jpg', 'details' => ['Area tunggu prioritas tersedia bagi pengguna jasa yang membutuhkan kenyamanan dan pendampingan tambahan.', 'Dapat digunakan oleh difabel, lansia, ibu hamil, anak-anak, dan penumpang dengan kebutuhan khusus.']],
            ['category' => 'Aksesibilitas', 'name' => 'Guiding Block', 'image' => 'facilities/guiding-block.jpg', 'details' => ['Jalur guiding block tersedia untuk membantu pengguna tunanetra dalam mengenali arah pergerakan di area terminal.', 'Mendukung akses menuju pintu masuk, area check-in, dan jalur layanan utama.']],
            ['category' => 'Aksesibilitas', 'name' => 'Parkir Prioritas', 'image' => 'facilities/parkir-prioritas.jpg', 'details' => ['Area parkir prioritas disediakan dengan akses yang lebih mudah menuju terminal.', 'Mendukung kebutuhan parkir bagi pengguna jasa kelompok rentan dan penumpang yang membutuhkan akses lebih dekat.']],
            ['category' => 'Aksesibilitas', 'name' => 'Alat Bantu Dengar dan Formulir Braille', 'image' => 'facilities/alat-bantu-dengar-formulir-braille.jpg', 'details' => ['Sarana pendukung tersedia untuk membantu pengguna jasa dengan hambatan pendengaran dan penglihatan.', 'Formulir braille dan alat bantu dengar mendukung layanan informasi yang lebih inklusif.']],
            ['category' => 'Aksesibilitas', 'name' => 'Petugas Khusus Layanan Penumpang', 'image' => 'facilities/01M3B0CET3A4VD52305V4JEB1V.jpg', 'details' => ['Petugas khusus yang siap mendampingi dan memberikan asistensi bagi penumpang berkebutuhan khusus.', 'Membantu alur informasi, check-in, dan mobilitas difabel, lansia, serta penumpang prioritas.']],
            ['category' => 'Aksesibilitas', 'name' => 'Layanan Jemput Bola bagi Kelompok Rentan', 'image' => 'facilities/01M3B0FYXRNGNG8ZRY4GPZQJGY.jpg', 'details' => ['Layanan pendampingan aktif oleh petugas bandara untuk menjemput dan membantu penumpang kelompok rentan sejak tiba di terminal.', 'Memudahkan akses bagi penumpang lansia, difabel, dan ibu hamil menuju area layanan keberangkatan atau kedatangan.']],
            ['category' => 'Aksesibilitas', 'name' => 'Ruang Laktasi', 'image' => 'facilities/ruang-laktasi.jpg', 'details' => ['Ruang laktasi disediakan untuk mendukung kebutuhan ibu menyusui dan bayi selama berada di terminal.', 'Fasilitas ini dilengkapi sarana pendukung agar pengguna jasa dapat memperoleh ruang yang lebih nyaman dan privat.']],

            ['category' => 'Keluarga & Rekreasi', 'name' => 'Wahana Bermain', 'image' => 'facilities/wahana-bermain.jpg', 'details' => ['Area bermain untuk anak dan keluarga.', 'Menambah kenyamanan pengguna jasa saat menunggu.']],
            ['category' => 'Keluarga & Rekreasi', 'name' => 'Wahana Bermain Outdoor', 'image' => 'facilities/wahana-outdoor.jpg', 'details' => ['Fasilitas taman bermain luar ruang (outdoor playground) untuk anak-anak dan keluarga.', 'Dilengkapi beragam wahana permainan di lingkungan hijau yang asri dan aman.']],
            ['category' => 'Keluarga & Rekreasi', 'name' => 'Field Trip Edukasi Bandara', 'image' => 'facilities/field-trip-edukasi.jpg', 'details' => ['Program kunjungan edukasi bandara bagi siswa sekolah, TK, dan komunitas.', 'Memberikan pengenalan dunia aviasi, armada PKP-PK, terminal, dan prosedur keselamatan penerbangan.']],
            ['category' => 'Keluarga & Rekreasi', 'name' => 'Mini Zoo', 'image' => 'facilities/mini-zoo.jpg', 'details' => ['Area rekreasi ringan yang menjadi pembeda pengalaman di Bandara Kalimarau.', 'Dapat dinikmati oleh keluarga dan pengunjung.']],
            ['category' => 'Keluarga & Rekreasi', 'name' => 'Mural 3D', 'image' => 'facilities/mural-3d.jpg', 'details' => ['Spot foto tematik di area terminal.', 'Menambah pengalaman visual bagi penumpang dan pengunjung.']],
            ['category' => 'Keluarga & Rekreasi', 'name' => 'Working Space dan Reading Corner', 'image' => 'facilities/working-space-reading-corner.jpeg', 'details' => ['Fasilitas ruang kerja bersama dan pojok baca bagi calon penumpang di area terminal.', 'Dilengkapi meja kerja, koneksi daya listrik, dan sarana membaca untuk kenyamanan produktivitas Anda.']],

            ['category' => 'Parkir & Akses Kendaraan', 'name' => 'Gerbang Pintu Masuk Utama', 'image' => 'facilities/gerbang-masuk-utama.jpg', 'details' => ['Akses pintu gerbang masuk utama menuju kawasan Bandar Udara Kalimarau.', 'Dilengkapi sistem toll gate tiket otomatis untuk kelancaran arus kendaraan.']],
            ['category' => 'Parkir & Akses Kendaraan', 'name' => 'Pintu Masuk Roda 2', 'image' => 'facilities/pintu-masuk-roda-2.jpg', 'details' => ['Jalur dan gerbang masuk khusus kendaraan roda dua (sepeda motor).', 'Memisahkan alur pergerakan motor dan mobil demi ketertiban serta keselamatan.']],
            ['category' => 'Parkir & Akses Kendaraan', 'name' => 'Parkir Motor Roda 2', 'image' => 'facilities/parkir-motor-roda-2.jpg', 'details' => ['Area parkir khusus sepeda motor dengan kanopi atap peneduh panel surya.', 'Menyediakan kapasitas parkir luas dan aman bagi pengguna jasa serta karyawan.']],
            ['category' => 'Parkir & Akses Kendaraan', 'name' => 'Parkiran Panel Surya', 'image' => 'facilities/parkir-panel-surya.jpg', 'details' => ['Area parkir dengan kanopi panel surya.', 'Mendukung kenyamanan kendaraan dan pemanfaatan energi terbarukan.']],
            ['category' => 'Parkir & Akses Kendaraan', 'name' => 'Parkiran VIP', 'image' => 'facilities/parkir-vip.jpg', 'details' => ['Area parkir khusus untuk kebutuhan layanan tertentu.', 'Memberikan akses kendaraan yang lebih terarah di area bandara.']],

            ['category' => 'Keselamatan & Operasional', 'name' => 'Gedung PKP-PK', 'image' => 'facilities/gedung-pkp-pk.jpg', 'details' => ['Fasilitas Pertolongan Kecelakaan Penerbangan dan Pemadam Kebakaran.', 'Mendukung kesiapsiagaan keselamatan operasional bandara.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Mobil Pemadam', 'image' => 'facilities/mobil-pemadam.jpg', 'details' => ['Kendaraan pemadam untuk dukungan keselamatan bandara.', 'Bagian dari kesiapan operasional PKP-PK.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Mobil Ambulance', 'image' => 'facilities/mobil-ambulance.jpg', 'details' => ['Kendaraan medis darurat untuk penanganan pertolongan pertama dan evakuasi medis.', 'Mendukung standar keselamatan dan kesiapsiagaan darurat bandara.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Mobil Comando', 'image' => 'facilities/mobil-comando.jpg', 'details' => ['Kendaraan komando operasional untuk koordinasi cepat saat penanganan situasi darurat di bandara.', 'Mendukung komando dan kendali terpadu tim keselamatan.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Mobil AMC', 'image' => 'facilities/mobil-amc.jpg', 'details' => ['Kendaraan operasional Airport Movement Control untuk pengawasan dan pengaturan pergerakan di sisi udara (airside).', 'Memastikan keselamatan dan kelancaran pergerakan di apron dan runway.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Mobil Patroli Avsec', 'image' => 'facilities/mobil-patroli-avsec.png', 'details' => ['Kendaraan patroli Aviation Security untuk pengawasan keamanan di seluruh area bandara.', 'Menjaga keamanan dan ketertiban lingkungan operasional bandara secara berkelanjutan.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Gedung Power House', 'image' => 'facilities/gedung-power-house.jpg', 'details' => ['Fasilitas pusat kelistrikan utama dan genset cadangan untuk keandalan pasokan daya bandara.', 'Memastikan suplai listrik peralatan navigasi, runway lights, dan terminal selalu terjaga.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Gedung Kargo', 'image' => 'facilities/gedung-kargo.jpg', 'details' => ['Fasilitas pelayanan dan penanganan kargo serta logistik penerbangan.', 'Mendukung kelancaran arus pengiriman dan penerimaan barang melalui jalur udara.']],
        ];

        foreach ($facilities as $order => $facility) {
            Facility::firstOrCreate(
                ['name' => $facility['name']],
                [...$facility, 'order' => $order]
            );
        }
    }
}
