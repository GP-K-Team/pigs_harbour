<?php

use App\Enum\HashtagType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hashtags', function (Blueprint $table) {
            $table->string('type')->nullable()->index()->after('slug');
        });

        DB::table('hashtags')->update(['type' => HashtagType::ARTICLE->value]);
    }

    public function down(): void
    {
        //
    }
};
