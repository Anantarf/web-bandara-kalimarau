<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RoleScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_receives_content_and_layanan_permissions_but_not_system_ones(): void
    {
        Artisan::call('db:seed', ['--class' => RoleSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $admin = User::factory()->create();
        $admin->syncRoles(['admin']);

        $this->assertTrue($admin->can('view_any_flight::schedule'));
        $this->assertTrue($admin->can('update_contact::message'));
        $this->assertTrue($admin->can('update_airport::stat'));
        $this->assertTrue($admin->can('view_any_post'));
        $this->assertTrue($admin->can('create_post'));
        $this->assertFalse($admin->can('view_any_page'));
        $this->assertFalse($admin->can('view_any_category'));
        $this->assertFalse($admin->can('view_any_public::service::link'));
        $this->assertFalse($admin->can('view_any_redirect'));
        $this->assertFalse($admin->can('view_any_audit::log'));
        $this->assertFalse($admin->can('view_any_user'));
    }
}
