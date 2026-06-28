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

            <ul class="article-list food-product-related-list">
                @foreach($additionalFoodProducts as $additionalFoodProduct)
                    <x-cards.catalog-card
                        :href="route('products.one', ['foodProduct' => $additionalFoodProduct])"
                        :image="$additionalFoodProduct->mainImage?->getFullUrl() ?? $additionalFoodProduct->getDefaultImage()"
                        image-alt="Обложка продукта {{ $additionalFoodProduct->title }}"
                        :title="$additionalFoodProduct->title"
                        class="food-product-card"
                        :food-product="$additionalFoodProduct"
                    >
                        <p class="card-description">{{ $additionalFoodProduct->description }}</p>
                        <span class="button card-button">Подробнее</span>
                    </x-cards.catalog-card>
                @endforeach
            </ul>

            <section id="products_splide" class="splide articles-splide-wrapper" aria-label="Splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($additionalFoodProducts as $additionalFoodProduct)
                            <li class="splide__slide">
                                <x-cards.catalog-card
                                    :href="route('products.one', ['foodProduct' => $additionalFoodProduct])"
                                    :image="$additionalFoodProduct->mainImage?->getFullUrl() ?? $additionalFoodProduct->getDefaultImage()"
                                    image-alt="Обложка продукта {{ $additionalFoodProduct->title }}"
                                    :title="$additionalFoodProduct->title"
                                    class="food-product-card"
                                    :food-product="$additionalFoodProduct"
                                    tag="div"
                                >
                                    <p class="card-description">{{ $additionalFoodProduct->description }}</p>
                                    <span class="button card-button">Подробнее</span>
                                </x-cards.catalog-card>
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

    @media (max-width: 768px) {
        #products_splide {
            width: 100%;
            padding-bottom: 1rem;
        }

        #products_splide .splide__slide {
            display: flex;
            justify-content: center;
        }

        #products_splide .catalog-card.food-product-card {
            margin: 0 auto;
        }
    }
</style>
