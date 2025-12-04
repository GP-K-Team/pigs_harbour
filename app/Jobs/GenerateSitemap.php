<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Article;
use App\Models\Pig;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Sitemap::create()
            ->add(Url::create('/')->setPriority(1))
            ->add(Url::create(route('catalog.index'))->setPriority(0.5))
            ->add(Url::create(route('blog.index'))->setPriority(0.5))
            ->add(Pig::activeAsc()->get())
            ->add(Article::published()->get())
            ->writeToFile(
                public_path('sitemap.xml')
            );
    }
}
