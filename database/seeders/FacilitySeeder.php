<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('facilities')->truncate();

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
            ['category' => 'Aksesibilitas', 'name' => 'Ruang Laktasi', 'image' => 'facilities/ruang-laktasi.jpg', 'details' => ['Ruang laktasi disediakan untuk mendukung kebutuhan ibu menyusui dan bayi selama berada di terminal.', 'Fasilitas ini dilengkapi sarana pendukung agar pengguna jasa dapat memperoleh ruang yang lebih nyaman dan privat.']],

            ['category' => 'Keluarga & Rekreasi', 'name' => 'Wahana Bermain', 'image' => 'facilities/wahana-bermain.jpg', 'details' => ['Area bermain untuk anak dan keluarga.', 'Menambah kenyamanan pengguna jasa saat menunggu.']],
            ['category' => 'Keluarga & Rekreasi', 'name' => 'Mini Zoo', 'image' => 'facilities/mini-zoo.jpg', 'details' => ['Area rekreasi ringan yang menjadi pembeda pengalaman di Bandara Kalimarau.', 'Dapat dinikmati oleh keluarga dan pengunjung.']],
            ['category' => 'Keluarga & Rekreasi', 'name' => 'Mural 3D', 'image' => 'facilities/mural-3d.jpg', 'details' => ['Spot foto tematik di area terminal.', 'Menambah pengalaman visual bagi penumpang dan pengunjung.']],

            ['category' => 'Parkir & Akses Kendaraan', 'name' => 'Parkiran Panel Surya', 'image' => 'facilities/parkir-panel-surya.jpg', 'details' => ['Area parkir dengan kanopi panel surya.', 'Mendukung kenyamanan kendaraan dan pemanfaatan energi terbarukan.']],
            ['category' => 'Parkir & Akses Kendaraan', 'name' => 'Parkiran VIP', 'image' => 'facilities/parkir-vip.jpg', 'details' => ['Area parkir khusus untuk kebutuhan layanan tertentu.', 'Memberikan akses kendaraan yang lebih terarah di area bandara.']],

            ['category' => 'Keselamatan & Operasional', 'name' => 'Gedung PKP-PK', 'image' => 'facilities/gedung-pkp-pk.jpg', 'details' => ['Fasilitas Pertolongan Kecelakaan Penerbangan dan Pemadam Kebakaran.', 'Mendukung kesiapsiagaan keselamatan operasional bandara.']],
            ['category' => 'Keselamatan & Operasional', 'name' => 'Mobil Pemadam', 'image' => 'facilities/mobil-pemadam.jpg', 'details' => ['Kendaraan pemadam untuk dukungan keselamatan bandara.', 'Bagian dari kesiapan operasional PKP-PK.']],
        ];

        foreach ($facilities as $order => $facility) {
            Facility::create([...$facility, 'order' => $order]);
        }
    }
}
