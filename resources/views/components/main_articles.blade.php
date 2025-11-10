@php
    use App\Models\Article;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;

    /** @var Collection|iterable<Article> $articles */
@endphp

<div class="main_articles_wrapper">
    <h2 class="articles_wrapper_header">Все о морских свинках →</h2>

    <ul class="article-list">
    @foreach($articles as $article)
        <li class="article-list-item article-card">
            <a href="{{ route('blog.one', compact('article')) }}">
                <img class="article-card-image" width="350" height="250" alt="Обложка статьи"
                     src="{{ $article->mainImage?->getFullUrl() ?? $article::getDefaultImage() }}">
            </a>
            <div class="article-card-bio">
                <a href="{{ route('blog.one', compact('article')) }}">
                    <h2 class="article-card-title">{{ $article->title }}</h2>
                </a>

                <p class="article-card-description">{{ $article->description }}</p>

                <a class="button article-card-button" href="{{ route('blog.one', compact('article')) }}">
                    Читать
                </a>
            </div>
        </li>
        @endforeach
    </ul>

    <section id="articles_splide" class="splide articles_splide_wrapper" aria-label="Splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach($articles as $article)
                    <li class="splide__slide">
                        <div class="article-list-item article-card">
                            <a href="{{ route('blog.one', compact('article')) }}">
                                <img class="article-card-image" width="350" height="250" alt="Обложка статьи"
                                     src="{{ $article->mainImage?->getFullUrl() ?? $article::getDefaultImage() }}">
                            </a>
                            <div class="article-card-bio">
                                <a href="{{ route('blog.one', compact('article')) }}">
                                    <h2 class="article-card-title">{{ $article->title }}</h2>
                                </a>

                                <p class="article-card-description">{{ $article->description }}</p>

                                <a class="button article-card-button" href="{{ route('blog.one', compact('article')) }}">
                                    Читать
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <div class="button show_more_button">
        <a href="{{ route('articles.index') }}">
            Смотреть все
        </a>
    </div>
</div>

<style>
    .main_articles_wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 1rem 1rem;
        row-gap: 5rem;
        background-image: url("/images/texture-light.png");
        border-top: 10px solid var(--main_pink);
    }

    .articles_splide_wrapper {
        display: none;

        @media (max-width: 768px) {
            display: block;
        }
    }

    .articles_wrapper_header {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        text-align: center;

        @media (max-width: 1300px) {
            font-size: 25px;
        }
    }

    .show_more_button {
        margin: 40px auto 20px;
    }

    .button {
        position: relative;
        width: fit-content;
        padding: 0.25rem 1.5rem;
        text-transform: uppercase;
        font-family: inherit;
        font-size: 2rem;
        background-color: #C3E9EA;
        border: solid 2px #000000;
        border-radius: 0.75rem;
        cursor: pointer;
        z-index: 4;

        @media (max-width: 450px) {
            font-size: 20px;
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
