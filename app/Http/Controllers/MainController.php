<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
            'isAdmin' => Auth::user()?->id,
        ]);
    }
}
