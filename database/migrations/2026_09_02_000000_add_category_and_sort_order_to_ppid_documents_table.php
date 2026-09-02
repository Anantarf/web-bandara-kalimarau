<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppid_documents', function (Blueprint $table) {
            $table->string('category')->default('informasi-berkala')->after('description');
            $table->unsignedSmallInteger('sort_order')->default(0)->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('ppid_documents', function (Blueprint $table) {
            $table->dropColumn(['category', 'sort_order']);
        });
    }
};
