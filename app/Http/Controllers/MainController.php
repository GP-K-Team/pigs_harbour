<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Pig;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class MainController
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('index', [
            'title' => 'Приют для морских свинок',
            'isAdmin' => Auth::id(),
            'cities' => City::all(),
            'pigs' => Pig::query()->orderBy('created_at')->limit(6)->with(['city', 'companion', 'companionOf'])->get(),
        ]);
    }
}
