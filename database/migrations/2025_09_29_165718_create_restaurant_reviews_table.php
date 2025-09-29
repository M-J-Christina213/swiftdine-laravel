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
    Schema::create('restaurant_reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('restaurant_id');
        $table->string('user_name', 100);
        $table->string('user_image')->nullable();
        $table->decimal('rating', 2, 1);
        $table->text('review_text');
        $table->date('review_date');
        $table->string('review_image')->nullable();
        $table->timestamps();

        $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_reviews');
    }
};
