@extends('layouts.main', ['background' => 'texture-light'])

@section('title', 'Рацион морской свинки: что можно и нельзя — большой список продуктов')
@section('description', 'Узнайте, какие овощи, фрукты и растения можно давать морской свинке. Удобный справочник с поиском по названию, карточки с дозировками и пользой')
@section('og_image', url('/images/og-food.jpg'))

@php
    use App\Models\FoodProduct;
    use Illuminate\Support\Collection;
    use App\Models\Hashtag;

    /** @var Collection|iterable<FoodProduct> $foodProducts */
    /** @var Collection|iterable<Hashtag> $hashtags */
    /** @var bool $isAdmin */
    /** @var string $activeHashtagSlug */
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bread-crumbs.css') }}">
@endpush

@push('js')
    @vite('resources/js/catalog-initialize.js')
    @vite('resources/js/blog.js')
    @vite('resources/js/page-text.js')
    @vite('resources/js/delete-handler.js')
    @vite('resources/js/main-animation.js')
@endpush

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    @include('components.banner', ['showPigs' => false, 'specialHeader' => 'Рацион морской свинки', 'specialText' => 'какие овощи, фрукты и растения можно давать морским свинкам'])

    <div class="bread-crumbs catalog-wrapper">
        <ul>
            <li><a href="/">Главная</a></li>
            <li>Продукты</li>
        </ul>

        @if($isAdmin)
            <div class="admin-links">
                <a href="{{ route('search-queries.index', ['type' => FoodProduct::searchType()]) }}">Запросы</a>
            </div>
        @endif
    </div>

    <div class="list-container">
        <x-search.search type="food_products" placeholder="Можно ли морским свинкам..." icon="/images/icons/food-search.svg"/>

        <div class="hashtag-list-header">
            <ul class="hashtag-list">
                <a href="{{ route('products.index') }}">
                    <li @class(['hashtag-item-active' => !$activeHashtagSlug, 'hashtag-item']) data-hashtag="vse">
                        Все
                    </li>
                </a>
                @foreach($hashtags as $hashtag)
                    <a href="{{ route('products.index', $hashtag->slug) }}">
                        <li @class(['hashtag-item-active' => $hashtag->slug === $activeHashtagSlug, 'hashtag-item']) data-hashtag="{{ $hashtag->slug }}">
                            {{ $hashtag->tag }}
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>


        @if($foodProducts->isEmpty())
            <h3>Нет результатов</h3>

            @if($isAdmin)
                <ul class="list">
                    <li class="list-item card add-card">
                        <a class="add-card-link" href="{{ route('products.show.create') }}" draggable="false">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <path d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                            </svg>
                            <p class="add-card-link-text">Добавить продукт</p>
                        </a>
                    </li>
                </ul>
            @endif
        @else
            <ul class="list food-product-list">
                @if($isAdmin)
                    <li class="list-item card add-card">
                        <a class="add-card-link" href="{{ route('products.show.create') }}" draggable="false">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <path d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                            </svg>
                            <p class="add-card-link-text">Добавить продукт</p>
                        </a>
                    </li>
                @endif

                @foreach($foodProducts as $foodProduct)
                    <x-cards.catalog-card
                        :href="route('products.one', compact('foodProduct'))"
                        :image="$foodProduct->mainImage?->getFullUrl() ?? $foodProduct->getDefaultImage()"
                        image-alt="Обложка продукта {{ $foodProduct->title }}"
                        :title="$foodProduct->title"
                        class="animated-block food-product-card"
                        :data-url="route('products.one', compact('foodProduct'))"
                        :can-edit="$isAdmin"
                        :edit-href="route('products.show.update', compact('foodProduct'))"
                        :food-product="$foodProduct"
                    >
                        <p class="card-description">{{ $foodProduct->description }}</p>

                        <span class="button card-button">Подробнее</span>

                        @if($isAdmin)
                            <div class="delete-form-wrapper food-product-delete-wrapper">
                                @include('components.buttons.food-product-delete-button', ['foodProductToDelete' => $foodProduct])
                            </div>
                        @endif
                    </x-cards.catalog-card>
                @endforeach
            </ul>

            @if($foodProducts->total() > 1 && $foodProducts->lastPage() !== 1)
                <div class="pagination-wrapper">
                    <ul class="pagination-list">
                        <a href="?page=1">
                            <li @class(['item-active' => $foodProducts->currentPage() === 1])>
                                1
                            </li>
                        </a>

                        @if($foodProducts->lastPage() > 2)

                            @if($foodProducts->currentPage() !== 1 &&
                                               $foodProducts->currentPage() - 1 != 1 &&
                                                    $foodProducts->currentPage() - 2 != 1)
                                <li>
                                    ...
                                </li>
                            @endif

                            @if($foodProducts->currentPage() !== 1 && $foodProducts->currentPage() - 1 !== 1 && $foodProducts->currentPage() !== $foodProducts->lastPage())
                                <a href="{{ $foodProducts->previousPageUrl() }}">
                                    <li>
                                        {{ $foodProducts->currentPage() - 1 }}
                                    </li>
                                </a>
                            @endif

                            @if($foodProducts->currentPage() === 1)
                                <a href="{{ $foodProducts->nextPageUrl() }}">
                                    <li>
                                        {{ $foodProducts->currentPage() + 1 }}
                                    </li>
                                </a>
                            @elseif($foodProducts->currentPage() === $foodProducts->lastPage())
                                <a href="{{ $foodProducts->previousPageUrl() }}">
                                    <li>
                                        {{ $foodProducts->lastPage() - 1 }}
                                    </li>
                                </a>
                            @else
                                <a>
                                    <li @class(['item-active'])>
                                        {{ $foodProducts->currentPage()}}
                                    </li>
                                </a>
                            @endif

                            @if($foodProducts->currentPage() !== 1 && $foodProducts->currentPage() + 1 !== $foodProducts->lastPage() && $foodProducts->currentPage() !== $foodProducts->lastPage())
                                <a href="{{ $foodProducts->nextPageUrl() }}">
                                    <li>
                                        {{ $foodProducts->currentPage() + 1 }}
                                    </li>
                                </a>
                            @endif

                            @if($foodProducts->currentPage() + 1 != $foodProducts->lastPage() &&
                                                $foodProducts->currentPage() + 2 != $foodProducts->lastPage() &&
                                                                        $foodProducts->currentPage() !== $foodProducts->lastPage())
                                <li>
                                    ...
                                </li>
                            @endif
                        @endif

                        <a href="{{ "?page=" . $foodProducts->lastPage()  }}">
                            <li @class(['item-active' => $foodProducts->currentPage() === $foodProducts->lastPage()])>
                                {{ $foodProducts->lastPage() }}
                            </li>
                        </a>
                    </ul>
                </div>
            @endif
        @endif
    </div>

    <div class="footer-block food-products-footer">
        <div class="footer-text food-products-footer-text">
            <p>
                Правильное питание — основа долгой и здоровой жизни вашего питомца. Морские свинки — строгие
                вегетарианцы, но далеко не все растения и плоды им полезны. Некоторые продукты могут вызвать
                серьёзное отравление, вздутие живота или проблемы с зубами. Поэтому перед тем как предложить свинке
                что-то новое, всегда сверяйтесь с нашим справочником.
            </p>

            <p><strong>Главные принципы здорового рациона морской свинки:</strong></p>

            <ol>
                <li>
                    <a href="/blog/seno-dlya-morskih-svinok"><strong>Сено</strong></a><strong> — основа всего.</strong> Оно должно быть в доступе 24/7. Сено
                    стачивает зубы и налаживает пищеварение.
                </li>
                <li>
                    <strong>Витамин C обязателен.</strong> Морские свинки, как и люди, не синтезируют
                    этот витамин. Его источники: свежие овощи (болгарский перец, петрушка).
                </li>
                <li>
                    <strong>Новые продукты вводите постепенно.</strong> Даже полезную морковь или яблоко
                    давайте маленькими кусочками и следите за реакцией организма.
                </li>
                <li>
                    <a href="/blog/nelzya-davat-morskim-svinkam"><strong>Запрещенные продукты</strong></a><strong> — не шутка.</strong> Лук, чеснок, картофель, молочные
                    продукты, мясо, хлеб — под строгим запретом. Некоторые травы (например, чистотел, вьюнок) ядовиты
                    даже в малых дозах.
                </li>
            </ol>

            <p>
                Кликните на любой продукт, чтобы прочитать полноценную статью с рекомендациями по кормлению: сколько и
                как часто давать свинке.
            </p>
            <p>
                Помните: разнообразие — залог хорошего аппетита и настроения вашей морской свинки. Составляйте рацион с
                умом, и ваш пушистый друг будет радовать вас здоровьем и активностью!
            </p>
        </div>
    </div>

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

        .food-product-list .catalog-card.food-product-card .edit-icon-link {
            z-index: 10;
        }

        .food-product-list .catalog-card.food-product-card .food-product-delete-wrapper {
            position: absolute;
            top: 0.5rem;
            right: 2.75rem;
            bottom: auto;
            z-index: 5;
        }

        .food-product-list .catalog-card.food-product-card .food-product-delete-wrapper .delete-button-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem;
            height: 1.75rem;
            padding: 0.25rem;
        }

        .card.add-card {
            flex-direction: column;
            width: 350px;
            height: 430px;
            background-color: var(--light-blue);
            border-radius: 1rem;
            overflow: hidden;
        }

        .card.add-card:hover {
            background-color: #FFFFFF;
        }

        .card.add-card > .add-card-link {
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
            color: var(--main-green);
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

        @media (max-width: 1200px) {
            .card.add-card {
                width: 217px;
                height: 250px;
                align-self: flex-start;
            }

            .add-card-link-text {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .card.add-card {
                width: 90%;
                max-width: 300px;
                height: max-content;
                align-self: unset;
            }
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
            padding: 60px;
            border-top: 10px solid var(--main-pink);
            background-image: url("/images/bright_dark.png");

            @media(max-width: 1206px) {
                padding: 40px;
            }

            @media(max-width: 768px) {
                padding: 20px;
            }
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

        .food-products-footer-text {
            margin: 0 auto;
            font-weight: 400;
            font-size: 15px;
            line-height: 20px;
        }

        .food-products-footer-text p,
        .food-products-footer-text ol {
            margin: 0;
        }

        .food-products-footer-text ol {
            display: flex;
            flex-direction: column;
            row-gap: 1rem;
            padding-left: 1.5rem;
        }

        .food-products-footer-text a {
            color: var(--main-font);
            text-decoration: underline;
            text-underline-offset: 0.15em;
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

        /** Food product cards **/
        .food-product-list {
            max-width: 90vw;
            gap: 1rem;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .food-product-list {
                flex-direction: column;
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
            margin-top: 10px;
        }

        .admin-links a {
            color: var(--main-pink);
        }
    </style>
@endsection
