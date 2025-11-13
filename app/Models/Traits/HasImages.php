<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasImages
{
    public function getMainImageAttribute(): Image|null
    {
        return $this->images()->wherePivot('is_main', true)->first();
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class)->withPivot('is_main');
    }

    public function uploadImages(UploadedFile|array $files): void
    {
        if (is_a($files, UploadedFile::class)) {
            $files = [$files];
        }

        foreach ($files as $key => $file) {

            if (!$file instanceof UploadedFile) {
               continue;
            }

            $newImage = Image::query()->create([
                'link' => static::storeImage($file),
            ]);

            $this->images()->attach($newImage, ['is_main' => $key === 0]);
        }
    }

    public static function storeImage(UploadedFile $file): string
    {
        return Storage::disk('public')->putFile(static::IMAGE_PATH, $file);
    }

    public static function getDefaultImage(): string
    {
        return Storage::url(static::IMAGE_PATH . DIRECTORY_SEPARATOR . static::DEFAULT_IMAGE);
    }

    public static function getPublicUrl(string $filename): string
    {
        return Storage::url(static::IMAGE_PATH . DIRECTORY_SEPARATOR . Str::afterLast($filename, '/'));
    }

    public function deleteImages(): void
    {
        foreach ($this->images as $image) {
            Storage::disk('public')->delete($image->link);
            $image->delete();
        }
    }
}
