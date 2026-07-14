<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Laravel\Scout\Searchable;

trait IsSearchable
{
    use Searchable;

    public const SEARCH_QUERY_PARAM = 'query';

    public static function searchFor(string $searchText): Collection
    {
        return static::search(trim($searchText))->get();
    }

    public static function getSearchQuery(string $searchText): \Laravel\Scout\Builder
    {
        return static::search(trim($searchText));
    }

    public static function searchType(): string
    {
        return static::SEARCH_TYPE;
    }
}
