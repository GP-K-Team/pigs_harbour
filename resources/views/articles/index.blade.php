@extends('layouts.main', ['background' => 'texture-light'])

@section('title')
    Статьи Пристани
@endsection

@section('description')
    Статьи пристани о морских свинках
@endsection

@php
    use App\Models\Article;
    use App\Helpers\FileHelper;
    use App\Models\Hashtag;
    use Illuminate\Support\Collection;

    /** @var Collection|iterable<Article> $articles */
    /** @var Collection|iterable<Hashtag> $hashtags */
    /** @var bool $isAdmin */
    /** @var array $activeHashtags */
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bread-crumbs.css') }}">
@endpush

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/hashtags.js') }}"></script>
@endpush

@section('content')
    @include('components.banner', ['showPigs' => false, 'specialHeader' => 'Полезные статьи', 'specialText' => 'все самое важное, что нужно знать о морских свинках'])

    <div class="bread-crumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li>Статьи</li>
        </ul>
    </div>

    <div class="list-container">
        <div class="list-header">
            <ul class="hashtag-list">
                <li @class(['hashtag-item-active' => !count($activeHashtags), 'hashtag-item']) data-hashtag="vse">
                    Все
                </li>
                @foreach($hashtags as $hashtag)
                    <li @class(['hashtag-item-active' => in_array($hashtag->slug, $activeHashtags), 'hashtag-item']) data-hashtag="{{ $hashtag->slug }}">
                        {{ $hashtag->tag }}
                    </li>
                @endforeach
            </ul>

