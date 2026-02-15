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
        Schema::create('portofolio_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portofolio_id')->constrained('portofolios')->cascadeOnDelete();
            $table->enum('type', ['overview', 'feature']);
            $table->string('title_id')->nullable(); 
            $table->string('title_en')->nullable(); 
            $table->text('content_id');
            $table->text('content_en');
            $table->string('icon')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_descriptions');
    }
};
