<?php

namespace App\Http\Controllers;

use App\Models\Pig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PigsController extends Controller
{
    public function index(Request $request): View
    {
        $pigs = Pig::query()->cursorPaginate(25);

        return \view('pigs.index', compact('pigs'));
    }

    public function showOne(Pig $pig): View
    {
        // todo
    }

    public function showCreate(Request $request): View
    {
        return \view('pigs.form');
    }

    public function showUpdate(Request $request, Pig $pig): View
    {
        return \view('pigs.form');
    }

    public function create(Request $request): RedirectResponse
    {
        return \response()->redirectToAction([$this, 'index']);
    }

    public function update(Request $request, Pig $pig): RedirectResponse
    {
        return \response()->redirectToAction([$this, 'index']);
    }

    public function delete(Request $request, Pig $pig): RedirectResponse
    {
        return \response()->redirectToAction([$this, 'index']);
    }
}
