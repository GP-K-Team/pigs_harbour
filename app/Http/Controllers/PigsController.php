<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\LinguisticsHelper;
use App\Helpers\UrlHelper;
use App\Http\Requests\Pig\CreatePigFormRequest;
use App\Http\Requests\Pig\UpdatePigFormRequest;
use App\Http\Requests\Pig\UpdatePigStatusRequest;
use App\Models\City;
use App\Models\Pig;
use Illuminate\Http\JsonResponse;
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
        $admin = Auth::check() ?? false;
        $additionalPigs = Pig::activeDesc()->where('id', '!=', $pig->id)->take(3)->get();

        return \view('pigs.one', compact('pig', 'admin', 'additionalPigs'));
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

        $pig = new Pig();
        $pig->fill($formData)->save();

        if (!empty($formData['files'])) {
            $pig->uploadImages($request['files']);
        }

        return \response()->redirectToAction([self::class, 'showOne'], compact('pig'));
    }

    public function update(UpdatePigFormRequest $request, Pig $pig): RedirectResponse
    {
        $formData = $request->validated();

        $pig->fill($formData)->save();

        if ($request->has('files')) {
            $pig->uploadImages($request['files']);

            $mainFile = $request->get('files')[0];
            $mainImage = $pig->images()->wherePivot('is_main', '=', 1)->first();
            $newMainFileName = Str::after($mainFile, 'storage/');

            if ($mainImage) {
                if ($mainImage->link !== $newMainFileName) {
                    $pig->images()->updateExistingPivot($mainImage->id, ['is_main' => 0]);
                    $newMainImage = $pig->images()->where('link', '=', $newMainFileName)->first();
                    $pig->images()->updateExistingPivot($newMainImage->id, ['is_main' => 1]);
                }
            } else {
                $newMainImage = $pig->images()->where('link', '=', $newMainFileName)->first();
                $pig->images()->updateExistingPivot($newMainImage->id, ['is_main' => 1]);
            }
        }

        return \response()->redirectToAction([self::class, 'showOne'], compact('pig'));
    }

    public function delete(Request $request, Pig $pig): RedirectResponse
    {
        return \response()->redirectToAction([self::class, 'index']);
    }

    /**
     * @param UpdatePigStatusRequest $request
     * @param Pig $pig
     * @return JsonResponse
     */
    public function updateStatus(UpdatePigStatusRequest $request, Pig $pig): JsonResponse
    {
        $pig->is_active = $request->validated('is_active');

        if (!$pig->is_active) {
            $pig->stopped_looking_date = now();
        } else {
            $pig->stopped_looking_date = null;
        }

        $pig->save();

        return \response()->json();
    }
}
