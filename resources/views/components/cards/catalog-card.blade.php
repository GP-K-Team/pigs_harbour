@props([
    'href',
    'image',
    'imageAlt',
    'title',
    'foodProduct' => null,
    'color' => null,
    'borderColor' => null,
    'class' => '',
    'canEdit' => false,
    'editHref' => null,
    'editAlt' => 'Иконка редактирования карточки',
    'bottomIcon' => null,
    'bottomIconAlt' => '',
    'dataUrl' => null,
])

@php
    use App\Models\FoodProduct;
    use Illuminate\Support\Str;

    /** @var FoodProduct|null $foodProduct */
    if ($foodProduct) {
        $foodProductHashtags = $foodProduct->relationLoaded('hashtags')
            ? $foodProduct->hashtags->pluck('tag')
            : $foodProduct->hashtags()->pluck('tag');
        $normalizedHashtags = $foodProductHashtags->map(fn (string $tag) => Str::lower($tag));
        $signalTags = ['можно', 'нельзя', 'с осторожностью'];
        $signalTag = match (true) {
            $normalizedHashtags->contains('нельзя') => 'check-no',
            $normalizedHashtags->contains('с осторожностью') => 'warning',
            $normalizedHashtags->contains('можно') => 'allowed',
            default => null,
        };

        $color ??= match ($signalTag) {
            'check-no' => '#FBEFF4',
            'warning' => '#FFFDF4',
            default => '#F4FAF5',
        };
        $borderColor ??= match ($signalTag) {
            'check-no' => '#EAB0C8',
            'warning' => '#FEF3C6',
            'allowed' => '#E5F1E3',
            default => null,
        };
        $bottomIcon ??= match ($signalTag) {
            'check-no' => asset('images/icons/food-close.svg'),
            'warning' => asset('images/icons/warning.svg'),
            'allowed' => asset('images/icons/food-check.svg'),
            default => null,
        };
        $bottomIconAlt = $bottomIconAlt ?: (
            $foodProductHashtags->first(fn (string $tag) => in_array(Str::lower($tag), $signalTags, true)) ?? ''
        );
    }
@endphp

@once
    @push('styles')
        <style>
            .list-item.card.catalog-card.food-product-card {
                display: flex;
                flex-direction: column;
                width: 350px;
                height: 430px;
                background-color: var(--catalog-card-background, #F4FAF5);
                border: var(--catalog-card-border-width, 0) solid var(--catalog-card-border, transparent);
                border-radius: 10px;
                filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
                cursor: pointer;
                transition: 250ms;
                overflow: visible;
            }

            .list-item.card.catalog-card.food-product-card:hover {
                opacity: 0.9;
                scale: 1.01;
                transition: 250ms;
            }

            .catalog-card.food-product-card .catalog-card-link {
                height: 100%;
                display: flex;
                flex-direction: column;
                color: var(--main-font) !important;
            }

            .catalog-card.food-product-card .catalog-card-image-wrapper {
                position: relative;
                display: block;
            }

            .catalog-card.food-product-card .card-image {
                width: 100%;
                height: 250px;
                object-fit: cover;
                border-radius: 10px 10px 0 0;
            }

            .catalog-card.food-product-card .card-bio {
                display: flex;
                flex-direction: column;
                padding: 0.25rem 1rem 1rem;
                row-gap: 0.5rem;
                flex-grow: 1;
            }

            .catalog-card.food-product-card .card-title {
                padding: 0;
                margin: 0;
                font-size: 2rem;
                line-height: 1.1;
            }

            .catalog-card.food-product-card .card-description {
                margin: 0;
                padding: 0;
                font-size: 1.25rem;
                display: -webkit-box;
                overflow: hidden;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }

            .catalog-card.food-product-card .catalog-card-bottom-icon {
                position: absolute;
                left: 1rem;
                bottom: -1.375rem;
                width: 3.25rem;
                height: 3.25rem;
                object-fit: contain;
            }

            .catalog-card.food-product-card .card-button {
                margin-top: auto;
                align-self: center;
                min-width: 170px;
                padding: 0.35rem 1rem;
                font-size: 1rem;
                line-height: 1.2;
                text-transform: uppercase;
                background-color: #C3E9EA;
                border: 1px solid var(--main-font);
                border-radius: 0.5rem;
            }

            .catalog-card.food-product-card .edit-icon-link {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                background-color: var(--light-pink);
                z-index: 5;
            }

            .catalog-card.food-product-card .food-product-delete-wrapper {
                position: absolute;
                right: 0.5rem;
                bottom: 0.5rem;
            }

            @media (max-width: 1200px) {
                .list-item.card.catalog-card.food-product-card {
                    width: 217px;
                }

                .catalog-card.food-product-card .card-title {
                    font-size: 1.5rem;
                }

                .catalog-card.food-product-card .card-description,
                .catalog-card.food-product-card .card-button {
                    font-size: 1rem;
                }
            }

            @media (max-width: 768px) {
                .list-item.card.catalog-card.food-product-card {
                    width: 90%;
                    max-width: 300px;
                    height: 400px;
                }

                .catalog-card.food-product-card .card-image {
                    height: 200px;
                }
            }
        </style>
    @endpush
@endonce

<li
    @class([
        'list-item',
        'card',
        'catalog-card',
        'can-edit' => $canEdit,
        $class,
    ])
    @if($color || $borderColor) style="@if($color)--catalog-card-background: {{ $color }};@endif @if($borderColor)--catalog-card-border: {{ $borderColor }}; --catalog-card-border-width: 2px;@endif" @endif
    @if($dataUrl) data-url="{{ $dataUrl }}" @endif
>
    @if($canEdit && $editHref)
        <a class="edit-icon-link" href="{{ $editHref }}" draggable="false">
            <img src="{{ asset('images/icons/edit.svg') }}" alt="{{ $editAlt }}" draggable="false">
        </a>
    @endif

    <a class="catalog-card-link" href="{{ $href }}">
        <span class="catalog-card-image-wrapper">
            <img class="card-image"
                 src="{{ $image }}"
                 width="350" height="250" alt="{{ $imageAlt }}">

            @if($bottomIcon)
                <img class="catalog-card-bottom-icon" src="{{ $bottomIcon }}" alt="{{ $bottomIconAlt }}" draggable="false">
            @endif
        </span>

        <div class="card-bio">
            <h2 class="card-title">{{ $title }}</h2>
            {{ $slot }}
        </div>
    </a>
</li>
