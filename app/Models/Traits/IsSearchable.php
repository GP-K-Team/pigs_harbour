<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use Laravel\Scout\Searchable;

trait IsSearchable
{
    use Searchable;

    public const QUERY_PARAM = 'search_query';

    public static function searchFor(string $searchText): Collection
    {
        return static::search(trim($searchText))->get();
    }

    public static function searchType(): string
    {
        return static::SEARCH_TYPE;
    }
}
