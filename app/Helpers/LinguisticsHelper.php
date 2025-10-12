<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Str;

class LinguisticsHelper
{
    public static function isVowel(string $letter): bool
    {
        $vowels = [
            'а', 'о', 'у', 'е', 'ё', 'и', 'э', 'ю', 'я',
            'a', 'e', 'y', 'u', 'i', 'o',
        ];

        return in_array($letter, $vowels);
    }

    public static function getCityLocativeForm(string $word): string
    {
        $isRiverCityWord = Str::contains($word, '-на-', ignoreCase: true);

        if ($isRiverCityWord) {
            $tail = Str::of($word)->after('-')->prepend('-');
            $word = Str::before($word, $tail);
        }

        $wordEnding = Str::charAt($word, -1);
        $result = match ($wordEnding) {
            'ь' => Str::of($word)->chopEnd($wordEnding)->append('и')->toString(),
            default => (LinguisticsHelper::isVowel($wordEnding) ? Str::chopEnd($word, $wordEnding) : $word) . 'е',
        };

        return $result . ($isRiverCityWord ? $tail : '');
    }
}
