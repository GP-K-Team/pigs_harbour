<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Helpers\LinguisticsHelper;
use App\Helpers\UrlHelper;
use App\Http\Requests\CreatePigFormRequest;
use App\Http\Requests\UpdatePigFormRequest;
use App\Models\City;
use App\Models\Pig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PigsController extends Controller
{
    public function index(UrlHelper $urlHelper): View
    {
        $cities = City::query()->pluck('name');
        $filters = $urlHelper->collectFilters();

        if (array_key_exists('city', $filters)) {
            $filters['city'] = $cities->firstWhere(fn (string $city) => LinguisticsHelper::transliterate($city) === $filters['city']);
        }

        $pigs = Pig::activeDesc()->with(['companion', 'companionOf', 'city', 'images'])->filter($filters)->cursorPaginate(6);
        $isAdmin = Auth::check() ?? false;

        return \view('pigs.index', compact('filters', 'cities', 'pigs', 'isAdmin'));
    }

    public function filteredList(string $city, string $sex, string $age, string $fur): View
    {

    }

    public function showOne(Pig $pig): View
    {
        // todo
    }

    public function showCreate(Request $request): View
    {
        $cities = City::query()->pluck('name', 'id');
        $companionCandidates = Pig::activeDesc()->get();

        return \view('pigs.form', compact('cities', 'companionCandidates'));
    }

    public function showUpdate(Request $request, Pig $pig): View
    {
        $cities = City::query()->pluck('name', 'id');
        $companionCandidates = Pig::activeDesc()->whereNot('id', '=', $pig->id)->get();

        return \view('pigs.form', compact('pig', 'companionCandidates', 'cities'));
    }

    public function create(CreatePigFormRequest $request): RedirectResponse
    {
        $formData = $request->validated();

        $newPig = new Pig();
        $newPig->fill($formData);
        $newPig->slug_name = Str::afterLast($newPig->slug_name, '/');
        $newPig->city_id = $formData['city'];
        $newPig->companion_pig_id = $formData['companion'] ?? null;
        $newPig->save();

        if ($request->files) {
            FileHelper::handleImages($request->file('files', []), $newPig);
        }

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function update(UpdatePigFormRequest $request, Pig $pig): RedirectResponse
    {
        $formData = $request->validated();

        $pig->fill($formData);
        $pig->slug_name = Str::afterLast($pig->slug_name, '/');
        $pig->city_id = $formData['city'];
        $pig->companion_pig_id = $formData['companion'] ?? null;
        $pig->save();

        if ($request->files) {
            FileHelper::handleImages($request->file('files', []), $pig);
        }

        if ($request->get('files')) {
            $mainFile = $request->get('files')[0];
            $mainImage = $pig->images()->wherePivot('is_main', true)->first();

            if ($mainImage) {
                $mainImage->pivot->is_main = false;
                $mainImage->pivot->save();
            }

            $newMainImage = $pig->images()->where('link', '=', Str::after($mainFile, 'storage/'))->first();
            $newMainImage->pivot->is_main = true;
            $newMainImage->save();
        }

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function delete(Request $request, Pig $pig): RedirectResponse
    {
        return \response()->redirectToAction([self::class, 'index']);
    }
}
