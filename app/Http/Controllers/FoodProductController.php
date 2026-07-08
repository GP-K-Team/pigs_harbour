<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\HashtagType;
use App\Models\SearchQuery;
use App\Http\Requests\FoodProduct\CreateFoodProductFormRequest;
use App\Http\Requests\FoodProduct\UpdateFoodProductFormRequest;
use App\Models\FoodProduct;
use App\Models\Hashtag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FoodProductController extends Controller
{
    public function index(string $slug = ''): View
    {
        if ($slug) {
            if ($foodProductBySlug = FoodProduct::query()->firstWhere('slug_title', $slug)) {
                return $this->showOne($foodProductBySlug);
            }

            if (!Hashtag::ofType(HashtagType::PRODUCT)->activeOnly(HashtagType::PRODUCT)->where('slug', $slug)->exists()) {
                throw new NotFoundHttpException(code: 404);
            }
        }

        $searchText = request()->query(FoodProduct::SEARCH_QUERY_PARAM);

        if (is_null($searchText)) {
            $foodProductsBuilder = FoodProduct::query()->with(['images', 'hashtags']);
        } else {
            $foodProductsBuilder = FoodProduct::getSearchQuery($searchText);
        }

        if ($slug) {
            $foodProductsBuilder->whereHas('hashtags', function (Builder $query) use ($slug) {
               $query->where(['slug' => $slug]);
            });
        }

        if (is_null($searchText)) {
            $foodProductsBuilder->orderByDesc('created_at');
        }

        $foodProducts = $foodProductsBuilder->paginate(FoodProduct::PAGINATE_ITEMS_COUNT)->withQueryString();

        if (!is_null($searchText)) {
            SearchQuery::addRecord($searchText, FoodProduct::searchType(), !$foodProducts->total());
        }

        $hashtags = Hashtag::ofType(HashtagType::PRODUCT)->activeOnly(HashtagType::PRODUCT)->withoutWarning()->get();
        $activeHashtagSlug = $slug;

        return \view('food-products.index', compact('foodProducts', 'hashtags', 'activeHashtagSlug'));
    }

    public function showOne(FoodProduct $foodProduct): View
    {
        $hashtags = Hashtag::ofType(HashtagType::PRODUCT)->activeOnly(HashtagType::PRODUCT)->get();
        $additionalFoodProducts = FoodProduct::query()
            ->with(['images', 'hashtags'])
            ->where('id', '!=', $foodProduct->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return \view('food-products.one', compact('foodProduct', 'hashtags', 'additionalFoodProducts'));
    }

    public function showCreate(): View
    {
        $hashtags = Hashtag::ofType(HashtagType::PRODUCT)->pluck('tag', 'id');

        return \view('food-products.form', compact('hashtags'));
    }

    public function showUpdate(FoodProduct $foodProduct): View
    {
        $hashtags = Hashtag::ofType(HashtagType::PRODUCT)->pluck('tag', 'id');

        return \view('food-products.form', compact('foodProduct', 'hashtags'));
    }

    public function create(CreateFoodProductFormRequest $request): RedirectResponse
    {
        $formData = $request->validated();

        $foodProduct = new FoodProduct();
        $foodProduct->fill($formData)->save();

        if ($request->has('cover')) {
            $foodProduct->uploadImages($formData['cover']);
        }

        if ($request->has('hashtags')) {
            $hashtagIds = Hashtag::getOrCreateIds($formData['hashtags'], HashtagType::PRODUCT);
            $foodProduct->hashtags()->sync($hashtagIds);
        }

        return \response()->redirectToAction([self::class, 'index']);
    }

    public function update(UpdateFoodProductFormRequest $request, FoodProduct $foodProduct): RedirectResponse
    {
        $formData = $request->validated();

        $foodProduct->fill($formData)->save();

        if ($request->has('cover') && !is_string($formData['cover'])) {
            if ($foodProduct->mainImage) {
                $foodProduct->mainImage->delete();
            }

            $foodProduct->uploadImages($formData['cover']);
        }

        if ($request->has('hashtags')) {
            $hashtagIds = Hashtag::getOrCreateIds($formData['hashtags'], HashtagType::PRODUCT);
            $foodProduct->hashtags()->sync($hashtagIds);
        }

        return \response()->redirectToAction([self::class, 'showOne'], compact('foodProduct'));
    }

    public function delete(FoodProduct $foodProduct): RedirectResponse
    {
        $foodProduct->deleteImages();
        $foodProduct->delete();

        return \response()->redirectToAction([self::class, 'index']);
    }
}
