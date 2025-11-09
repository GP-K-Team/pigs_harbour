<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * @param Model $model
     * @return string
     */
    public static function getDefaultImage(Model $model): string
    {
        return Storage::url($model::IMAGE_PATH . DIRECTORY_SEPARATOR . $model::DEFAULT_IMAGE);
    }

    /**
     * @param array $files
     * @param Model $model
     * @return void
     */
    public static function handleImages(array $files, Model $model): void
    {
        foreach ($files as $key => $file) {
            $newImage = new Image();
            $newImage->link = Storage::disk('public')->putFile($model::IMAGE_PATH, $file);
            $newImage->save();
            $model->images()->attach($newImage, ['is_main' => $key === 0]);
        }
    }
}
