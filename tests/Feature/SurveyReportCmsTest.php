<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\SurveyReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class SurveyReportCmsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_published_scope_and_ordering(): void
    {
        SurveyReport::create([
            'title' => 'Laporan Bulan Januari 2024',
            'period_date' => '2024-01-01',
            'external_url' => 'https://drive.google.com/file/d/test12345/view',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        SurveyReport::create([
            'title' => 'Laporan Bulan Februari 2024',
            'period_date' => '2024-02-01',
            'external_url' => 'https://drive.google.com/file/d/test67890/view',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        SurveyReport::create([
            'title' => 'Laporan Nonaktif',
            'period_date' => '2024-03-01',
            'is_active' => false,
            'sort_order' => 0,
        ]);

        $reports = SurveyReport::published()->orderBy('sort_order')->get();

        $this->assertCount(2, $reports);
        $this->assertSame('Laporan Bulan Februari 2024', $reports->first()->title);
        $this->assertSame('test67890', $reports->first()->google_drive_id);
        $this->assertSame('https://drive.google.com/thumbnail?id=test67890&sz=w800', $reports->first()->thumbnail_url);
    }

    public function test_survey_report_renders_on_public_page(): void
    {
        Page::create([
            'title' => 'Survey Kepuasan Masyarakat',
            'slug' => 'survey-kepuasan-masyarakat-internal',
            'content' => 'Konten survey',
            'status' => 'published',
            'published_at' => now(),
        ]);

        SurveyReport::create([
            'title' => 'Bulan September 2024 Test',
            'period_date' => '2024-09-01',
            'external_url' => 'https://drive.google.com/file/d/abcxyz999/view',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get('/survey-kepuasan-masyarakat-internal');
        $response->assertStatus(200);
        $response->assertSee('Bulan September 2024 Test');
        $response->assertSee('https://drive.google.com/file/d/abcxyz999/view');
    }

    public function test_admin_can_access_survey_reports_in_filament(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['super_admin']);

        $response = $this->actingAs($admin)->get('/admin/survey-reports');
        $response->assertStatus(200);
    }
}
