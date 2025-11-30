@extends('layouts.main')

@section('title')
{{ $pig->name }}
@endsection

@section('description')
Морская свинка {{ $pig->name }} в поисках дома
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bread-crumbs.css') }}">
@endpush

@push('js')
    @vite('resources/js/thumbnails.js')
    @vite('resources/js/update-status.js')
@endpush

@php
    use App\Enum\Fur;
    use App\Enum\Sex;
    use App\Models\Pig;
    use App\Models\City;
    use App\Enum\AgeFilter;
    use App\Enum\PigStatus;
    use Illuminate\Support\Str;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /** @var <Pig> $pig */
    /** @var Collection|iterable<Pig> $additionalPigs */
    /** @var Collection|iterable<City> $cities */
    /** @var bool $isAdmin */
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    @include('components.banner', ['showPigs' => false, 'specialHeader' => 'Морская свинка', 'specialSubHeader' => $pig->name, 'specialText' => 'в добрые руки'])
    <div class="pig-wrapper" data-pig-slug="{{$pig->slug_name}}">
        <div class="bread-crumbs">
            <ul>
                <li><a href="/">Главная</a></li>
                @if($pig->isActive() || !$pig->isActive() && !$isAdmin)
                    <li><a href="/catalog">Ищут дом</a></li>
                @else
                    <li><a href="{{ route('pigs.archive') }}">Архив</a></li>
                @endif
                <li>{{ $pig->name }}</li>
            </ul>
        </div>

        <div class="pig-main-block-wrapper">

            <div class="pig-image-block">
                <div class="main-image-wrapper">
                    <img class="main-image_blurred"
                         src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
                         alt="Фон для фотографии свинки по имени {{ $pig->name }}">
                    <img class="main-pig-image"
                         src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
                         alt="Фотография морской свинки по имени {{ $pig->name }}">
                </div>
                @if($pig->images()->count() > 1)
                    <div class="thumbnails">
                        <ul class="thumbnail-list">
                            @foreach($pig->images as $image)
                                <li class="thumbnail-element">
                                    <img src="{{ asset($image->getFullUrl()) }}" alt="Изображение морской свинки">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="pig-details-block">
                @if($isAdmin)
                    <div class="admin-controls-wrapper">
                        <div>
                            <a class="edit-icon-link" href="{{ route('catalog.show.update', compact('pig')) }}" draggable="false">
                                <img src="{{ asset('images/icons/edit.svg') }}" alt="Иконка редактирования карточки" draggable="false">
                            </a>
                        </div>
                        <div class="input-container has-radio">
                            <fieldset>
                                <legend class="input-label">
                                    Ищет дом
                                </legend>
                                <div class="radio-group">
                                    @foreach(PigStatus::cases() as $status)
                                        <div class="radio-item">
                                            <input type="radio" name="status" id="{{ $status->value }}"
                                                   value="{{ $status->value }}" @checked($pig?->status === $status || old('status') === $status->value)>
                                            <label for="{{ $status->value }}">{{ $status->getLabel() }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>
                @endif

                <div>
                    <p>
                        <b>Пол</b>: <span>{{ $pig->sex->getLabel() }}</span>
                    </p>
                    <p>
                        <b>ДР</b>: <span>~ {{ $pig->birthday?->translatedFormat('d F Y') ?? 'Неизвестно' }}</span>
                    </p>
                    <p>
                        <b>Город</b>: <span>{{ $pig->city->name }}</span>
                    </p>
                    <p>
                        <b>Доставка</b>: <span>{{ $pig->has_delivery ? 'По РФ' : ('Только в ' . LinguisticsHelper::getCityLocativeForm($pig->city->name)) }}</span>
                    </p>

                    @if($pig->isActive() && ($pig->companion || $pig->companionOf))
                        @php
                            $companion = $pig->companion ?? $pig->companionOf;
                        @endphp
                        <p>
                            <b>
                                Пристраивается в паре со свинкой <a class="companion-link" href="{{ route('catalog.one', [$companion]) }}">{{ $companion->name }}</a>
                            </b>
                        </p>
                    @endif

                </div>
                @if($pig->isActive())
                    <div class="button pig-details-button">
                        <a href="/blog/kak-vzyat">
                            Как взять свинку
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="pig-description">
            {{ $pig->description }}
        </div>
    </div>

    @if($pig->isActive())
        <div class="additional-text">
            <p>
                Все наши животные обработаны от паразитов. Отдаются в готовые условия в обмен на корм или другие нужности для будущих подопечных, после заполнения анкеты. Волонтеры остаются на связи для поддержки будущих владельцев.
            </p>
            <div class="button">
                <a href="/blog/kak-vzyat">
                    Как взять свинку
                </a>
            </div>
        </div>
    @endif

    @if($additionalPigs->count())
        <div class="additional-pigs-wrapper">
            <h2 class="additional-pigs-header">{{ $pig->isActive() ? 'Ещё свинки' : 'Свинки' }} в поисках дома →</h2>

            <ul class="additional-pig-list">
                @foreach($additionalPigs as $pig)
                <li>
                    <a href="{{ route('catalog.one', compact('pig')) }}">
                        <img class="additional-pig-image"
                             src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
                             alt="Фотография морской свинки по имени {{ $pig->name }}">
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="button">
                <a href="{{ route('catalog.index') }}">
                    Показать всех
                </a>
            </div>
        </div>
    @endif
@endsection

<style>
    .pig-wrapper {
        padding: 40px;
        position: relative;
        overflow: hidden;
        min-height: 500px;
        background-image: url("/images/texture-light.png");
        z-index: 0;
    }

    .pig-wrapper:before,
    .pig-wrapper:after {
        content: '';
        position: absolute;
        z-index: -1;
    }

    .pig-wrapper:before {
        top: -50px;
        left: -10%;
        height: 40vh;
        width: 40vh;
        border-radius: 50%;
        background-color: var(--pale-orange);

        @media (max-width: 768px) {
            top: 15%;
            left: -30%;
            height: 30vh;
            width: 30vh;
        }
    }

    .pig-wrapper:after {
        bottom: -20%;
        right: -15%;
        height: 50vh;
        width: 50vh;
        border-radius: 50%;
        background-color: var(--pale-yellow);

        @media (max-width: 768px) {
            bottom: 5%;
            right: -30%;
            height: 30vh;
            width: 30vh;
        }
    }

    .additional-text {
        border-top: 10px solid var(--main-pink);
        padding: 20px 40px;
        text-align: justify;
        background-image: url("/images/bright_dark.png");
        font-size: 25px;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .button {
        margin: 40px auto 20px;
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

    .additional-pigs-wrapper {
        border-top: 10px solid var(--pale-orange);
        background-image: url("/images/texture-light.png");
    }

    .additional-pigs-header {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        text-align: center;

        @media (max-width: 1300px) {
            font-size: 25px;
        }
    }

    .additional-pig-list {
        display: flex;
        column-gap: 30px;
        justify-content: center;
    }

    .additional-pig-list li {
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }

    .additional-pig-list li:hover {
        transform: scale(1.1);
    }

    .additional-pig-image {
        width: 300px;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);

        @media (max-width: 1000px) {
            width: 200px;
            height: 150px;
        }

        @media (max-width: 768px) {
            width: 100px;
            height: 80px;
        }
    }

    .pig-description {
        position: relative;
        padding: 20px 0;
        text-align: justify;
        font-size: 25px;
        z-index: 2;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .pig-main-block-wrapper {
        display: flex;
        column-gap: 50px;

        @media (max-width: 768px) {
            flex-direction: column;
            row-gap: 50px;
        }
    }

    .pig-image-block, .pig-details-block {
        width: 50%;
        z-index: 2;

        @media (max-width: 768px) {
            width: 100%;
        }
    }

    .pig-image-block {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .main-image-wrapper {
        position: relative;
        display: flex;
        width: 400px;
        height: 350px;
        overflow: hidden;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        border-radius: 20px;

        @media (max-width: 1000px) {
            width: 300px;
            height: 200px;
        }
    }

    .main-pig-image {
        margin: auto;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .main-image_blurred {
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: blur(10px);
        z-index: -1;
    }

    .thumbnail-list {
        margin-top: 50px;
        padding: 10px;
        max-width: 400px;
        display: flex;
        justify-content: center;
        column-gap: 10px;
        flex-wrap: wrap;

        @media (max-width: 1000px) {
            max-width: 300px;
        }
    }

    .thumbnail-element img {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        object-fit: cover;
        transition: transform 0.2s ease-in-out;

        @media (max-width: 1000px) {
            width: 60px;
            height: 60px;
        }
    }

    .thumbnail-element:hover img {
        transform: scale(1.02);
    }

    .pig-details-block {
        position: relative;
        z-index: 2;
        font-size: 25px;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .companion-link {
        text-decoration: underline;
    }

    .admin-controls-wrapper {
        position: relative;
    }

    .admin-controls-wrapper fieldset {
        padding: 0.125rem 1rem 0.5rem;
    }

    .edit-icon-link {
        position: absolute;
        top: -60%;
        right: 0;
    }

    @media (max-width: 880px) {
        .button.pig-details-button {
            font-size: 20px;
        }
    }
</style>
