<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Content and layanan entities Admin manages fully; Users/Roles/Redirect/Audit Log stay super_admin-only.
     */
    protected const ADMIN_ENTITIES = [
        'category',
        'page',
        'post',
        'media',
        'flight::schedule',
        'public::service::link',
        'contact::message',
    ];

    protected const ADMIN_ACTIONS = [
        'view', 'view_any', 'create', 'update', 'delete', 'delete_any', 'reorder',
    ];

    public function run(): void
    {
        // Recreates the permission rows Shield generates from Filament resources/policies,
        // so `permissions` stays reproducible across fresh databases (tests, staging, prod).
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
            '--option' => 'permissions',
            '--no-interaction' => true,
        ]);

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(
            Permission::query()
                ->where(function ($query) {
                    foreach (self::ADMIN_ENTITIES as $entity) {
                        foreach (self::ADMIN_ACTIONS as $action) {
                            $query->orWhere('name', "{$action}_{$entity}");
                        }
                    }
                })
                ->get()
        );

        Role::whereIn('name', ['admin_konten', 'editor_berita', 'operator_layanan'])->delete();
    }
}
