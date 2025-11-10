<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\UrlHelper;
use App\Http\Requests\Article\CreateArticleFormRequest;
use App\Http\Requests\Article\UpdateArticleFormRequest;
use App\Models\Article;
use App\Models\Hashtag;
use App\Models\PageText;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(Request $request, UrlHelper $urlHelper): View
    {
        $activeHashtags = [];

        if ($request->get('hashtags')) {
            $activeHashtags = explode(',', $request->get('hashtags'));
        }

        $articlesBuilder = Article::query()->with('images');

        if (count($activeHashtags)) {
            $articlesBuilder->whereHas('hashtags', function (Builder $query) use ($activeHashtags) {
               $query->whereIn('slug', $activeHashtags);
            });
        }

        $articles = $articlesBuilder->orderByDesc('created_at')->paginate(Article::PAGINATE_ITEMS_COUNT);
        $hashtags = Hashtag::query()->get();
        $isAdmin = Auth::check() ?? false;
        $pageTexts = PageText::where('page_base_url', '=', $urlHelper->getCurrentPage())->get();

        return \view('articles.index', compact('articles', 'isAdmin', 'hashtags', 'activeHashtags', 'pageTexts'));
    }

    public function showOne(Article $article): View
    {
        $isAdmin = Auth::check() ?? false;
        $hashtags = Hashtag::query()->get();
        $additionalArticles = Article::query()->whereHas('hashtags', function (Builder $query) use ($article) {
            $query->whereIn('tag', $article->hashtags()->pluck('tag')->toArray() ?? []);
        })->inRandomOrder()->take(3)->get();

        return \view('articles.one', compact('article', 'isAdmin', 'hashtags', 'additionalArticles'));
    }

    public function showCreate(): View
    {
        $hashtags = Hashtag::query()->pluck('tag', 'id');

        return \view('articles.form', compact('hashtags'));
    }

    public function showUpdate(Article $article): View
    {
        $hashtags = Hashtag::query()->pluck('tag', 'id');

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
            $hashtagIds = Hashtag::getOrCreateIds($formData['hashtags']);
            $article->hashtags()->sync($hashtagIds);
        }

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function update(UpdateArticleFormRequest $request, Article $article): RedirectResponse
    {
        $formData = $request->validated();

        $article->fill($formData)->save();

        if ($request->has('cover')) {
            $article->mainImage->delete();
            $article->uploadImages($formData['cover']);
        }

        if ($request->has('hashtags')) {
            $hashtagIds = Hashtag::getOrCreateIds($formData['hashtags']);
            $article->hashtags()->sync($hashtagIds);
        }

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function delete(Request $request, Article $article): RedirectResponse
    {
        return \response()->redirectToAction([self::class, 'index']);
    }
}
