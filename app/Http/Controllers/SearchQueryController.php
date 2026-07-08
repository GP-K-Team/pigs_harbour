<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FoodProduct;
use App\Models\SearchQuery;
use Illuminate\View\View;

class SearchQueryController extends Controller
{
    public const PAGINATE_ITEMS_COUNT = 20;

    public function index(): View
    {
        $type = request()->query('type', Article::searchType());

        if (!in_array($type, [Article::searchType(), FoodProduct::searchType()])) {
            $type = Article::searchType();
        }

        $searchQueries = SearchQuery::ofType($type)
            ->orderByDesc('updated_at')
            ->paginate(self::PAGINATE_ITEMS_COUNT)
            ->withQueryString();

        return \view('admin.search-queries', compact('searchQueries', 'type'));
    }
}
