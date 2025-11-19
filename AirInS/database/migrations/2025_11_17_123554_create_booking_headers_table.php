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
        Schema::create('booking_headers', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->foreignId('user_id')->constrained('airusers')->onDelete('cascade');
            $table->date('booking_date');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->bigInteger('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_headers');
    }
};
