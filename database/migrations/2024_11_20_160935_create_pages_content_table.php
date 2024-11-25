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
        Schema::create('pages_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pages_id'); // Foreign key to the pages table
            $table->morphs('blockable'); // This creates blockable_id and blockable_type
            $table->timestamps();

            // Foreign key pointing to the pages table
            $table->foreign('pages_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_content');
    }
};
