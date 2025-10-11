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
        Schema::create('article_hashtag', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->nullable();
            $table->unsignedBigInteger('hashtag_id')->nullable();

            $table->foreign('article_id')->references('id')->on('articles')
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
        Schema::dropIfExists('article_hashtag');
    }
};
