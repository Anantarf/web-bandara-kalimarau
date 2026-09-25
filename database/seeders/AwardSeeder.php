<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legacyAwards = [
            [
                'title' => 'Galeri Lemari Penghargaan & Piagam Prestasi',
                'issuer' => 'UPBU Kelas I Kalimarau',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/20221024_093158-scaled.jpg',
                'description' => 'Dokumentasi lemari penghargaan dan koleksi piagam prestasi yang diraih oleh UPBU Kelas I Kalimarau dari berbagai instansi nasional.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Bandara Terbaik (Best Airport) UPBU Kelas II',
                'issuer' => 'Majalah BANDARA & Kementerian Perhubungan RI',
                'year' => 2015,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100158_TapScanner-1.jpg',
                'description' => 'Penganugerahan Bandara Awards 2015 untuk kategori Bandara Terbaik UPBU Kelas II.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Best Airport 2018 - First Winner UPBU Kelas I',
                'issuer' => 'Majalah BANDARA & Dirjen Perhubungan Udara',
                'year' => 2018,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100119_TapScanner-1.jpg',
                'description' => 'Juara I Best Airport 2018 Kategori UPBU Kelas I pada ajang 10th Bandara Awards 2018.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Piagam Predikat Wilayah Bebas dari Korupsi (WBK)',
                'issuer' => 'Kementerian PAN-RB',
                'year' => 2019,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100043_TapScanner-1.jpg',
                'description' => 'Penetapan unit kerja Kantor UPBU Kalimarau Berau sebagai unit kerja pelayanan berpredikat Wilayah Bebas dari Korupsi (WBK).',
                'sort_order' => 4,
            ],
            [
                'title' => 'Bandara Terbaik (Best Airport) UPBU Kelas II',
                'issuer' => 'Majalah BANDARA & Dirjen Perhubungan Udara',
                'year' => 2016,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100150_TapScanner-1.jpg',
                'description' => 'Penganugerahan Bandara Awards 2016 untuk kategori Bandara Terbaik UPBU Kelas II.',
                'sort_order' => 5,
            ],
            [
                'title' => 'UPBU Best Airport 2018',
                'issuer' => 'Majalah BANDARA & Menteri Perhubungan RI',
                'year' => 2018,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100110_TapScanner-1.jpg',
                'description' => 'Penghargaan UPBU Best Airport 2018 ditandatangani Menteri Perhubungan RI pada 10th Bandara Awards 2018.',
                'sort_order' => 6,
            ],
            [
                'title' => 'Piagam Unit Kerja Pelayanan Berpredikat WBK',
                'issuer' => 'Kementerian PAN-RB',
                'year' => 2019,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100051_TapScanner-1.jpg',
                'description' => 'Piagam penghargaan unit kerja pelayanan berpredikat Wilayah Bebas dari Korupsi (WBK) tahun 2019.',
                'sort_order' => 7,
            ],
            [
                'title' => 'Bandara Terbaik (Best Airport) Juara I UPBU Kelas II',
                'issuer' => 'Majalah BANDARA & Dirjen Perhubungan Udara',
                'year' => 2017,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100127_TapScanner-1.jpg',
                'description' => 'Juara I Bandara Terbaik UPBU Kelas II pada ajang Bandara Awards 2017.',
                'sort_order' => 8,
            ],
            [
                'title' => 'Best Airport 2019 - First Winner UPBU Kelas I',
                'issuer' => 'Majalah BANDARA & Dirjen Perhubungan Udara',
                'year' => 2019,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100101_TapScanner-1.jpg',
                'description' => 'Juara I Best Airport 2019 Kategori UPBU Kelas I pada ajang 11th Bandara Awards 2019.',
                'sort_order' => 9,
            ],
        ];

        foreach ($legacyAwards as $awardData) {
            Award::updateOrCreate(
                ['image' => $awardData['image']],
                array_merge($awardData, ['is_active' => true])
            );
        }
    }
}
