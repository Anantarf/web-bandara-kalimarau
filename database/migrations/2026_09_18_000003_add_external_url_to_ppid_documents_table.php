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
        Schema::table('ppid_documents', function (Blueprint $table) {
            $table->string('file_path')->nullable()->change();
            $table->string('external_url')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppid_documents', function (Blueprint $table) {
            $table->dropColumn('external_url');
            $table->string('file_path')->nullable(false)->change();
        });
    }
};
