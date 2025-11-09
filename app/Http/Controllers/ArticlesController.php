<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Article\CreateArticleFormRequest;
use App\Http\Requests\Article\UpdateArticleFormRequest;
use App\Models\Article;
use App\Models\Hashtag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()->with('images')->cursorPaginate(6);
        $isAdmin = Auth::check() ?? false;

        return \view('articles.index', compact('articles', 'isAdmin'));
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
