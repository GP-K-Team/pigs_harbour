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
            $mainWord = Str::before($word, $tail);

            $result = self::getCityLocativeForm($mainWord) . $tail;
        }

        $rules = [
            'лец' => 'льце',
            'ец' => 'це',
            'зи' => 'зях',
            'кий' => 'ком',
            'ль' => 'ле',
            'ний' => 'нем',
            'но' => 'но',
            'ой' => 'ом',
            'ое' => 'ом',
            'рел' => 'рле',
            'рь' => 'ре',
            'чи' => 'чи',
            'ый' => 'ом',
            'ь' => 'и',
        ];

        $ruleApplied = false;

        foreach ($rules as $ending => $replacement) {
            if (Str::endsWith($result ?? $word, $ending)) {
                $result = Str::replace($ending, $replacement, $word);
                $ruleApplied = true;

                break;
            }
        }

        if (!$ruleApplied) {
            $lastLetter = Str::charAt($word, -1);
            $result = (self::isVowel($lastLetter) ? Str::chopEnd($word, $lastLetter) : $word) . 'е';
        }

        return $result ?? $word;
    }
}
