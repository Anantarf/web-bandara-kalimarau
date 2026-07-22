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

            ['category' => 'Aksesibilitas', 'name' => 'Jalur Landai', 'image' => 'facilities/jalur-landai.jpg', 'details' => ['Akses landai untuk mendukung mobilitas penumpang prioritas.', 'Memudahkan pengguna kursi roda dan alat bantu mobilitas.']],
            ['category' => 'Aksesibilitas', 'name' => 'Lift Difabel', 'image' => 'facilities/lift-difabel.jpg', 'details' => ['Lift khusus untuk mendukung akses penumpang difabel.', 'Memudahkan perpindahan antar area terminal.']],
            ['category' => 'Aksesibilitas', 'name' => 'Kursi Khusus Difabel', 'image' => 'facilities/kursi-difabel.jpg', 'details' => ['Area duduk prioritas bagi penumpang difabel.', 'Ditempatkan untuk menunjang kenyamanan selama menunggu layanan.']],
            ['category' => 'Aksesibilitas', 'name' => 'Ruang Tunggu Difabel', 'image' => 'facilities/ruang-tunggu-difabel.jpg', 'details' => ['Ruang tunggu prioritas bagi penumpang difabel.', 'Memberikan area tunggu yang lebih mudah diakses dan nyaman.']],
            ['category' => 'Aksesibilitas', 'name' => 'Stroller, Kursi Roda & Alat Bantu Jalan', 'image' => 'facilities/alat-bantu-mobilitas.jpg', 'details' => ['Perlengkapan bantuan mobilitas bagi penumpang yang membutuhkan.', 'Mendukung layanan penumpang prioritas dan keluarga.']],

            ['category' => 'Keluarga & Rekreasi', 'name' => 'Nursery Room', 'image' => 'facilities/nursery-room.jpg', 'details' => ['Ruang khusus untuk kebutuhan ibu dan anak.', 'Memberikan privasi dan kenyamanan saat berada di terminal.']],
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
