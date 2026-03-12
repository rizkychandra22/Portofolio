<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('portofolio_images', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('portofolio_descriptions', function (Blueprint $table) {
            $table->index('type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('portofolio_images', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('portofolio_descriptions', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['created_at']);
        });
    }
};
