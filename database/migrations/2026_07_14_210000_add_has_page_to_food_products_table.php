<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('food_products', function (Blueprint $table) {
            $table->boolean('has_page')->default(true);
            $table->string('description')->nullable()->change();
            $table->text('text')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('food_products', function (Blueprint $table) {
            $table->dropColumn('has_page');
            $table->string('description')->nullable(false)->change();
            $table->text('text')->nullable(false)->change();
        });
    }
};
