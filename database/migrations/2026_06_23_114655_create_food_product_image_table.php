<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('food_product_image', function (Blueprint $table) {
            $table->unsignedBigInteger('food_product_id');
            $table->unsignedBigInteger('image_id');
            $table->boolean('is_main')->default(false);

            $table->foreign('food_product_id')->references('id')->on('food_products')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('image_id')->references('id')->on('images')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_product_image');
    }
};
