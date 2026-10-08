<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('routes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        $sourceDir = public_path('images/airlines');
        $targetDir = storage_path('app/public/airlines');

        if (File::isDirectory($sourceDir)) {
            File::ensureDirectoryExists($targetDir);
            File::copyDirectory($sourceDir, $targetDir);
        }

        $logoPath = fn (string $filename) => file_exists($targetDir . DIRECTORY_SEPARATOR . $filename)
            ? 'airlines/' . $filename
            : 'images/airlines/' . $filename;

        $now = now();
        $initialAirlines = [
            [
                'name' => 'Batik Air',
                'slug' => 'batik-air',
                'routes' => 'Jakarta (CGK), Surabaya (SUB)',
                'logo' => $logoPath('batik-air.png'),
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Super Air Jet',
                'slug' => 'super-air-jet',
                'routes' => 'Balikpapan (BPN), Surabaya (SUB)',
                'logo' => $logoPath('super-air-jet.png'),
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'AirAsia',
                'slug' => 'airasia',
                'routes' => 'Surabaya (SUB)',
                'logo' => $logoPath('airasia.svg'),
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sriwijaya Air',
                'slug' => 'sriwijaya-air',
                'routes' => 'Balikpapan (BPN), Makassar (UPG)',
                'logo' => $logoPath('sriwijaya-air.png'),
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Citilink',
                'slug' => 'citilink',
                'routes' => 'Balikpapan (BPN)',
                'logo' => $logoPath('citilink.svg'),
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Wings Air',
                'slug' => 'wings-air',
                'routes' => 'Samarinda (AAP), Balikpapan (BPN), Maratua (RTU)',
                'logo' => $logoPath('wings-air.svg'),
                'is_active' => true,
                'sort_order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Smart Aviation',
                'slug' => 'smart-aviation',
                'routes' => 'Maratua (RTU)',
                'logo' => $logoPath('smart-aviation.png'),
                'is_active' => true,
                'sort_order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('airlines')->insert($initialAirlines);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};
