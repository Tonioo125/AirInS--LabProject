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
        Schema::create('properties', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->string('user_id', 5);
            $table->string('category_id', 5);
            $table->string('title', 100);
            $table->string('description', 255);
            $table->string('photos', 255);
            $table->string('location', 50);
            $table->bigInteger('price');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('airusers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('property_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
