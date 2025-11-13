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
use Illuminate\Support\Str;
use Illuminate\View\View;

class PigsController extends Controller
{
    public function index(UrlHelper $urlHelper): RedirectResponse|View
    {
        $cities = City::query()->pluck('name');
        $filters = $urlHelper->collectFilters();

        if (count($filters) === 1) {
            $slug = head($filters);

            if ($pigFoundBySlug = Pig::query()->firstWhere('slug_name', $slug)) {
                return $this->showOne($pigFoundBySlug);
            }
        }

        if (array_key_exists('city', $filters)) {
            $filters['city'] = $cities->firstWhere(fn (string $city) => LinguisticsHelper::transliterate($city) === $filters['city']);
        }

        $pigs = Pig::activeDesc()->with(['companion', 'companionOf', 'city', 'images'])->filter($filters)->paginate((Pig::PAGINATE_ITEMS_COUNT));
        $state = 'catalog';

        return \view('pigs.index', compact('filters', 'cities', 'pigs', 'state'));
    }

    public function archive(UrlHelper $urlHelper): View
    {
        $cities = City::query()->pluck('name');
        $filters = $urlHelper->collectFilters();

        if (array_key_exists('city', $filters)) {
            $filters['city'] = $cities->firstWhere(fn (string $city) => LinguisticsHelper::transliterate($city) === $filters['city']);
        }

        $pigs = Pig::notActiveAsc()->with(['companion', 'companionOf', 'city', 'images'])->filter($filters)->paginate((Pig::PAGINATE_ITEMS_COUNT));
        $state = 'archive';

        return \view('pigs.index', compact('filters', 'cities', 'pigs', 'state'));
    }

    public function showOne(Pig $pig): View
    {
        $additionalPigs = Pig::activeDesc()->where('id', '!=', $pig->id)->take(3)->get();

        return \view('pigs.one', compact('pig', 'additionalPigs'));
    }

    public function showCreate(): View
    {
        $cities = City::query()->pluck('name', 'id');
        $companionCandidates = Pig::activeDesc()->get();

        return \view('pigs.form', compact('cities', 'companionCandidates'));
    }

    public function showUpdate(Pig $pig): View
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

            $mainImage = $pig->images()->wherePivot('is_main', '=', 1)->first();
            $mainFile = $request->get('files')[0] ?? null;

            if ($mainFile) {
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
        }

        return \response()->redirectToAction([self::class, 'showOne'], compact('pig'));
    }

    public function delete(): RedirectResponse
    {
        return \response()->redirectToAction([self::class, 'index']);
    }

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
