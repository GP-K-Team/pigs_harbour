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
        Schema::table('pigs', function (Blueprint $table) {
            if (!Schema::hasIndex('pigs', ['slug_name'], 'unique')) {
                $table->unique(['slug_name']);
            }

            if (Schema::hasIndex('pigs', ['slug_name'])) {
                $table->dropIndex(['slug_name']);
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasIndex('articles', ['slug_title'], 'unique')) {
                $table->unique(['slug_title']);
            }

            if (Schema::hasIndex('articles', ['slug_title'])) {
                $table->dropIndex(['slug_title']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pigs', function (Blueprint $table) {
            if (Schema::hasIndex('pigs', ['slug_name'], 'unique')) {
                $table->dropUnique(['slug_name']);
            }

            if (!Schema::hasIndex('pigs', ['slug_name'])) {
                $table->index(['slug_name']);
            }
        });

        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasIndex('articles', ['slug_title'], 'unique')) {
                $table->dropUnique(['slug_title']);
            }

            if (!Schema::hasIndex('articles', ['slug_title'])) {
                $table->index(['slug_title']);
            }
        });
    }
};
