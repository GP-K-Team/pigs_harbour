<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enum\Sex;
use Illuminate\Support\Str;

class LinguisticsHelper
{
    /**
     * @param string $masculineForm
     * @param Sex $sex
     * @return string
     */
    public static function getGenderedForm(string $masculineForm, Sex $sex): string
    {
        $genderedForm = $masculineForm;

        if ($sex === Sex::FEMALE) {
            if (Str::endsWith($masculineForm, 'шел')) {
                $genderedForm = Str::substr($masculineForm, 0, -2) . 'ла';
            } elseif (Str::endsWith($masculineForm, ['н', 'в'])) {
                $genderedForm .= 'а';
            }
        }

        return $genderedForm;
    }

    public static function isVowel(string $letter): bool
    {
        $vowels = [
            'а', 'о', 'у', 'е', 'ё', 'и', 'э', 'ю', 'я',
            'a', 'e', 'y', 'u', 'i', 'o',
        ];

        return in_array($letter, $vowels);
    }

    /**
     * @example 'Москва' => 'Москве', 'Нижний Новгород' => 'Нижнем Новгороде', etc.
     */
    public static function getCityLocativeForm(string $word): string
    {
        $word = Str::of($word);

        $parentheses = $word->contains('(') ? $word->after('(')->prepend('(') : null;
        $word = $word->before($parentheses ?? '')->rtrim();

        $isRiverCityWord = $word->contains('-на-', ignoreCase: true);

        if ($isRiverCityWord) {
            $tail = $word->after('-')->prepend('-');
            $mainWord = $word->before($tail)->toString();

            return self::getCityLocativeForm($mainWord) . $tail;
        } else if (($words = $word->split('/\s/')) && $words->count() > 1) {
            return $words->map(fn ($part) => self::getCityLocativeForm($part))->join(' ');
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
            $lastLetter = $word->charAt(-1);
            $result = (self::isVowel($lastLetter) ? $word->chopEnd($lastLetter) : $word) . 'е';
        }

        return Str::of($result ?? $word)->append(" $parentheses")->rtrim()->toString();
    }

    public static function transliterate(string $text): string
    {
        $text = Str::of($text);
        $customReplace = [
            'х' => 'h',
            'я' => 'ya',
        ];

        return $text->lower()->swap($customReplace)->transliterate()->slug()->toString();
    }
}
