<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\LinguisticsHelper;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AjaxController
{
    public function index(Request $request): Response
    {
        try {
            ['method' => $method, 'data' => $payload] = $request->all();

            return method_exists($this, $method) ? \response($this->$method($payload)) : throw new NotFoundHttpException(code: 404);
        } catch (\Throwable $e) {
            $logMessage = "An ajax request has resulted in an error. Request details: \n";

            foreach ($request->all() as $k => $v) {
                $logMessage .= ("\t - $k: $v\n");
            }

            $logMessage .= "Exception details: " . Str::limit($e->getMessage(), 250);
            Log::notice($logMessage, [$request->user() ?? $request->ip()]);

            throw new BadRequestException('Unprocessable data', 400);
        }
    }

    public function transliterate(string $text): string
    {
        return LinguisticsHelper::transliterate($text);
    }

    public function uploadEditorImage(Request $request): JsonResponse
    {
        $filePath = Article::storeImage($request['image']);
        $imgUrl = Article::getPublicUrl($filePath);

        return \response()->json([
            'success' => true,
            'file' => $imgUrl,
        ]);
    }
}
