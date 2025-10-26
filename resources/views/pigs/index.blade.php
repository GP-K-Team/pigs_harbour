@extends('layouts.main', ['background' => 'texture-light'])

@section('title')
    Свинки
@endsection

@php
    use App\Enum\Fur;
    use App\Enum\Sex;
    use App\Models\Pig;
    use App\Models\City;
    use App\Enum\AgeFilter;
    use Illuminate\Support\Str;
    use App\Helpers\FileHelper;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Vite;

    /** @var Collection|iterable<Pig> $pigs */
    /** @var Collection|iterable<City> $cities */
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
@endpush

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/select-input.js') }}"></script>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>Морские свинки в добрые руки</h1>
            <p>Выберите себе милого друга</p>
        </div>
    </div>

    <div class="list-container">
        <div class="list-header">
            <button class="button list-filter-button" type="button" onclick="$('#filter_window').closest('.window-container').show()">
                Фильтры
            </button>
            @if(request()->fullUrl() !== request()->url())
                <sup class="filter-count">{{ count(array_filter(request()->all())) }}</sup>
            @endif
        </div>

        <div class="window-container">
            <form name="filter">
                <div class="window" id="filter_window">
                    <div class="window-title-container">
                        <h2 class="window-title">Фильтры</h2>
                        <button class="window-close-button" type="button" onclick="">

                        </button>
                    </div>

                    <hr class="divider">

                    <div class="filter-container">
                        <div class="filter-input-container has-select">
                            <label for="city"></label>
                            <select name="city" id="city">
                                <option value="" selected>Любой город</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" @selected(request('city') === $city)>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-input-container">
                            <fieldset>
                                <legend class="input-label">
                                    Пол
                                </legend>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="sex" value="" @checked(empty(request('sex'))) id="sex-empty">
                                        <label for="sex-empty">Любой</label>
                                    </div>

                                    @foreach(Sex::cases() as $sex)
                                        <div class="radio-item">
                                            <input type="radio" name="sex" id="{{ $sex->value }}"
                                                   value="{{ $sex->getLabel() }}" @checked(request('sex') === $sex->getLabel())>
                                            <label for="{{ $sex->value }}">{{ $sex->getLabel() }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>

                        <div class="filter-input-container">
                            <fieldset>
                                <legend class="input-label">
                                    Возраст
                                </legend>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="age" value="" checked id="age-empty">
                                        <label for="age-empty">Любой</label>
                                    </div>

                                    @foreach(AgeFilter::cases() as $age)
                                        <div class="radio-item">
                                            <input type="radio" name="age" id="{{ $age->value }}"
                                                   value="{{ $age->getFilterLabel() }}" @checked(Str::replace('+', ' ', request('age')) === $age->getFilterLabel())>
                                            <label for="{{ $age->value }}">{{ $age->getFilterLabel() }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>

                        <div class="filter-input-container">
                            <fieldset>
                                <legend class="input-label">
                                    Шерсть
                                </legend>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="fur" value="" checked id="fur-empty">
                                        <label for="fur-empty">Любые</label>
                                    </div>

                                    @foreach(Fur::cases() as $fur)
                                        <div class="radio-item">
                                            <input type="radio" name="fur" id="{{ $fur->value }}"
                                                   value="{{ $fur->getFilterLabel() }}" @checked(request('fur') === $fur->getFilterLabel())>
                                            <label for="{{ $fur->value }}">{{ $fur->getFilterLabel() }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="filter-buttons">
                        <button class="button filter-submit-button" type="submit">Показать</button>
                        <input class="button filter-reset-button" type="reset" value="Сбросить" onclick="location.href = @js(request()->path())">
                    </div>
                </div>
            </form>
        </div>

        <ul class="list">
            @if(true)
                <li class="list-item card add-card">
                    <a class="add-card-link" href="{{ route('pigs.show.create') }}" draggable="false">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path
                                d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                        </svg>
                        <p class="add-card-link-text">Добавить свинку</p>
                    </a>
                </li>
            @endif

            @foreach($pigs as $pig)
                <li class="list-item card @if(true) can-edit @endif">
                    @if(true)
                        <a class="edit-icon-link" href="{{ route('pigs.show.update', compact('pig')) }}"
                           draggable="false">
                            <img src="{{ asset('images/icons/edit.svg') }}" alt="" draggable="false">
                        </a>
                    @endif

                    <a href="{{ route('pigs.one', compact('pig')) }}">
                        <img class="card-image"
                             src="{{ $pig->mainImage?->getFullUrl() ?? FileHelper::getDefaultImage($pig) }}"
                             width="350" height="250" alt="Фотография морской свинки по имени {{ $pig->name }}">
                        <div class="card-bio">
                            <h2 class="card-title">{{ $pig->name }}</h2>
                            <p class="card-age">{{ $pig->age ?? 'Возраст неизвестен' }}</p>

                            @if($pig->city)
                                <p class="card-city">Находится
                                    в {{ LinguisticsHelper::getCityLocativeForm($pig->city->name) }}</p>
                            @endif

                            @if($pig->companion || $pig->companionOf)
                                <p class="card-companion">Пристраивается с другом</p>
                            @endif
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

        .page-header {
            width: 100%;
            height: 40vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-image: url("{{ asset('images/dots.jpg') }}");
            background-size: 25%;
            box-shadow: 0 4px 4px 0 var(--shadow-drop);
        }

        @media (max-width: 768px) {
            .page-header {
                height: 50dvh;
                background-size: 50%;
            }
        }

        .page-header-text {
            padding: 1.5rem;
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
            margin: 0;
            font-family: 'overdoze sans', sans-serif;
            font-size: 2.5rem;
            text-transform: lowercase;
        }

        @media (max-width: 768px) {
            .page-header-text > h1 {
                font-size: 1.875rem;
            }

            .page-header-text > p {
                font-size: 1.25rem;
            }
        }

        .list-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 4rem 1rem 1rem;
            row-gap: 5rem;
        }

        /** Filter button **/
        .list-header {
            position: relative;
            width: fit-content;
        }

        .list-filter-button {
            width: 25vw;
            min-width: 300px;
            height: 7.25vh;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            column-gap: 2rem;
            font-size: 2rem;
        }

        .list-filter-button::before {
            content: "";
            display: inline-flex;
            width: 35px;
            height: 35px;
            background-image: url({{ asset('images/icons/filter-icon.svg') }});
            background-repeat: no-repeat;
        }

        .list-filter-button + .filter-count {
            position: absolute;
            padding: 0.25rem 0.75rem;
            top: -0.75rem;
            right: -0.5rem;
            color: white;
            font-family: inherit;
            font-size: 1.25rem;
            background: var(--holiday-red);
            border-radius: 50%;
            border: 1px solid var(--main_font);
            cursor: default;
            user-select: none;
        }

        /** Filter window **/
        #filter_window {
            height: fit-content;
            max-height: 90dvh;
            display: flex;
            flex-direction: column;
            row-gap: 1rem;
            overflow-y: auto;
            overscroll-behavior-y: contain;
        }

        @media (max-width: 768px) {
            #filter_window {
                padding: 1.5rem;
            }
        }

        #filter_window .divider {
            width: 100%;
            height: 1px;
            margin: 0;
            border: none;
            border-bottom: 1px solid var(--main_font);
        }

        .filter-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            row-gap: 2rem;
        }

        .filter-container .filter-input-container {
            flex-basis: 100%;
        }

        .filter-input-container label {
            font-size: 1.25rem;
        }

        .filter-container .filter-input-container.has-select {
            flex-grow: 1;
        }

        .filter-container fieldset {
            width: fit-content;
            margin: 0;
            padding: 0;
            border: none;
        }

        .filter-container fieldset > legend {
            width: 75%;
            margin-bottom: 0.25rem;
            line-height: 1.75;
            border-bottom: 1px solid var(--main_font_trp);
        }

        .filter-container fieldset .radio-group {
            margin-left: 6px;
        }

        .filter-container .select-input {
            padding: 0.5rem;
            box-shadow: 0 4px 14px 0 #0000001A;
        }

        #filter_window .select-input .select-input__option {
            font-size: 1.25rem;
        }

        .filter-buttons {
            margin-top: 2rem;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            column-gap: 2.5rem;
            row-gap: 0.75rem;
            justify-content: center;
            place-self: center;
        }

        .filter-reset-button {
            background-color: var(--button-gray);
        }

        /** List **/
        .list {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            max-width: 90vw;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .list-item.card {
            display: flex;
            flex-direction: column;
            width: 350px;
            height: 430px;
            background-color: var(--light_blue);
            border-radius: 1rem;
            box-shadow: 0 4px 4px 0 var(--shadow-drop);
            cursor: pointer;
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
            height: 250px;
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
            display: flex;
            flex-direction: column;
            padding: 0.25rem 1rem 1rem;
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
            top: 0.5rem;
            right: 0.5rem;
            background-color: var(--light_pink);
            border-radius: 0.5rem;
            user-select: none;
        }

        .edit-icon-link img {
            width: 100%;
            height: 100%;
            box-shadow: 0 4px 4px 0 var(--shadow-drop);
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
