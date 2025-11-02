<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index(Request $request): View
    {
        $articles = Article::query()->with('images')->cursorPaginate(6);

        return \view('articles.index', compact('articles'));
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
