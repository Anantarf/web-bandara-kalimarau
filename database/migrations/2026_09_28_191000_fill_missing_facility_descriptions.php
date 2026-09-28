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
        $facility1 = Facility::where('name', 'Petugas Khusus Layanan Penumpang')->first();
        if ($facility1 && (empty($facility1->details) || count($facility1->details) === 0)) {
            $facility1->details = [
                'Petugas khusus yang siap mendampingi dan memberikan asistensi bagi penumpang berkebutuhan khusus.',
                'Membantu alur informasi, check-in, dan mobilitas difabel, lansia, serta penumpang prioritas.',
            ];
            $facility1->save();
        }

        $facility2 = Facility::where('name', 'Layanan Jemput Bola bagi Kelompok Rentan')->first();
        if ($facility2 && (empty($facility2->details) || count($facility2->details) === 0)) {
            $facility2->details = [
                'Layanan pendampingan aktif oleh petugas bandara untuk menjemput dan membantu penumpang kelompok rentan sejak tiba di terminal.',
                'Memudahkan akses bagi penumpang lansia, difabel, dan ibu hamil menuju area layanan keberangkatan atau kedatangan.',
            ];
            $facility2->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
