@extends('layouts.main')

@section('title')
    {{ $article->meta_title ?? 'Статья' }}
@endsection

@section('description')
    {{ $article->meta_description ?? 'Статья' }}
@endsection

@php
    use App\Models\Article;
    use App\Models\Hashtag;
    use Illuminate\Support\Str;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /** @var <Article> $article */
    /** @var Collection|iterable<Article> $additionalArticles */
    /** @var Collection|iterable<Hashtag> $hashtags */
    /** @var bool $admin */
@endphp

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/articleSplide.js') }}"></script>
@endpush

@section('content')
    @include('components.banner', ['showPigs' => false, 'specialHeader' => $article->title])


    @if($additionalArticles->count())
        <div class="additional_articles_wrapper">
            <h2 class="additional_articles_header">Еще по теме →</h2>

            <ul class="article-list">
                @foreach($additionalArticles as $additionalArticle)
                    <li class="article-list-item article-card">
                        <a href="{{ route('blog.one', compact('additionalArticle')) }}">
                            <img class="article-card-image" width="350" height="250" alt="Обложка статьи"
                                 src="{{ $additionalArticle->mainImage?->getFullUrl() ?? $additionalArticle::getDefaultImage($additionalArticle) }}">
                        </a>
                        <div class="article-card-bio">
                            <a href="{{ route('blog.one', compact('additionalArticle')) }}">
                                <h2 class="article-card-title">{{ $additionalArticle->title }}</h2>
                            </a>

                            <p class="article-card-description">{{ $additionalArticle->description }}</p>

                            <a class="button article-card-button"
                               href="{{ route('blog.one', compact('additionalArticle')) }}">
                                Читать
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            <section id="articles_splide" class="splide articles_splide_wrapper" aria-label="Splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($additionalArticles as $additionalArticle)
                            <li class="splide__slide">
                                <div class="article-list-item article-card">
                                    <a href="{{ route('blog.one', compact('additionalArticle')) }}">
                                        <img class="article-card-image" width="350" height="250" alt="Обложка статьи"
                                             src="{{ $additionalArticle->mainImage?->getFullUrl() ?? $additionalArticle::getDefaultImage($additionalArticle) }}">
                                    </a>
                                    <div class="article-card-bio">
                                        <a href="{{ route('blog.one', compact('additionalArticle')) }}">
                                            <h2 class="article-card-title">{{ $additionalArticle->title }}</h2>
                                        </a>

                                        <p class="article-card-description">{{ $additionalArticle->description }}</p>

                                        <a class="button article-card-button"
                                           href="{{ route('blog.one', compact('additionalArticle')) }}">
                                            Читать
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <div class="hashtag-list-header">
                <ul class="hashtag-list">
                    <li class="hashtag-item">
                        Все
                    </li>
                    @foreach($hashtags as $hashtag)
                        <li class="hashtag-item">
                            {{ $hashtag->tag }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection

<style>
    .additional_articles_wrapper {
        border-top: 10px solid var(--pale_orange);
        background-image: url("/images/texture-light.png");
    }

    .additional_articles_header {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        text-align: center;

        @media (max-width: 1300px) {
            font-size: 25px;
        }
    }

    .hashtag-list-header {
        max-width: 80%;

        @media (max-width: 768px) {
            padding-bottom: 25px;
            overflow-x: scroll;
        }
    }

    .hashtag-list {
        display: flex;
        column-gap: 20px;
        row-gap: 25px;
        flex-wrap: wrap;

        @media (max-width: 768px) {
            flex-wrap: nowrap;
        }
    }

    .hashtag-item {
        display: flex;
        align-items: center;
        width: fit-content;
        padding: 10px 30px;
        border-radius: 10px;
        font-size: 25px;
        cursor: pointer;
        background-color: white;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .hashtag-item:hover {
        opacity: 0.7;
    }


    .articles_splide_wrapper {
        display: none;

        @media (max-width: 768px) {
            display: block;
        }
    }

    .article-list {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        width: 90vw;
        max-width: 1080px;
        align-items: center;
        justify-content: center;
        gap: 3rem;

        @media (max-width: 768px) {
            display: none;
        }
    }

    .article-list > li:empty {
        display: none;
    }

    .article-list-item.article-card {
        display: flex;
        flex-direction: row;
        width: 100%;
        height: 300px;
        background-color: white;
        border-radius: 1.5rem;
        box-shadow: 0 4px 4px 0 var(--shadow_drop);
        cursor: pointer;
        transition: 250ms;
    }

    .article-card:hover {
        opacity: 0.9;
        scale: 1.01;
        transition: 250ms;
    }

    @media (max-width: 768px) {
        .article-list-item.article-card {
            width: 90%;
            max-width: 300px;
            height: 340px;
            flex-direction: column;
            border-radius: 0.75rem;
        }
    }

    .article-list-item.article-card > a {
        display: flex;
        flex-direction: row;
        color: var(--main_font) !important;
    }

    .article-card .article-card-description {
        margin: 0;
        padding: 0;
        font-size: 1.25rem;
    }

    .article-card-image {
        height: 100%;
        object-fit: cover;
        border-top-left-radius: 1.5rem;
        border-bottom-left-radius: 1.5rem;
    }

    @media (max-width: 768px) {
        .article-card-image {
            height: 200px;
            border-radius: 0.75rem 0.75rem 0 0;
        }
    }

    .article-card-image.article-card-image_alt-shown {
        width: fit-content;
        height: fit-content;
        padding: 1rem 0.5rem 0;
        display: inline-flex;
        align-items: center;
        color: var(--dark_blue_font);
        text-align: center;
    }

    @media (min-width: 768px) {
        .article-list-item.article-card:nth-child(2n) {
            flex-direction: row-reverse;
        }

        .article-list-item.article-card:nth-child(2n) .article-card-image {
            height: 100%;
            object-fit: cover;
            border-radius: 0 1.5rem 1.5rem 0;
        }
    }

    .article-card-bio {
        padding: 1.25rem;
        position: relative;
        display: flex;
        flex-direction: column;
        row-gap: 0.7rem;
        flex-grow: 1;
    }

    .article-card-title {
        padding: 0;
        margin: 0;
        font-size: 1.75rem;
        line-height: 1;
    }

    .article-card-description {
        height: 100%;
        font-size: 1.25rem;
    }

    .article-card-button {
        align-self: flex-end;
        font-size: 1.5rem;
    }

    @media (max-width: 1200px) {
        .article-card-bio .article-card-title {
            font-size: 1.25rem;
        }

        .article-card-bio > .article-card-description {
            font-size: 1rem;
        }

        .article-card-bio > .article-card-button {
            font-size: 1rem;
        }
    }

    @media (max-width: 768px) {
        .article-card-bio {
            padding: 1rem;
            justify-content: space-evenly;
            align-items: center;
            row-gap: 1.25rem;
        }

        .article-card-bio .article-card-title {
            font-size: 1rem;
            text-align: center;
        }

        .article-card-bio > .article-card-description {
            display: none;
        }

        .article-card-bio > .article-card-button {
            align-self: unset;
            font-size: 1rem;
        }
    }


</style>
