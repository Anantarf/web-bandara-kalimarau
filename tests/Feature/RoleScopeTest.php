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

    public function test_service_operator_only_receives_service_and_contact_permissions(): void
    {
        Artisan::call('db:seed', ['--class' => RoleSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $operator = User::factory()->create();
        $operator->syncRoles(['operator_layanan']);

        $this->assertTrue($operator->can('view_any_flight::schedule'));
        $this->assertTrue($operator->can('update_public::service::link'));
        $this->assertTrue($operator->can('update_contact::message'));
        $this->assertFalse($operator->can('create_contact::message'));
        $this->assertFalse($operator->can('view_any_post'));
        $this->assertFalse($operator->can('view_any_redirect'));
        $this->assertFalse($operator->can('view_any_audit::log'));
        $this->assertFalse($operator->can('view_any_user'));
    }
}
