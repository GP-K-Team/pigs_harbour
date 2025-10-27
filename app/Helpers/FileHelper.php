<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Article;
use App\Models\Pig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function getDefaultImage(Model $model): string
    {
        $filename = match (get_class($model)) {
            Pig::class => Pig::DEFAULT_IMAGE,
            Article::class => Article::DEFAULT_IMAGE,
        };

        return Storage::url("images/$filename");
    }
}
