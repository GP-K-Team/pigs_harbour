<?php

namespace App\Helpers;

use App\Models\PageText;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PageTextHelper
{

    /**
     * @param string $additionalString
     * @return Collection
     */
    public static function getPageText(string $additionalString = ''): Collection
    {
        $route = Str::of(request()->route()->uri)->before('{')->trim('/') . $additionalString;

        return PageText::where('page_base_url', '=', $route)->get();
    }
}
