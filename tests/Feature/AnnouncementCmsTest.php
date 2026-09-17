<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AnnouncementCmsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_active_scope_filters_by_status_and_dates(): void
    {
        Announcement::create([
            'title' => 'Pengumuman Aktif',
            'message' => 'Pesan aktif sekarang',
            'type' => 'info',
            'is_active' => true,
        ]);

        Announcement::create([
            'title' => 'Pengumuman Nonaktif',
            'message' => 'Pesan tidak aktif',
            'type' => 'danger',
            'is_active' => false,
        ]);

        Announcement::create([
            'title' => 'Pengumuman Masa Depan',
            'message' => 'Pesan masa depan',
            'type' => 'warning',
            'is_active' => true,
            'starts_at' => now()->addDays(2),
        ]);

        Announcement::create([
            'title' => 'Pengumuman Sudah Lewat',
            'message' => 'Pesan lampau',
            'type' => 'warning',
            'is_active' => true,
            'ends_at' => now()->subDay(),
        ]);

        $active = Announcement::active()->get();

        $this->assertCount(1, $active);
        $this->assertSame('Pengumuman Aktif', $active->first()->title);
    }

    public function test_announcement_renders_on_public_home_page(): void
    {
        Announcement::create([
            'title' => 'Pemberitahuan Cuaca Ekstrem',
            'message' => 'Seluruh penumpang diimbau hadir 2 jam sebelum keberangkatan.',
            'type' => 'warning',
            'action_label' => 'Cek Jadwal',
            'action_url' => '/jadwal-penerbangan',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Pemberitahuan Cuaca Ekstrem');
        $response->assertSee('Seluruh penumpang diimbau hadir 2 jam sebelum keberangkatan.');
        $response->assertSee('Cek Jadwal');
    }

    public function test_admin_can_access_announcements_in_filament(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['super_admin']);

        $response = $this->actingAs($admin)->get('/admin/announcements');
        $response->assertStatus(200);
    }
}
