<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airport_stats', function (Blueprint $table) {
            $table->id();
            $table->string('period_name')->comment('Contoh: Juli 2026');
            $table->date('period_date')->nullable();
            $table->integer('passenger_count')->default(0);
            $table->integer('flight_count')->default(0);
            $table->integer('cargo_count')->default(0)->comment('Dalam Kg');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_stats');
    }
};
