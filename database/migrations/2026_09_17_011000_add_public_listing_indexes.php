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
            $table->index(['is_active', 'category', 'sort_order', 'published_at'], 'ppid_documents_public_listing_index');
        });

        Schema::table('facilities', function (Blueprint $table) {
            $table->index('order');
        });

        Schema::table('public_service_links', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_service_links', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });

        Schema::table('facilities', function (Blueprint $table) {
            $table->dropIndex(['order']);
        });

        Schema::table('ppid_documents', function (Blueprint $table) {
            $table->dropIndex('ppid_documents_public_listing_index');
        });
    }
};
