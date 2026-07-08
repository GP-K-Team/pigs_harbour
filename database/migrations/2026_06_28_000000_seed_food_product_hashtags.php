<?php

use App\Enum\HashtagType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    private const TAGS = [
        'Можно',
        'Нельзя',
        'С осторожностью',
        'Овощи',
        'Фрукты',
        'Ягоды',
        'Зелень',
        'Ветки',
        'Растения',
        'Цветы',
        'Семена',
        'Разное',
        'При МКБ',
        'При беременности и лактации',
    ];

    public function up(): void
    {
        foreach (self::TAGS as $tag) {
            DB::table('hashtags')->updateOrInsert(
                ['tag' => $tag],
                [
                    'slug' => Str::of($tag)->lower()->transliterate()->slug()->toString(),
                    'type' => HashtagType::PRODUCT->value,
                ],
            );
        }
    }

    public function down(): void
    {
        DB::table('hashtags')
            ->where('type', HashtagType::PRODUCT->value)
            ->whereIn('tag', self::TAGS)
            ->delete();
    }
};
