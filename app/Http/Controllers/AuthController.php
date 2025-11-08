<?php

declare(strict_types = 1);
namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        if (Auth::user()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * @param AuthRequest $request
     * @return RedirectResponse
     */
    public function login(AuthRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (Auth::attempt(['name' => $data['login'], 'password' => $data['password']])) {
            $request->session()->regenerate();

            return to_route('home');
        }

        return back()->withInput(['login' => $request->get('login')])->withErrors(['password' => 'Неверное имя пользователя или пароль']);
    }
}
