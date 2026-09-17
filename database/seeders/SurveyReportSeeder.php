<?php

namespace Database\Seeders;

use App\Models\SurveyReport;
use Illuminate\Database\Seeder;

class SurveyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
                'title' => 'Bulan Agustus 2024',
                'period_date' => '2024-08-01',
                'external_url' => 'https://drive.google.com/file/d/168c9qLjIMP5Yv_HnxIOFwJbuDjzdPB9p/view?usp=sharing',
                'google_drive_id' => '168c9qLjIMP5Yv_HnxIOFwJbuDjzdPB9p',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Bulan Juli 2024',
                'period_date' => '2024-07-01',
                'external_url' => 'https://drive.google.com/file/d/1RHBFHchoTMFc33gAcOBgJCcPFwFcMYe3/view?usp=sharing',
                'google_drive_id' => '1RHBFHchoTMFc33gAcOBgJCcPFwFcMYe3',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Bulan Juni 2024',
                'period_date' => '2024-06-01',
                'external_url' => 'https://drive.google.com/file/d/1hLnJ738R6mVgTcgQ9GlqtrMGRomChR77/view?usp=sharing',
                'google_drive_id' => '1hLnJ738R6mVgTcgQ9GlqtrMGRomChR77',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Bulan Mei 2024',
                'period_date' => '2024-05-01',
                'external_url' => 'https://drive.google.com/file/d/1hjCbhhY7CUZOfFM0FmToHr41gQ3N8ew9/view?usp=sharing',
                'google_drive_id' => '1hjCbhhY7CUZOfFM0FmToHr41gQ3N8ew9',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Bulan April 2024',
                'period_date' => '2024-04-01',
                'external_url' => 'https://drive.google.com/file/d/1EYX-1kbv4OSNimhUJdQOCg7DWHib5_T_/view?usp=sharing',
                'google_drive_id' => '1EYX-1kbv4OSNimhUJdQOCg7DWHib5_T_',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Bulan Maret 2024',
                'period_date' => '2024-03-01',
                'external_url' => 'https://drive.google.com/file/d/1JQgLUwKlN69EnzPcsEJwgqkqKa_S6EwP/view?usp=sharing',
                'google_drive_id' => '1JQgLUwKlN69EnzPcsEJwgqkqKa_S6EwP',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Bulan Februari 2024',
                'period_date' => '2024-02-01',
                'external_url' => 'https://drive.google.com/file/d/1s8wSZm7n4fZ5YfKIpk2N8QC9z1Cl7U8q/view?usp=sharing',
                'google_drive_id' => '1s8wSZm7n4fZ5YfKIpk2N8QC9z1Cl7U8q',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Bulan Januari 2024',
                'period_date' => '2024-01-01',
                'external_url' => 'https://drive.google.com/file/d/1nlemN1rV8VjG_Kq75jljY8Q6jAvgb213/view?usp=sharing',
                'google_drive_id' => '1nlemN1rV8VjG_Kq75jljY8Q6jAvgb213',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($reports as $report) {
            SurveyReport::firstOrCreate(
                ['title' => $report['title']],
                $report
            );
        }
    }
}
