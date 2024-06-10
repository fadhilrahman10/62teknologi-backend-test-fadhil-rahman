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
        Schema::create('businesses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('alias');
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->boolean('is_closed');
            $table->string('url');
            $table->integer('review_count');
            $table->float('rating', 3, 2);
            $table->string('price', 10)->nullable();
            $table->float('latitude', 10, 6);
            $table->float('longitude', 10, 6);
            $table->string('phone', 20);
            $table->string('display_phone', 20);
            $table->float('distance', 10, 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
