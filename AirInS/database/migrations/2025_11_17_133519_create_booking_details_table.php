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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->string('booking_id', 5);
            $table->string('property_id', 5);
            $table->integer('guest_count');
            $table->bigInteger('price_per_night');
            $table->timestamps();
            $table->unique('booking_id');
            $table->foreign('booking_id')->references('id')->on('booking_headers')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
