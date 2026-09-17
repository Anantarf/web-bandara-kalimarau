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
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #1',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/20221024_093158-scaled.jpg',
                'description' => 'Penghargaan atas komitmen peningkatan mutu dan kualitas pelayanan bandar udara.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #2',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100158_TapScanner-1.jpg',
                'description' => 'Penghargaan atas kepatuhan standar keselamatan operasional penerbangan.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #3',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100119_TapScanner-1.jpg',
                'description' => 'Penghargaan atas kinerja operasional dan inovasi pelayanan publik.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #4',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100043_TapScanner-1.jpg',
                'description' => 'Pencapaian penilaian prima standar fasilitas terminal penumpang.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #5',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100150_TapScanner-1.jpg',
                'description' => 'Apresiasi keberhasilan integrasi sistem pelayanan publik modern.',
                'sort_order' => 5,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #6',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100110_TapScanner-1.jpg',
                'description' => 'Penghargaan tata kelola kebersihan dan kenyamanan lingkungan bandara.',
                'sort_order' => 6,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #7',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100051_TapScanner-1.jpg',
                'description' => 'Penghargaan pengelolaan keandalan sarana pendukung penerbangan.',
                'sort_order' => 7,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #8',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100127_TapScanner-1.jpg',
                'description' => 'Penghargaan sinergi dan koordinasi antar instansi penerbangan.',
                'sort_order' => 8,
            ],
            [
                'title' => 'Sertifikat Penghargaan Pelayanan Bandara 2022 #9',
                'issuer' => 'Kementerian Perhubungan RI',
                'year' => 2022,
                'image' => 'media/legacy/2022/10/Screenshot_20221024-100101_TapScanner-1.jpg',
                'description' => 'Apresiasi penerapan standar mutu ISO dan layanan BLU.',
                'sort_order' => 9,
            ],
        ];

        foreach ($legacyAwards as $awardData) {
            Award::updateOrCreate(
                ['title' => $awardData['title']],
                array_merge($awardData, ['is_active' => true])
            );
        }
    }
}
