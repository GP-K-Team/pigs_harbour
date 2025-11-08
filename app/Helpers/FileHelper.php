<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Article;
use App\Models\Image;
use App\Models\Pig;
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
        $filename = match (get_class($model)) {
            Pig::class => Pig::DEFAULT_IMAGE,
            Article::class => Article::DEFAULT_IMAGE,
        };

        return Storage::url($filename);
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
            $newImage->link = Storage::disk('public')->putFile($model::DEFAULT_IMAGE_PATH, $file);
            $newImage->save();
            $model->images()->attach($newImage, ['is_main' => $key === 0]);
        }
    }
}
