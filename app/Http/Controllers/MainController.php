<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\City;
use App\Models\Pig;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index(): View
    {
        return \view('index', [
            'title' => 'Приют для морских свинок',
            'cities' => City::all(),
            'pigs' => Pig::query()->orderBy('created_at')->limit(6)->with(['city', 'companion', 'companionOf'])->get(),
            'articles' => Article::query()->inRandomOrder()->take(3)->get(),
        ]);
    }

    public function showError(): View
    {
        return \view('errors.404');
    }
}
