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
        Schema::create('image_pig', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('pig_id')->nullable();

            $table->foreign('pig_id')->references('id')->on('pigs')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->boolean('is_main')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_pig');
    }
};
