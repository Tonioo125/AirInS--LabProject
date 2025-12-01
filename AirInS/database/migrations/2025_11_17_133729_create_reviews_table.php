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
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->string('booking_id', 5);
            $table->integer('rating');
            $table->string('comment', 255);
            $table->timestamps();

            $table->unique('booking_id');
            $table->foreign('booking_id')->references('id')->on('booking_headers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
