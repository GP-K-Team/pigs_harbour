<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Pig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PigsController extends Controller
{
    public function index(Request $request): View
    {
        $pigs = Pig::query()->with(['companion', 'companionOf', 'city', 'images'])->cursorPaginate(6);

        return \view('pigs.index', compact('pigs'));
    }

    public function showOne(Pig $pig): View
    {
        // todo
    }

    public function showCreate(Request $request): View
    {
        $cities = City::query()->pluck('name', 'id');
        $companionCandidates = Pig::query()->where('is_active', true)->orderByDesc('created_at')->get();

        return \view('pigs.form', compact('cities', 'companionCandidates'));
    }

    public function showUpdate(Request $request, Pig $pig): View
    {
        $cities = City::query()->pluck('name', 'id');

        return \view('pigs.form', compact('pig', 'cities'));
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
