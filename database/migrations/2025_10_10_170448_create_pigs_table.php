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
        Schema::create('pigs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug_name')->nullable()->index();
            $table->string('sex')->nullable();
            $table->string('description')->nullable();
            $table->string('fur')->nullable();
            $table->string('age')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('available_for_other_cities')->default(true);
            $table->boolean('is_active')->default(true);
            $table->date('stopped_looking_date')->nullable();

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('companion_pig_id')->nullable();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('companion_pig_id')->references('id')->on('pigs')->onDelete('cascade');

            $table->index(['sex', 'fur', 'birthday']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pigs');
    }
};
