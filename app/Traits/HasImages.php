<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\UploadedFileInterface;

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
                'link' => Storage::disk('public')->putFile(static::IMAGE_PATH, $file),
            ]);

            $this->images()->attach($newImage, ['is_main' => $key === 0]);
        }
    }

    public static function getDefaultImage(): string
    {
        return Storage::url(static::IMAGE_PATH . DIRECTORY_SEPARATOR . static::DEFAULT_IMAGE);
    }

    /**
     * @return void
     */
    public function deleteImages(): void
    {
        foreach ($this->images as $image) {
            Storage::disk('public')->delete($this::IMAGE_PATH . '/' . $image->link);
            $image->delete();
        }
    }
}
