@extends('layouts.main', ['background' => 'texture-light'])

@section('title')
    Статьи Пристани
@endsection

@section('description')
    Статьи пристани о морских свинках
@endsection

@php
    use App\Models\Article;
    use Illuminate\Support\Collection;
    use App\Models\Hashtag;
    use App\Models\PageText;

    /** @var Collection|iterable<Article> $articles */
    /** @var Collection|iterable<Hashtag> $hashtags */
    /** @var Collection|iterable<PageText> $pageTexts */
    /** @var bool $isAdmin */
    /** @var string $activeHashtagSlug */
    /** @var string $state */
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bread-crumbs.css') }}">
@endpush

@push('js')
    @vite('resources/js/blog.js')
    @vite('resources/js/page-text.js')
    @vite('resources/js/delete-handler.js')
    @vite('resources/js/main-animation.js')
@endpush

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    @include('components.banner', ['showPigs' => false, 'specialHeader' => 'Полезные статьи', 'specialText' => 'все самое важное, что нужно знать о морских свинках'])

    <div class="bread-crumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li>Статьи</li>
        </ul>

        @if($isAdmin)
            <div class="admin-links">
                @if($state === 'published')
                    <a href="{{ route('blog.unpublished') }}">Неопубликованные</a>
                @else
                    <a href="{{ route('blog.index') }}">Опубликованные</a>
                @endif
            </div>
        @endif
    </div>

    <div class="list-container">
        @if($state === 'published')
            <div class="hashtag-list-header">
                <ul class="hashtag-list">
                    <a href="{{ route('blog.index') }}">
                        <li @class(['hashtag-item-active' => !$activeHashtagSlug, 'hashtag-item']) data-hashtag="vse">
                            Все
                        </li>
                    </a>
                    @foreach($hashtags as $hashtag)
                        <a href="{{ route('blog.index', $hashtag->slug) }}">
                            <li @class(['hashtag-item-active' => $hashtag->slug === $activeHashtagSlug, 'hashtag-item']) data-hashtag="{{ $hashtag->slug }}">
                                {{ $hashtag->tag }}
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($articles->isEmpty())
            <h3>Нет результатов</h3>

            @if($isAdmin)
                <ul class="list">
                    <li class="list-item card add-card">
                        <a class="add-card-link" href="{{ route('blog.show.create') }}" draggable="false">
                            <p class="add-card-link-text">Добавить статью</p>
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <path d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            @endif
        @else
            <ul class="list">
                @if($isAdmin)
                    <li class="list-item card add-card">
                        <a class="add-card-link" href="{{ route('blog.show.create') }}" draggable="false">
                            <p class="add-card-link-text">Добавить статью</p>
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <path d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                            </svg>
                        </a>
                    </li>
                @endif

                @foreach($articles as $article)
                    <li class="list-item card animated-block @if($isAdmin) can-edit @endif" data-url="{{ route('blog.one', compact('article')) }}">
                        <a href="{{ route('blog.one', compact('article')) }}">
                            <img class="card-image" width="350" height="250" alt="Обложка статьи"
                                 src="{{ $article->mainImage?->getFullUrl() ?? $article->getDefaultImage() }}">
                        </a>
                        <div class="card-bio">
                            <a href="{{ route('blog.one', compact('article')) }}">
                                <h2 class="card-title">{{ $article->title }}</h2>
                            </a>

                            @if($isAdmin)
                                <div class="admin-buttons-wrapper">
                                    <a class="edit-icon-link" href="{{ route('blog.show.update', compact('article')) }}" draggable="false">
                                        <img src="{{ asset('images/icons/edit.svg') }}" alt="" draggable="false">
                                    </a>

                                    <div class="delete-form-wrapper">
                                        @include('components.buttons.article-delete-button', ['articleToDelete' => $article])
                                    </div>
                                </div>
                            @endif

                            <p class="card-description">{{ $article->description }}</p>

                            <a class="button card-button" href="{{ route('blog.one', compact('article')) }}">
                                Читать
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            @if($articles->total() > 1 && $articles->lastPage() !== 1)
                <div class="pagination-wrapper">
                    <ul class="pagination-list">
                        <a href="?page=1">
                            <li @class(['item-active' => $articles->currentPage() === 1])>
                                1
                            </li>
                        </a>

                        @if($articles->lastPage() > 2)

                            @if($articles->currentPage() !== 1 &&
                                               $articles->currentPage() - 1 != 1 &&
                                                    $articles->currentPage() - 2 != 1)
                                <li>
                                    ...
                                </li>
                            @endif

                            @if($articles->currentPage() !== 1 && $articles->currentPage() - 1 !== 1 && $articles->currentPage() !== $articles->lastPage())
                                <a href="{{ $articles->previousPageUrl() }}">
                                    <li>
                                        {{ $articles->currentPage() - 1 }}
                                    </li>
                                </a>
                            @endif

                            @if($articles->currentPage() === 1)
                                <a href="{{ $articles->nextPageUrl() }}">
                                    <li>
                                        {{ $articles->currentPage() + 1 }}
                                    </li>
                                </a>
                            @elseif($articles->currentPage() === $articles->lastPage())
                                <a href="{{ $articles->previousPageUrl() }}">
                                    <li>
                                        {{ $articles->lastPage() - 1 }}
                                    </li>
                                </a>
                            @else
                                <a>
                                    <li @class(['item-active'])>
                                        {{ $articles->currentPage()}}
                                    </li>
                                </a>
                            @endif

                            @if($articles->currentPage() !== 1 && $articles->currentPage() + 1 !== $articles->lastPage() && $articles->currentPage() !== $articles->lastPage())
                                <a href="{{ $articles->nextPageUrl() }}">
                                    <li>
                                        {{ $articles->currentPage() + 1 }}
                                    </li>
                                </a>
                            @endif

                            @if($articles->currentPage() + 1 != $articles->lastPage() &&
                                                $articles->currentPage() + 2 != $articles->lastPage() &&
                                                                        $articles->currentPage() !== $articles->lastPage())
                                <li>
                                    ...
                                </li>
                            @endif
                        @endif

                        <a href="{{ "?page=" . $articles->lastPage()  }}">
                            <li @class(['item-active' => $articles->currentPage() === $articles->lastPage()])>
                                {{ $articles->lastPage() }}
                            </li>
                        </a>
                    </ul>
                </div>
            @endif
        @endif
    </div>

    @php
        $footerContent = $pageTexts->firstWhere('text_key', 'footer-text');
    @endphp

    @if($footerContent)
        <div class="footer-block">
            <div class="footer-text">
                <p class="footer-text" @if($isAdmin) contenteditable
                   @endif data-page-text-id="{{ $footerContent->id }}">
                    {{ $footerContent->content }}
                </p>
            </div>
        </div>
    @endif

    @include('components.modal.modal-delete-confirm')

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
            box-shadow: 0 4px 4px 0 var(--shadow-drop);
            cursor: pointer;
            transition: 250ms;
            overflow-x: hidden;
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
                overflow: hidden;
            }
        }

        .list-item.card > a {
            display: flex;
            flex-direction: row;
            color: var(--main-font) !important;
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
                width: 100%;
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
            color: var(--dark-blue-font);
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

        .card-button:hover {
            background-color: var(--main-green);
            color: var(--main-font);
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

        .admin-buttons-wrapper {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            column-gap: 10px;
            align-items: center;
        }

        .edit-icon-link {
            width: 1.75rem;
            height: 1.75rem;
            background-color: #FFFFFF;
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
            background-color: var(--pale-yellow);
        }

        .card.add-card {
            width: fit-content;
            margin-left: 0;
            margin-right: auto;
            background-color: var(--white-trp);
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
            color: var(--main-green);
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


        .footer-block {
            padding: 40px;
            border-top: 10px solid var(--main-pink);
            background-image: url("/images/bright_dark.png");
        }

        .footer-text {
            display: flex;
            flex-direction: column;
            row-gap: 25px;
            font-size: 25px;
            text-align: justify;

            @media (max-width: 768px) {
                font-size: 15px;
            }
        }

        .pagination-list {
            display: flex;
            column-gap: 20px;
        }

        .pagination-list li {
            padding: 10px 20px;
            font-size: 25px;
            cursor: pointer;
            border-radius: 50%;

            @media (max-width: 1000px) {
                padding: 10px 15px;
                font-size: 15px;
            }
        }

        .pagination-list li:hover a {
            color: var(--main-blue);
        }

        .item-active {
            background-color: var(--light-blue);
        }

        .pagination-list .item-active:hover a {
            color: var(--main-font);
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
            min-width: max-content;
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

        .hashtag-item-active {
            color: white;
            background-color: var(--main-pink);
            font-weight: bold;
        }

        .hashtag_splide_wrapper {
            display: none;

            @media (max-width: 768px) {
                display: block;
            }
        }

        /** Animation **/

        .list-item.card.animated-block {
            opacity: 0;
            translate: -30%;
            transition: opacity 400ms ease-in-out, translate 600ms ease, scale 250ms ease;

            @media (max-width: 768px) {
                opacity: 1;
                translate: initial;
            }
        }

        .list-item.card.animated-block:nth-child(odd) {
            translate: 130%;

            @media (max-width: 768px) {
                opacity: 1;
                translate: initial;
            }
        }

        .list-item.card.animated-block.active {
            opacity: 1;
            translate: 0;
        }

        .bread-crumbs {
            position: relative;
        }

        .admin-links {
            top: 30px;
        }

        .admin-links a {
            color: var(--main-pink);
        }
    </style>
@endsection
