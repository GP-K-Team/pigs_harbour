<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Pig;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as DefaultController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends DefaultController
{
    public function get(): Application|Response|ResponseFactory
    {
        $xml = Sitemap::create()
            ->add(Url::create('/')->setPriority(1))
            ->add(Url::create(route('catalog.index'))->setPriority(0.5))
            ->add(Url::create(route('blog.index'))->setPriority(0.5))
            ->add(Pig::activeAsc()->get())
            ->add(Article::published()->get())
            ->render();

        return response($xml, headers: ['Content-Type' => 'application/xml']);
    }
}
