@extends('layouts.main')

@section('title', $foodProduct->meta_title ?? $foodProduct->title)
@section('description', $foodProduct->meta_description ?? 'Продукт')
@section('og_title', $foodProduct->meta_title ?? $foodProduct->title)

@if($foodProduct->mainImage)
    @section('og_image', $foodProduct->mainImage?->getFullUrl())
@endif

@php
    use App\Models\FoodProduct;
    use App\Models\Hashtag;
    use Illuminate\Support\Str;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /** @var <FoodProduct> $foodProduct */
    /** @var Collection|iterable<FoodProduct> $additionalFoodProducts */
    /** @var Collection|iterable<Hashtag> $hashtags */
    /** @var bool $admin */
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bread-crumbs.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/article.css') }}">
@endpush

@push('js')
    @vite('resources/js/delete-handler.js')
    @vite('resources/js/splide.js')
@endpush

@section('content')
    @include('components.banner', ['showPigs' => false, 'specialHeader' => $foodProduct->title])

    <div class="bread-crumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="{{ route('products.index') }}">Продукты</a></li>
            <li>{{ $foodProduct->title }}</li>
        </ul>
    </div>

    @if($isAdmin || $foodProduct->synonyms)
        <div class="article-date">
            @if($isAdmin)
                <div class="control-buttons">
                    <a class="edit-icon-link" href="{{ route('products.show.update', compact('foodProduct')) }}" draggable="false">
                        <img src="{{ asset('images/icons/edit.svg') }}" height="28" alt="Иконка редактирования карточки" draggable="false">
                    </a>
                    <div class="delete-form-wrapper">
                        @include('components.buttons.food-product-delete-button', ['foodProductToDelete' => $foodProduct])
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="article-container">
        {!! $foodProduct->text !!}
    </div>

    <dl class="article-info">
        @if($foodProduct->type)
            <div class="article-info-item">
                <dt>Тип:</dt>
                <dd>{{ $foodProduct->type }}</dd>
            </div>
        @endif


    </dl>

    @if($additionalFoodProducts->count())
        <div class="additional-articles-wrapper">
            <h2 class="additional-articles-header">Еще по теме →</h2>

            <ul class="article-list">
                @foreach($additionalFoodProducts as $additionalFoodProduct)
                    <li class="article-list-item article-card" onclick="location.replace('{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}')">
                        <a href="{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}">
                            <img class="article-card-image" width="350" height="250" alt="Обложка продукта"
                                 src="{{ $additionalFoodProduct->mainImage?->getFullUrl() ?? $additionalFoodProduct::getDefaultImage() }}">
                        </a>
                        <div class="article-card-bio">
                            <a href="{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}">
                                <h2 class="article-card-title">{{ $additionalFoodProduct->title }}</h2>
                            </a>

                            <p class="article-card-description">{{ $additionalFoodProduct->description }}</p>

                            <a class="button article-card-button"
                               href="{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}">
                                Читать
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            <section id="products_splide" class="splide articles-splide-wrapper" aria-label="Splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($additionalFoodProducts as $additionalFoodProduct)
                            <li class="splide__slide" onclick="location.replace('{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}')">
                                <div class="article-list-item article-card">
                                    <a href="{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}">
                                        <img class="article-card-image" width="350" height="250" alt="Обложка продукта"
                                             src="{{ $additionalFoodProduct->mainImage?->getFullUrl() ?? $additionalFoodProduct::getDefaultImage() }}">
                                    </a>
                                    <div class="article-card-bio">
                                        <a href="{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}">
                                            <h2 class="article-card-title">{{ $additionalFoodProduct->title }}</h2>
                                        </a>

                                        <p class="article-card-description">{{ $additionalFoodProduct->description }}</p>

                                        <a class="button article-card-button"
                                           href="{{ route('products.one', ['foodProduct' => $additionalFoodProduct]) }}">
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
                        <a href="{{ route('products.index') }}">
                            <li class="hashtag-item">
                                    Все
                            </li>
                        </a>
                    @foreach($hashtags as $hashtag)
                        <a href="{{ route('products.index', $hashtag->slug) }}" >
                            <li class="hashtag-item">
                            {{ $hashtag->tag }}
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @include('components.modal.modal-delete-confirm')
@endsection

<style>
    .control-buttons {
        position: absolute;
        left: 0;
        display: flex;
        flex-direction: row;
        gap: 0.5rem;
    }

    .edit-icon-link:hover {
        border-radius: 0.5rem;
        background-color: var(--pale-yellow);
    }

    .article-date {
        position: relative;
        margin: 0 3.75rem 1.25rem;
        text-align: right;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--brown-gray);
    }

    @media screen and (max-width: 1200px) {
        .article-date {
            margin: 0 2.5rem 2.5rem;
            font-size: 1rem;
        }
    }

    @media screen and (max-width: 1200px) {
        .article-date {
            margin: 0 1.25rem 1.25rem;
        }
    }

    .article-info {
        width: 100%;
        margin: 0 3.75rem 1.25rem;
        color: var(--brown-gray);
        font-size: 1.25rem;
        font-style: italic;
    }

    .article-info .article-info-item {
        display: flex;
        column-gap: 0.25rem;
    }

    .article-info-item > dd {
        margin: 0;
    }

    .article-info-item a {
        color: inherit;
    }

    .article-info-item a:hover {
        color: var(--dark-blue-font);
    }

    .splide__slide {
        padding: 10px 5px;
    }

    .splide__pagination {
        bottom: -15px !important;
    }

    /* Additional articles list */
    .additional-articles-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        row-gap: 35px;
        border-top: 10px solid var(--pale-orange);
        background-image: url("/images/texture-light.png");
    }

    .additional-articles-header {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        text-align: center;

        @media (max-width: 1300px) {
            font-size: 25px;
        }
    }

    /* Hashtags */
    .hashtag-list-header {
        padding: 10px 0;
        max-width: 80%;

        @media (max-width: 768px) {
            padding-bottom: 25px;
            overflow-x: scroll;
        }
    }

    .hashtag-list {
        padding: 10px 0;
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
        padding: 5px 20px;
        border-radius: 10px;
        font-size: 15px;
        cursor: pointer;
        background-color: white;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .hashtag-item:hover {
        opacity: 0.7;
    }

    .articles-splide-wrapper {
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
        box-shadow: 0 4px 4px 0 var(--shadow-drop);
        cursor: pointer;
        transition: 250ms;
        overflow: hidden;
    }

    .article-card:hover {
        opacity: 0.9;
        scale: 1.01;
        transition: 250ms;
    }

    @media (max-width: 768px) {
        .article-list-item.article-card {
            margin: auto;
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
        color: var(--main-font) !important;
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
            width: 100%;
        }
    }

    .article-card-image.article-card-image_alt-shown {
        width: fit-content;
        height: fit-content;
        padding: 1rem 0.5rem 0;
        display: inline-flex;
        align-items: center;
        color: var(--dark-blue-font);
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
