<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;
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
