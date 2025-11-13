<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

abstract class Controller extends \Illuminate\Routing\Controller
{
    public function callAction($method, $parameters)
    {
        View::share('isAdmin', Auth::check() ?? false);

        return parent::callAction($method, $parameters);
    }
}
