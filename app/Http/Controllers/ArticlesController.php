<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\PageTextHelper;
use App\Http\Requests\Article\CreateArticleFormRequest;
use App\Http\Requests\Article\UpdateArticleFormRequest;
use App\Models\Article;
use App\Models\Hashtag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(Request $request): View
    {
        $activeHashtags = [];

        if ($request->get('hashtags')) {
            $activeHashtags = explode(',', $request->get('hashtags'));
        }

        $showMore = $request->get('show_more', 1);
        $articlesBuilder = Article::query()->with('images');

        if (count($activeHashtags)) {
            $articlesBuilder->whereHas('hashtags', function (Builder $query) use ($activeHashtags) {
               $query->whereIn('slug', $activeHashtags);
            });
        }

        $articles = $articlesBuilder->orderByDesc('created_at')->paginate(Article::PAGINATE_ITEMS_COUNT * $showMore);
        $hashtags = Hashtag::query()->get();
        $isAdmin = Auth::check() ?? false;
        $pageTexts = PageTextHelper::getPageText();

        return \view('articles.index', compact('articles', 'isAdmin', 'hashtags', 'showMore', 'activeHashtags', 'pageTexts'));
    }

    public function showOne(Article $article): View
    {
        // todo
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

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function delete(Request $request, Article $article): RedirectResponse
    {
        return \response()->redirectToAction([self::class, 'index']);
    }
}
