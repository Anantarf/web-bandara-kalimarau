<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminPanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_super_admin_can_access_every_resource_index(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['super_admin']);

        $resources = [
            'posts', 'flight-schedules', 'contact-messages', 'airport-stats', 'ppid-documents', 'audit-logs', 'users',
        ];

        foreach ($resources as $resource) {
            $response = $this->actingAs($admin)->get("/admin/{$resource}");
            $this->assertTrue(
                $response->status() === 200,
                "Resource [{$resource}] returned {$response->status()}: ".$response->exception?->getMessage()
            );
        }

        $auditLog = AuditLog::query()->create([
            'user_id' => $admin->id,
            'event' => 'created',
            'auditable_type' => User::class,
            'auditable_id' => $admin->id,
            'new_values' => ['name' => $admin->name],
        ]);

        $this->actingAs($admin)->get("/admin/audit-logs/{$auditLog->id}")->assertOk();
    }

    public function test_inactive_user_cannot_access_panel(): void
    {
        $user = User::factory()->create(['is_active' => false]);
        $user->syncRoles(['super_admin']);

        $response = $this->actingAs($user)->get('/admin/posts');
        $this->assertContains($response->status(), [302, 403]);
    }

    public function test_user_email_is_generated_from_username_when_hidden_from_admin_form(): void
    {
        $user = User::query()->create([
            'name' => 'Admin Konten',
            'username' => 'admin.konten',
            'password' => 'password',
            'is_active' => true,
        ]);

        $this->assertSame('admin.konten@kalimarau.local', $user->email);
    }

    public function test_audit_log_detail_handles_unknown_event_names(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['super_admin']);

        $auditLog = AuditLog::query()->create([
            'user_id' => $admin->id,
            'event' => 'restored',
            'auditable_type' => User::class,
            'auditable_id' => $admin->id,
            'new_values' => ['name' => $admin->name],
        ]);

        $this->actingAs($admin)
            ->get("/admin/audit-logs/{$auditLog->id}")
            ->assertOk()
            ->assertSee('Restored');
    }
}
