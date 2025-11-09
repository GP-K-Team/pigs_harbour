<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;
use App\Models\Hashtag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(Request $request): View
    {
        $showMore = $request->get('show_more', 1);
        $articles = Article::query()->with('images')->paginate(Article::PAGINATE_ITEMS_COUNT * $showMore);
        $hashtags = Hashtag::query()->get();
        $isAdmin = Auth::check() ?? false;
        $activeHashtags = [];

        if ($request->get('hashtags')) {
            $activeHashtags = explode('&', $request->get('hashtags'));
        }

        return \view('articles.index', compact('articles', 'isAdmin', 'hashtags', 'showMore', 'activeHashtags'));
    }

    public function showOne(Article $article): View
    {
        // todo
    }

    public function showCreate(Request $request): View
    {
        return \view('articles.form');
    }

    public function showUpdate(Request $request, Article $article): View
    {
        return \view('articles.form', compact('article'));
    }

    public function create(ArticleFormRequest $request): RedirectResponse
    {
        $formData = $request->validated();

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        return \response()->redirectToAction([self::class, 'index']);
    }

    public function delete(Request $request, Article $article): RedirectResponse
    {
        return \response()->redirectToAction([self::class, 'index']);
    }
}
