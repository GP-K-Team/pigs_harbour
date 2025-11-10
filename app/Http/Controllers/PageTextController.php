<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageTextFormRequest;
use App\Models\PageText;
use Illuminate\Http\JsonResponse;

class PageTextController extends Controller
{

    /**
     * @param PageTextFormRequest $request
     * @param PageText $pageText
     * @return JsonResponse
     */
    public function update(PageTextFormRequest $request, PageText $pageText): JsonResponse
    {
        $pageText->update($request->validated());

        return response()->json();
    }
}
