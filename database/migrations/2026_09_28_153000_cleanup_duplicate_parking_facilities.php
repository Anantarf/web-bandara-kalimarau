<?php

use App\Models\Facility;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete redundant duplicate facility records
        Facility::whereIn('name', [
            'Portal Masuk & Keluar Kendaraan Roda 4',
            'Portal Masuk & Keluar Kendaraan Roda 2',
        ])->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
