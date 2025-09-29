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
    Schema::create('restaurant_delivery_options', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('restaurant_id');
        $table->string('delivery_type', 50); // Delivery / Takeaway
        $table->decimal('min_order', 10, 2)->nullable();
        $table->decimal('fee', 10, 2)->nullable();
        $table->string('estimated_time')->nullable();
        $table->string('pickup_hours')->nullable(); // for takeaway
        $table->timestamps();

        $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_delivery_options');
    }
};
