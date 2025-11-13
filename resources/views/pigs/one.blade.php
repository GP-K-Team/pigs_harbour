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
    @vite('resources/js/updateStatus.js')
@endpush

@php
    use App\Enum\Fur;
    use App\Enum\Sex;
    use App\Models\Pig;
    use App\Models\City;
    use App\Enum\AgeFilter;
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
    <div class="pig_wrapper" data-pig-slug="{{$pig->slug_name}}">
        <div class="bread-crumbs">
            <ul>
                <li><a href="/">Главная</a></li>
                @if($pig->is_active || !$pig->is_active && !$isAdmin)
                    <li><a href="/catalog">Ищут дом</a></li>
                @else
                    <li><a href="{{ route('pigs.archive') }}">Архив</a></li>
                @endif
                <li>{{ $pig->name }}</li>
            </ul>
        </div>

        <div class="pig_main_block_wrapper">

            <div class="pig_image_block">
                <div class="main_image_wrapper">
                    <img class="blurred_main_pig_image"
                         src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
                         alt="Фон для фотографии свинки по имени {{ $pig->name }}">
                    <img class="main_pig_image"
                         src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
                         alt="Фотография морской свинки по имени {{ $pig->name }}">
                </div>
                @if($pig->images()->count() > 1)
                    <div class="thumbnails">
                        <ul class="thumbnail_list">
                            @foreach($pig->images as $image)
                                <li class="thumbnail_element">
                                    <img src="{{ asset($image->getFullUrl()) }}" alt="Изображение морской свинки">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="pig_details_block">
                @if($isAdmin)
                <div class="admin_controls_wrapper">
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
                                <div class="radio-item">
                                    <input type="radio" name="is_active" id="1"
                                           value="1" checked>
                                    <label for="1">Да</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" name="is_active" id="0"
                                           value="0" @checked(isset($pig) && !$pig->is_active)>
                                    <label for="0">Нет</label>
                                </div>
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

                    @if($pig->companion || $pig->companionOf)
                        @php
                            $companion = $pig->companion ?? $pig->companionOf;
                        @endphp
                        <p>
                            <b>
                                Пристраивается в паре со свинкой <a class="companion_link" href="{{ route('catalog.one', [$companion]) }}">{{ $companion->name }}</a>
                            </b>
                        </p>
                    @endif

                </div>
                @if($pig->is_active)
                    <div class="button pig_details_button">
                        <a href="/blog/kak-vzyat">
                            Как взять свинку
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="pig_description">
            {{ $pig->description }}
        </div>
    </div>

    @if($pig->is_active)
        <div class="additional_text">
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
        <div class="additional_pigs_wrapper">
            <h2 class="additional_pigs_header">{{ $pig->is_active ? 'Ещё свинки' : 'Свинки' }} в поисках дома →</h2>

            <ul class="additional_pig_list">
                @foreach($additionalPigs as $pig)
                <li>
                    <a href="{{ route('catalog.one', compact('pig')) }}">
                        <img class="additional_pig_image"
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
    .pig_wrapper {
        padding: 40px;
        position: relative;
        overflow: hidden;
        min-height: 500px;
        background-image: url("/images/texture-light.png");
        z-index: 0;
    }

    .pig_wrapper:before,
    .pig_wrapper:after {
        content: '';
        position: absolute;
        z-index: -1;
    }

    .pig_wrapper:before {
        top: -50px;
        left: -10%;
        height: 40vh;
        width: 40vh;
        border-radius: 50%;
        background-color: var(--pale_orange);

        @media (max-width: 768px) {
            top: 15%;
            left: -30%;
            height: 30vh;
            width: 30vh;
        }
    }

    .pig_wrapper:after {
        bottom: -20%;
        right: -15%;
        height: 50vh;
        width: 50vh;
        border-radius: 50%;
        background-color: var(--pale_yellow);

        @media (max-width: 768px) {
            bottom: 5%;
            right: -30%;
            height: 30vh;
            width: 30vh;
        }
    }

    .additional_text {
        border-top: 10px solid var(--main_pink);
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

    .additional_pigs_wrapper {
        border-top: 10px solid var(--pale_orange);
        background-image: url("/images/texture-light.png");
    }

    .additional_pigs_header {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        text-align: center;

        @media (max-width: 1300px) {
            font-size: 25px;
        }
    }

    .additional_pig_list {
        display: flex;
        column-gap: 30px;
        justify-content: center;
    }

    .additional_pig_list li {
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }

    .additional_pig_list li:hover {
        transform: scale(1.1);
    }

    .additional_pig_image {
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

    .pig_description {
        position: relative;
        padding: 20px 0;
        text-align: justify;
        font-size: 25px;
        z-index: 2;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .pig_main_block_wrapper {
        display: flex;
        column-gap: 50px;

        @media (max-width: 768px) {
            flex-direction: column;
            row-gap: 50px;
        }
    }

    .pig_image_block, .pig_details_block {
        width: 50%;
        z-index: 2;

        @media (max-width: 768px) {
            width: 100%;
        }
    }

    .pig_image_block {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .main_image_wrapper {
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

    .main_pig_image {
        margin: auto;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .blurred_main_pig_image {
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

    .thumbnail_list {
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

    .thumbnail_element img {
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

    .thumbnail_element:hover img {
        transform: scale(1.02);
    }

    .pig_details_block {
        position: relative;
        z-index: 2;
        font-size: 25px;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .companion_link {
        text-decoration: underline;
    }

    .admin_controls_wrapper {
        position: relative;
    }

    .admin_controls_wrapper fieldset {
        padding: 0.125rem 1rem 0.5rem;
    }

    .edit-icon-link {
        position: absolute;
        top: -60%;
        right: 0;
    }

    @media (max-width: 880px) {
        .button.pig_details_button {
            font-size: 20px;
        }
    }
</style>
