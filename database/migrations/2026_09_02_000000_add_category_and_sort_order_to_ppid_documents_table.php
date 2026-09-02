<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppid_documents', function (Blueprint $table) {
            if (! Schema::hasColumn('ppid_documents', 'category')) {
                $table->string('category')->default('informasi-berkala')->after('description');
            }

            if (! Schema::hasColumn('ppid_documents', 'sort_order')) {
                $table->unsignedSmallInteger('sort_order')->default(0)->after('published_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ppid_documents', function (Blueprint $table) {
            if (Schema::hasColumn('ppid_documents', 'category')) {
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('ppid_documents', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
