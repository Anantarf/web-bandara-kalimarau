<?php

namespace Database\Seeders;

use App\Models\PublicServiceLink;
use Illuminate\Database\Seeder;

class PublicServiceLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            [
                'title' => 'SP4N-LAPOR!',
                'slug' => 'sp4n-lapor',
                'description' => 'Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional',
                'url' => 'https://www.lapor.go.id',
                'category' => 'Pengaduan',
                'is_external' => true,
                'is_active' => true,
                'icon' => 'heroicon-o-megaphone',
                'sort_order' => 1,
            ],
            [
                'title' => 'SIMADU Kemenhub',
                'slug' => 'simadu',
                'description' => 'Sistem Manajemen Pengaduan Kementerian Perhubungan',
                'url' => 'https://simadu.dephub.go.id/',
                'category' => 'Pengaduan',
                'is_external' => true,
                'is_active' => true,
                'icon' => 'heroicon-o-shield-check',
                'sort_order' => 2,
            ],
            [
                'title' => 'IDPAS Airport Pass Online',
                'slug' => 'idpas',
                'description' => 'Aplikasi Permohonan Pass Bandar Udara Kalimarau',
                'url' => 'https://idpas.kalimarau-airport.com',
                'category' => 'Layanan Bandara',
                'is_external' => true,
                'is_active' => true,
                'icon' => 'heroicon-o-identification',
                'sort_order' => 3,
            ],
            [
                'title' => 'Survei Kepuasan Masyarakat',
                'slug' => 'survei-kepuasan',
                'description' => 'Survei Penilaian Pelayanan Publik Bandara Kalimarau',
                'url' => 'https://skm.dephub.go.id',
                'category' => 'Survei',
                'is_external' => true,
                'is_active' => true,
                'icon' => 'heroicon-o-clipboard-document-check',
                'sort_order' => 4,
            ],
        ];

        foreach ($links as $link) {
            PublicServiceLink::updateOrCreate(
                ['slug' => $link['slug']],
                $link
            );
        }
    }
}
