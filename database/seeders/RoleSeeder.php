<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Content entities Admin Konten manages fully; Users/Roles stay super_admin-only.
     */
    protected const ADMIN_KONTEN_ENTITIES = [
        'category',
        'page',
        'post',
        'media',
        'flight::schedule',
        'public::service::link',
        'contact::message',
    ];

    protected const ADMIN_KONTEN_ACTIONS = [
        'view', 'view_any', 'create', 'update', 'delete', 'delete_any', 'reorder',
    ];

    protected const OPERATOR_LAYANAN_ENTITIES = [
        'flight::schedule',
        'public::service::link',
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

        $adminKonten = Role::firstOrCreate(['name' => 'admin_konten']);
        $adminKonten->syncPermissions(
            Permission::query()
                ->where(function ($query) {
                    foreach (self::ADMIN_KONTEN_ENTITIES as $entity) {
                        foreach (self::ADMIN_KONTEN_ACTIONS as $action) {
                            $query->orWhere('name', "{$action}_{$entity}");
                        }
                    }
                })
                ->get()
        );

        $editorBerita = Role::firstOrCreate(['name' => 'editor_berita']);
        $editorBerita->syncPermissions(
            Permission::query()
                ->whereIn('name', ['view_post', 'view_any_post', 'create_post', 'update_post', 'delete_post'])
                ->get()
        );

        $operatorLayanan = Role::firstOrCreate(['name' => 'operator_layanan']);
        $operatorLayanan->syncPermissions(
            Permission::query()
                ->where(function ($query) {
                    foreach (self::OPERATOR_LAYANAN_ENTITIES as $entity) {
                        foreach (self::ADMIN_KONTEN_ACTIONS as $action) {
                            $query->orWhere('name', "{$action}_{$entity}");
                        }
                    }

                    foreach (['view', 'view_any', 'update'] as $action) {
                        $query->orWhere('name', "{$action}_contact::message");
                    }
                })
                ->get()
        );
    }
}
