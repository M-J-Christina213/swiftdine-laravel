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
    Schema::create('restaurant_hours', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('restaurant_id');
        $table->string('day', 20);       
        $table->time('open_time');
        $table->time('close_time');
        $table->timestamps();

        $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_hours');
    }
};
