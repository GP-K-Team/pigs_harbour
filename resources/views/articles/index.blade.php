@extends('layouts.main', ['background' => 'texture-light'])

@section('title')
    Статьи
@endsection

@php
    use App\Models\Article;
    use App\Helpers\FileHelper;
    use Illuminate\Support\Collection;

    /** @var Collection|iterable<Article> $articles */
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bread-crumbs.css') }}">
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
        <div class="list-header" style="display:none;">
            {{-- todo: hashtags go here --}}
        </div>

        <ul class="list">
            @if($isAdmin)
                <li class="list-item card add-card">
                    <a class="add-card-link" href="{{ route('articles.show.create') }}" draggable="false">
                        <p class="add-card-link-text">Добавить статью</p>
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                        </svg>
                    </a>
                </li>
                <li></li>
            @endif

            @foreach($articles as $article)
                <li class="list-item card @if(true) can-edit @endif">
                    <a href="{{ route('articles.one', compact('article')) }}">
                        <img class="card-image" width="350" height="250" alt="Обложка статьи"
                             src="{{ $article->mainImage?->getFullUrl() ?? FileHelper::getDefaultImage($article) }}">
                    </a>
                    <div class="card-bio">
                        <a href="{{ route('articles.one', compact('article')) }}">
                            <h2 class="card-title">{{ $article->title }}</h2>
                        </a>

                        @if(true)
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

        <div class="pagination">
            <button class="button pagination-next-button">Показать ещё</button>
            <ul class="pagination-list">
                {{-- todo: pages --}}
            </ul>
        </div>
    </div>

    <style>
        /** List **/
        .list-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 1rem 1rem;
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
            gap: 1rem;
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
            row-gap: 0.5rem;
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
    </style>
@endsection
