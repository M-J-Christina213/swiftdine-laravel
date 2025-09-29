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
    Schema::create('restaurant_payment_options', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('restaurant_id');
        $table->string('payment_method', 50); // Cash, Visa, etc
        $table->timestamps();

        $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_payment_options');
    }
};
