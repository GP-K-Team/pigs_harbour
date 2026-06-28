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
        Schema::create('food_product_hashtag', function (Blueprint $table) {
            $table->unsignedBigInteger('food_product_id')->nullable();
            $table->unsignedBigInteger('hashtag_id')->nullable();

            $table->foreign('food_product_id')->references('id')->on('food_products')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('hashtag_id')->references('id')->on('hashtags')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_product_hashtag');
    }
};
