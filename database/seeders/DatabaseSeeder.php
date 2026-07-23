<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(FacilitySeeder::class);

        $adminEmail = env('SEED_ADMIN_EMAIL', 'admin@kalimarau.local');
        $adminPassword = env('SEED_ADMIN_PASSWORD');

        if (app()->isProduction() && blank($adminPassword)) {
            throw new RuntimeException('SEED_ADMIN_PASSWORD must be set before seeding the production admin user.');
        }

        $admin = User::updateOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => env('SEED_ADMIN_NAME', 'Super Admin'),
            'username' => env('SEED_ADMIN_USERNAME', 'superadmin'),
            'password' => Hash::make($adminPassword ?: 'password'),
            'is_active' => true,
        ]);

        $admin->syncRoles(['super_admin']);
    }
}
