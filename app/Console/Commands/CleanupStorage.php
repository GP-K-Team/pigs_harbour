<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class CleanupStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up storage by deleting any unused media files';

    private int $count = 0;

    private int $totalSize = 0;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::channel('cleanup')->info('/ ------------- script start ------------- /');

        $this->cleanupDanglingDbImages();
        $this->cleanupArticleInlineImages();

        Log::channel('cleanup')->info("Files deleted: $this->count");
        Log::channel('cleanup')->info('Freed space: ' . Number::fileSize($this->totalSize, 2));

        Log::channel('cleanup')->info('/ ------------- script end ------------- /');
    }

    /**
     * Delete images stored in database having no relations with any other model.
     */
    private function cleanupDanglingDbImages(): void
    {
        $danglingImages = Image::query()
            ->whereDoesntHave('articles')
            ->whereDoesntHave('pigs')
            ->pluck('link', 'images.id');

        if ($danglingImages->count()) {
            foreach ($danglingImages as $filepath) {
                $filepath = Storage::path('public/' . Str::afterLast($filepath, '/'));

                if (File::exists($filepath)) {
                    $this->deleteFile($filepath);
                }
            }

            Image::query()->whereIn('id', $danglingImages->keys())->delete();
        }
    }

    /**
     * Iterate files, delete those not used as a cover or in any article content.
     */
    private function cleanupArticleInlineImages(): void
    {
        $articles = Article::query()->pluck('text');
        $path = Storage::path('/public/articles');
        $articleCoverImages = Image::query()->whereHas('articles')->pluck('link')
            ->transform(fn (string $path) => Str::afterLast($path, '/'));

        foreach (File::allFiles($path) as $file) {
            $isTrash = true;

            if ($articleCoverImages->contains($file->getFilename())) {
                continue;
            }

            foreach ($articles as $articleText) {
                if (Str::contains($articleText, $file->getFilename())) {
                    $isTrash = false;

                    break;
                }
            }

            if ($isTrash) {
                $this->totalSize += $file->getSize();
                $this->deleteFile($file->getRealPath());
            }
        }
    }

    /**
     * @param string $filepath Full path to the file being deleted
     */
    private function deleteFile(string $filepath): void
    {
        $this->count++;
        $this->totalSize += File::size($filepath);

        File::delete($filepath);

        Log::channel('cleanup')->info("File at `$filepath` has been deleted");
    }
}