{{--            <section id="hashtags_splide" class="splide hashtag_splide_wrapper" aria-label="Хэштеги">--}}
{{--                <div class="splide__track">--}}
{{--                    <ul class="splide__list">--}}
{{--                        <li class="splide__slide">--}}
{{--                            <div @class(['hashtag-item-active' => !count($achtiveHashtags), 'hashtag-item'])>--}}
{{--                                Все--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        @foreach($hashtags as $hashtag)--}}
{{--                            <li class="splide__slide">--}}
{{--                                <div @class(['hashtag-item-active' => in_array($hashtag->slug, $achtiveHashtags), 'hashtag-item'])>--}}
{{--                                    {{ $hashtag->tag }}--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </section>--}}
        </div>

        @if($articles->isEmpty())
            <h3>Нет результатов</h3>
        @else
            <ul class="list">
                @if($isAdmin)
                    <li class="list-item card add-card">
                        <a class="add-card-link" href="{{ route('articles.show.create') }}" draggable="false">
                            <p class="add-card-link-text">Добавить статью</p>
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <path
                                    d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                            </svg>
                        </a>
                    </li>
                @endif

                @foreach($articles as $article)
                    <li class="list-item card @if($isAdmin) can-edit @endif">
                        <a href="{{ route('articles.one', compact('article')) }}">
                            <img class="card-image" width="350" height="250" alt="Обложка статьи"
                                 src="{{ $article->mainImage?->getFullUrl() ?? FileHelper::getDefaultImage($article) }}">
                        </a>
                        <div class="card-bio">
                            <a href="{{ route('articles.one', compact('article')) }}">
                                <h2 class="card-title">{{ $article->title }}</h2>
                            </a>

                            @if($isAdmin)
                                <a class="edit-icon-link" href="{{ route('articles.show.update', compact('article')) }}"
                                   draggable="false">
                                    <img src="{{ asset('images/icons/edit.svg') }}" alt="" draggable="false">
                                </a>
                            @endif

                            <p class="card-description">{{ $article->description }}</p>

                            <a class="button card-button" href="{{ route('articles.one', compact('article')) }}">
                                Читать
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            @if ($articles->currentPage() !== $articles->lastPage())
                <div class="button show_more_button">
                    <a href="{{ '?show_more=' . ($showMore + 1) }}">
                        Показать ещё
                    </a>
                </div>
            @endif

            @if($articles->total() > 1 && $articles->lastPage() !== 1)
                <div class="pagination_wrapper">
                    <ul class="pagination_list">
                        <li @class(['item_active' => $articles->currentPage() === 1])>
                            <a href="?page=1">
                                1
                            </a>
                        </li>

                        @if($articles->lastPage() > 2)

                            @if($articles->currentPage() !== 1 && $articles->currentPage() - 1 !== 1 && $articles->currentPage() !== $articles->lastPage())
                                <li>
                                    <a href="{{ $articles->previousPageUrl() }}">
                                        {{ $articles->currentPage() - 1 }}
                                    </a>
                                </li>
                            @endif

                            @if($articles->currentPage() === 1)
                                <li>
                                    <a href="{{ $articles->nextPageUrl() }}">
                                        {{ $articles->currentPage() + 1 }}
                                    </a>
                                </li>
                            @elseif($articles->currentPage() === $articles->lastPage())
                                <li>
                                    <a href="{{ $articles->previousPageUrl() }}">
                                        {{ $articles->lastPage() - 1 }}
                                    </a>
                                </li>
                            @else
                                <li @class(['item_active'])>
                                    <a>
                                        {{ $articles->currentPage()}}
                                    </a>
                                </li>
                            @endif

                            @if($articles->currentPage() !== 1 && $articles->currentPage() + 1 !== $articles->lastPage() && $articles->currentPage() !== $articles->lastPage())
                                <li>
                                    <a href="{{ $articles->nextPageUrl() }}">
                                        {{ $articles->currentPage() + 1 }}
                                    </a>
                                </li>
                            @endif
                        @endif

                        <li @class(['item_active' => $articles->currentPage() === $articles->lastPage()])>
                            <a href="{{ "?page=" . $articles->lastPage()  }}">
                                {{ $articles->lastPage() }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        @endif
    </div>
    <div class="footer_block">
        <div class="footer_text">
            <p>
                На нашей Пристани можно найти много полезных статей о морских свинках.
            </p>
        </div>
    </div>

    <style>
        h3 {
            margin: 0;
            font-size: 3rem;
            z-index: 1;
        }

        /** List **/
        .list-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 1rem 40px 1rem;
            row-gap: 5rem;
        }

        .list {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            width: 90vw;
            max-width: 1080px;
            align-items: center;
            justify-content: center;
            gap: 3rem;
        }

        .list > li:empty {
            display: none;
        }

        .list-item.card {
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

        .card:hover {
            opacity: 0.9;
            scale: 1.01;
            transition: 250ms;
        }

        @media (max-width: 768px) {
            .list-item.card {
                width: 90%;
                max-width: 300px;
                height: 340px;
                flex-direction: column;
                border-radius: 0.75rem;
            }
        }

        .list-item.card > a {
            display: flex;
            flex-direction: row;
            color: var(--main_font) !important;
        }

        .card .card-description {
            margin: 0;
            padding: 0;
            font-size: 1.25rem;
        }

        .card-image {
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
        }

        @media (max-width: 768px) {
            .card-image {
                height: 200px;
                border-radius: 0.75rem 0.75rem 0 0;
            }
        }

        .card-image.card-image_alt-shown {
            width: fit-content;
            height: fit-content;
            padding: 1rem 0.5rem 0;
            display: inline-flex;
            align-items: center;
            color: var(--dark_blue_font);
            text-align: center;
        }

        @media (min-width: 768px) {
            .list-item.card:nth-child(2n) {
                flex-direction: row-reverse;
            }

            .list-item.card:nth-child(2n) .card-image {
                height: 100%;
                object-fit: cover;
                border-radius: 0 1.5rem 1.5rem 0;
            }
        }

        .card-bio {
            padding: 1.25rem;
            position: relative;
            display: flex;
            flex-direction: column;
            row-gap: 0.7rem;
            flex-grow: 1;
        }

        .card-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            line-height: 1;
        }

        .card-description {
            height: 100%;
            font-size: 1.25rem;
        }

        .card-button {
            align-self: flex-end;
            font-size: 1.5rem;
        }

        @media (max-width: 1200px) {
            .card-bio .card-title {
                font-size: 1.25rem;
            }

            .card-bio > .card-description {
                font-size: 1rem;
            }

            .card-bio > .card-button {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .card-bio {
                padding: 1rem;
                justify-content: space-evenly;
                align-items: center;
                row-gap: 1.25rem;
            }

            .card-bio .card-title {
                font-size: 1rem;
                text-align: center;
            }

            .card-bio > .card-description {
                display: none;
            }

            .card-bio > .card-button {
                align-self: unset;
                font-size: 1rem;
            }
        }

        .card.can-edit {
            position: relative;
        }

        .edit-icon-link {
            width: 1.75rem;
            height: 1.75rem;
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: var(--main_green);
            border-radius: 0.5rem;
            user-select: none;

            @media (max-width: 768px) {
                top: unset;
                bottom: 15px;
                right: 0.5rem;
            }
        }

        .edit-icon-link img {
            width: 100%;
            height: 100%;
        }

        .edit-icon-link:hover {
            background-color: var(--pale_yellow);
        }

        .card.add-card {
            width: fit-content;
            margin-left: 0;
            margin-right: auto;
            background-color: var(--white_trp);
        }

        .card.add-card:hover {
            background-color: #FFFFFF;
        }

        .card.add-card:nth-child(even) {
            margin-left: auto;
            margin-right: 0;
        }

        .card.add-card {
            margin-left: auto;
            margin-right: unset;
            align-self: flex-end;
        }

        @media (max-width: 1200px) {
            .card.add-card {
                height: 250px;
            }
        }

        @media (max-width: 768px) {
            .card.add-card {
                height: max-content;
                margin-inline: auto;
            }

            .add-card-link-text {
                display: none;
            }
        }

        .add-card-link {
            padding: 0.75rem;
            gap: 1rem;
            place-items: center;
            place-content: center;
        }

        .card.add-card:nth-child(even) .add-card-link {
            flex-direction: row-reverse;
        }

        .add-card-link svg {
            width: 75%;
            height: 75%;
            min-height: 145px;
            object-fit: contain;
            color: #0C6291;
            opacity: 0.4;
            transition: 0.25s;
        }

        .add-card-link:hover svg {
            color: var(--main_green);
            opacity: 0.6;
        }

        .add-card-link .add-card-link-text {
            visibility: hidden;
            font-family: inherit;
            font-size: 3rem;
            font-weight: 700;
            text-align: center;
        }

        .add-card-link:hover .add-card-link-text {
            visibility: visible;
        }

        /** Pagination **/
        .pagination {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .pagination-next-button {
            font-size: 1.75rem;
        }


        .footer_block {
            padding: 40px;
            border-top: 10px solid var(--main_pink);
            background-image: url("/images/bright_dark.png");
        }

        .footer_text {
            display: flex;
            flex-direction: column;
            row-gap: 25px;
            font-size: 25px;
            text-align: justify;

            @media (max-width: 768px) {
                font-size: 15px;
            }
        }

        .pagination_list {
            display: flex;
            column-gap: 20px;
        }

        .pagination_list li {
            padding: 10px 20px;
            font-size: 25px;
            cursor: pointer;
            border-radius: 50%;

            @media (max-width: 1000px) {
                padding: 10px 15px;
                font-size: 15px;
            }
        }

        .pagination_list li:hover a {
            color: var(--main_blue);
        }

        .item_active {
            background-color: var(--light_blue);
        }

        .pagination_list .item_active:hover a {
            color: var(--main_font);
        }

        .list-header {
            max-width: 80%;
        }

        .hashtag-list {
            display: flex;
            column-gap: 20px;
            row-gap: 25px;
            flex-wrap: wrap;

            @media (max-width: 768px) {
                display: none;
            }
        }

        .hashtag-item {
            width: fit-content;
            padding: 10px 30px;
            border-radius: 10px;
            font-size: 25px;
            cursor: pointer;

            @media (max-width: 1000px) {
                font-size: 15px;
            }
        }

        .hashtag-item:hover {
            opacity: 0.7;
        }

        .hashtag-item-active {
            color: white;
            background-color: var(--main_pink);
            font-weight: bold;
        }

        .hashtag_splide_wrapper {
            display: none;

            @media (max-width: 768px) {
                display: block;
            }
        }

        /*.splide_slide {*/
        /*    display: flex;*/
        /*    justify-content: center;*/
        /*}*/
    </style>
@endsection
