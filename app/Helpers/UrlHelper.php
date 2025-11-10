<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Attributes\FilterLabel;
use App\Attributes\FilterValue;
use App\Enum\AgeFilter;
use App\Enum\Fur;
use App\Enum\Sex;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class UrlHelper
{
    public function collectFilters(): array
    {
        $routePrefix = $this->getCurrentPage();
        $urlPath = request()->path();
        $filters = [];

        Str::of($urlPath)
            ->trim('/')
            ->after($routePrefix)
            ->explode('/')
            ->filter()
            ->each(function (string $param) use (&$filters) {
                if ($sex = Sex::tryFrom($param) ?? Sex::tryFromAttribute(FilterValue::class, $param)) {
                    $filters['sex'] = $sex;
                } elseif ($age = AgeFilter::tryFromAttribute(FilterLabel::class, $param)) {
                    $filters['age'] = $age;
                } elseif ($fur = Fur::tryFromAttribute(FilterLabel::class, $param)) {
                    $filters['fur'] = $fur;
                } else {
                    $filters['city'] = $param;
                }
            });

        return $filters;
    }


    /**
     * @return Stringable
     */
    public function getCurrentPage(): Stringable
    {
        return Str::of(request()->route()->uri)->before('{')->trim('/');
    }
}
