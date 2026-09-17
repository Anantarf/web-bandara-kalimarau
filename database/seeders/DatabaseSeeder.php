<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $this->call(PageSeeder::class);
        $this->call(PublicServiceLinkSeeder::class);
        $this->call(PpidDocumentSeeder::class);
        $this->call(AwardSeeder::class);
        $this->call(SurveyReportSeeder::class);

        Category::firstOrCreate(
            ['slug' => 'berita'],
            ['name' => 'Berita', 'sort_order' => 0],
        );

        $adminEmail = env('SEED_ADMIN_EMAIL', 'admin@kalimarau.local');
        $adminUsername = env('SEED_ADMIN_USERNAME', 'superadmin');
        $adminPassword = env('SEED_ADMIN_PASSWORD');

        if (app()->isProduction() && blank($adminPassword) && ! User::query()->where('username', $adminUsername)->orWhere('email', $adminEmail)->exists()) {
            throw new RuntimeException('SEED_ADMIN_PASSWORD must be set before seeding the production admin user.');
        }

        $admin = User::query()
            ->where('username', $adminUsername)
            ->orWhere('email', $adminEmail)
            ->first();

        if ($admin) {
            $updateData = [
                'name' => env('SEED_ADMIN_NAME', 'Super Admin'),
                'username' => $adminUsername,
                'email' => $adminEmail,
                'is_active' => true,
            ];

            if (filled($adminPassword)) {
                $updateData['password'] = Hash::make($adminPassword);
            }

            $admin->update($updateData);
        } else {
            $admin = User::create([
                'name' => env('SEED_ADMIN_NAME', 'Super Admin'),
                'username' => $adminUsername,
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword ?: 'password'),
                'is_active' => true,
            ]);
        }

        $admin->syncRoles(['super_admin']);
    }
}
