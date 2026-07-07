<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\HashtagType;
use App\Helpers\UrlHelper;
use App\Http\Requests\Article\CreateArticleFormRequest;
use App\Http\Requests\Article\UpdateArticleFormRequest;
use App\Models\Article;
use App\Models\Hashtag;
use App\Models\PageText;
use App\Models\SearchQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(UrlHelper $urlHelper, string $slug = ''): View
    {
        $state = 'published';

        if ($slug) {
            if ($articleBySlug = Article::query()->firstWhere('slug_title', $slug)) {
                return $this->showOne($articleBySlug);
            }

            abort_unless(Hashtag::ofType(HashtagType::ARTICLE)->activeOnly(HashtagType::ARTICLE)->where('slug', $slug)->exists(), 404);
        }

        $searchText = request()->query(Article::SEARCH_QUERY_PARAM);

        if (is_null($searchText)) {
            $articlesBuilder = Article::published()->with('images');
        } else {
            $articlesBuilder = Article::getSearchQuery($searchText);
        }

        if ($slug) {
            $articlesBuilder->whereHas('hashtags', function (Builder $query) use ($slug) {
               $query->where(['slug' => $slug]);
            });
        }

        if (is_null($searchText)) {
            $articlesBuilder->orderByDesc('created_at');
        }

        $articles = $articlesBuilder->paginate(Article::PAGINATE_ITEMS_COUNT)->withQueryString();

        if (!is_null($searchText)) {
            SearchQuery::addRecord($searchText, Article::searchType(), !$articles->total());
        }

        $hashtags = Hashtag::ofType(HashtagType::ARTICLE)->activeOnly(HashtagType::ARTICLE)->get();
        $pageTexts = PageText::where('page_base_url', '=', $urlHelper->getCurrentPage())->get();
        $activeHashtagSlug = $slug;

        return \view('articles.index', compact('articles', 'hashtags', 'activeHashtagSlug', 'pageTexts', 'state'));
    }

    public function showUnpublished(UrlHelper $urlHelper): View
    {
        $state = 'unpublished';
        $articles = Article::unpublished()->with('images')->orderByDesc('created_at')->paginate(Article::PAGINATE_ITEMS_COUNT);
        $pageTexts = PageText::where('page_base_url', '=', $urlHelper->getCurrentPage())->get();

        return \view('articles.index', compact('articles', 'pageTexts', 'state'));
    }

    public function showOne(Article $article): View
    {
        $hashtags = Hashtag::ofType(HashtagType::ARTICLE)->activeOnly(HashtagType::ARTICLE)->get();
        $additionalArticles = Article::published()->whereHas('hashtags', function (Builder $query) use ($article) {
            $query->whereIn('tag', $article->hashtags()->pluck('tag')->toArray() ?? []);
        })->where('id', '!=', $article->id)->inRandomOrder()->take(3)->get();

        return \view('articles.one', compact('article', 'hashtags', 'additionalArticles'));
    }

    public function showCreate(): View
    {
        $hashtags = Hashtag::ofType(HashtagType::ARTICLE)->pluck('tag', 'id');

        return \view('articles.form', compact('hashtags'));
    }

    public function showUpdate(Article $article): View
    {
        $hashtags = Hashtag::ofType(HashtagType::ARTICLE)->pluck('tag', 'id');

        return \view('articles.form', compact('article', 'hashtags'));
    }

    public function create(CreateArticleFormRequest $request): RedirectResponse
    {
        $formData = $request->validated();

        $article = new Article();
        $article->fill($formData)->save();

        if ($request->has('cover')) {
            $article->uploadImages($formData['cover']);
        }

        if ($request->has('hashtags')) {
            $hashtagIds = Hashtag::getOrCreateIds($formData['hashtags'], HashtagType::ARTICLE);
            $article->hashtags()->sync($hashtagIds);
        }

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function update(UpdateArticleFormRequest $request, Article $article): RedirectResponse
    {
        $formData = $request->validated();

        $article->fill($formData)->save();

        if ($request->has('cover') && !is_string($formData['cover'])) {
            if ($article->mainImage) {
                $article->mainImage->delete();
            }
            $article->uploadImages($formData['cover']);
        }

        if ($request->has('hashtags')) {
            $hashtagIds = Hashtag::getOrCreateIds($formData['hashtags'], HashtagType::ARTICLE);
            $article->hashtags()->sync($hashtagIds);
        }

        return \response()->redirectToAction([self::class, 'showOne'], compact('article'));
    }

    public function delete(Article $article): RedirectResponse
    {
        $article->deleteImages();
        $article->delete();

        return \response()->redirectToAction([self::class, 'index']);
    }
}
