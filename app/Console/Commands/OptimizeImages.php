<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Spatie\Image\Image;

class OptimizeImages extends Command
{
    private const MAX_IMAGE_WIDTH = 1600;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reduce disk space by optimizing image files in the storage';

    private int $freedSpace = 0;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $storageRoot = Storage::path('public');

        foreach (File::directories($storageRoot) as $directory) {
            $this->optimize($directory);
        }

        Log::channel('images')->info('Total disk space freed: ' . Number::fileSize($this->freedSpace, 2));
    }

    /**
     * Optimize all images found in the given directory.
     */
    private function optimize(string $directory): void
    {
        foreach (File::allFiles($directory) as $file) {
            if (Str::startsWith(File::mimeType($file), 'image/')) {
                $originalSize = $file->getSize();
                $image = Image::load($file);

                if (($originalWidth = $image->getWidth()) > self::MAX_IMAGE_WIDTH) {
                    Log::channel('images')->info("Image width $originalWidth px too big, resizing");

                    $image = $image->width(self::MAX_IMAGE_WIDTH);
                }

                $image->optimize()->save();
                $newSize = File::size($file->getRealPath());

                $this->freedSpace += ($originalSize - $newSize);

                Log::channel('images')->info("File `{$file->getFilename()}` size reduced from "
                    . Number::fileSize($originalSize, 2) . ' to ' . Number::fileSize($newSize, 2));
            }
        }

        foreach (File::directories($directory) as $subDirectory) {
            $this->optimize($subDirectory);
        }
    }
}
