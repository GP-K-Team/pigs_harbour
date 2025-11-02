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

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>Полезные статьи</h1>
            <p>все самое важное, что нужно знать о морских свинках</p>
        </div>
    </div>

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
            @if(false)
                <li class="list-item card add-card">
                    <a class="add-card-link" href="{{ route('articles.show.create') }}" draggable="false">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path
                                d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                        </svg>
                        <p class="add-card-link-text">Добавить статью</p>
                    </a>
                </li>
            @endif

            @foreach($articles as $article)
                <li class="list-item card @if(true) can-edit @endif">
                    @if(true)
                        <a class="edit-icon-link" href="{{ route('articles.show.update', compact('article')) }}"
                           draggable="false">
                            <img src="{{ asset('images/icons/edit.svg') }}" alt="" draggable="false">
                        </a>
                    @endif

                    <a href="{{ route('articles.one', compact('article')) }}">
                        <img class="card-image" width="350" height="250" alt="Обложка статьи"
                             src="{{ $article->mainImage?->getFullUrl() ?? FileHelper::getDefaultImage($article) }}">
                        <div class="card-bio">
                            <h2 class="card-title">{{ $article->title }}</h2>
                            <p>{{ $article->description }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <style>
        .button {
            width: fit-content;
            padding: 0.25rem 1.5rem;
            text-transform: uppercase;
            font-family: inherit;
            font-size: 2rem;
            background-color: #C3E9EA;
            border: solid 2px #000000;
            border-radius: 0.75rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .button {
                font-size: 1.5rem;
            }
        }

        .bread-crumbs {
            margin: 3.75rem;
            font-family: Inter, Nunito, Arial, sans-serif;
        }

        .bread-crumbs > ul {
            display: flex;
            flex-direction: row;
            row-gap: 0.5rem;
        }

        .bread-crumbs > ul :is(li, a) {
            color: var(--brown_gray);
            font-size: 1rem;
        }

        .bread-crumbs > ul > li > a:hover {
            color: var(--main_blue);
        }

        .bread-crumbs > ul > li:not(:last-child)::after {
            content: " / ";
        }

        /** Page header **/
        .page-header {
            width: 100%;
            height: 40vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-image: url("{{ asset('images/dots.jpg') }}");
            background-size: 25%;
            box-shadow: 0 4px 4px 0 var(--shadow_drop);
        }

        @media (max-width: 768px) {
            .page-header {
                height: 50dvh;
                background-size: 50%;
            }
        }

        .page-header-text {
            padding: 1.25rem 0;
            min-height: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            text-align: center;
            background-color: var(--overlay);
        }

        .page-header-text > h1 {
            margin: 0;
            font-family: '315karusel', sans-serif;
            font-size: 3rem;
        }

        .page-header-text > p {
            max-width: 75%;
            margin: 0;
            padding: 0 1.5rem;
            font-family: 'overdoze sans', sans-serif;
            font-size: 2.5rem;
            text-transform: lowercase;
        }

        @media (max-width: 768px) {
            .page-header-text {
                min-height: 25%;
            }

            .page-header-text > h1 {
                font-size: 1.875rem;
            }

            .page-header-text > p {
                font-size: 1.25rem;
            }
        }

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
            width: 100%;
            max-width: 90vw;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .list-item.card {
            display: flex;
            flex-direction: row;
            width: 100%;
            height: 300px;
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 4px 0 var(--shadow_drop);
            cursor: pointer;
        }

        .list-item.card > a {
            display: flex;
            flex-direction: row;
        }

        @media (max-width: 1200px) {
            .list-item.card {
                width: 217px;
            }
        }

        @media (max-width: 768px) {
            .list-item.card {
                width: 90%;
                max-width: 300px;
                height: 340px;
            }
        }

        .card.add-card {
            align-self: flex-start;
        }

        @media (max-width: 1200px) {
            .card.add-card {
                height: 250px;
            }

            .add-card-link-text {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .card.add-card {
                height: max-content;
            }
        }

        .card:nth-child(2n) {
            background-color: var(--light_pink);
        }

        .card p {
            margin: 0;
            padding: 0;
            font-size: 1.25rem;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        @media (max-width: 768px) {
            .card-image {
                height: 200px;
            }
        }

        .card-bio {
            width: 100%;
            display: flex;
            flex-direction: column;
            padding: 0.75rem 2.5rem;
            row-gap: 0.5rem;
        }

        .card-title {
            padding: 0;
            margin: 0;
            font-size: 2rem;
        }

        @media (max-width: 1200px) {
            .card-bio > .card-title {
                font-size: 1.5rem;
            }

            .card-bio > p {
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
            background-color: var(--white_trp);
        }

        .add-card-link {
            padding: 0.75rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            place-items: center;
            place-content: center;
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
            color: var(--main_pink);
            opacity: 0.6;
        }

        .add-card-link .add-card-link-text {
            visibility: hidden;
            font-family: inherit;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
        }

        .add-card-link:hover .add-card-link-text {
            visibility: visible;
        }
    </style>
@endsection
