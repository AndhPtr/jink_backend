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
        Schema::create('text_content', function (Blueprint $table) {
            $table->id();
            $table->text('content'); // Text content column
            $table->timestamps();
        });

        Schema::create('link_content', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // Link URL
            $table->string('label'); // Link label
            $table->timestamps();
        });

        Schema::create('image_content', function (Blueprint $table) {
            $table->id();
            $table->string('image_url'); // Image URL
            $table->string('alt_text')->nullable(); // Alternative text for the image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_content');
    }
};
