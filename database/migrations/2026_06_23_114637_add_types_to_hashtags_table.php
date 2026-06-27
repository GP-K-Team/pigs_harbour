<?php

use App\Enum\HashtagType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hashtags', function (Blueprint $table) {
            $table->string('type')->nullable()->index()->after('slug');
        });

        DB::statement("UPDATE hashtags SET type = " . HashtagType::ARTICLE->value);
    }

    public function down(): void
    {
        Schema::table('hashtags', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
