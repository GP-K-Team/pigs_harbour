@extends('layouts.main', ['background' => 'texture-light'])

@section('title')
    Морские свинки в добрые руки
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
    /** @var bool $isAdmin */
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bread-crumbs.css') }}">
@endpush

@push('js')
    <script type="module" src="{{ Vite::asset('resources/js/select-input.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/filter.js') }}"></script>
    <script type="module" src="{{ Vite::asset('resources/js/catalog-initialize.js') }}"></script>
@endpush

@section('content')
    @include('components.banner', ['showPigs' => false, 'specialHeader' => 'Морские свинки в добрые руки', 'specialText' => 'Выберите себе милого друга'])

    <div class="catalog_wrapper">
        <div class="bread-crumbs">
            <ul>
                <li><a href="/">Главная</a></li>
                <li>Ищут дом</li>
            </ul>
        </div>

        <div class="list-container">
            <div class="list-header">
                <button class="button list-filter-button" type="button"
                        onclick="$('#filter_window').closest('.window-container').show()">
                    Фильтры
                </button>
                @if($filterCount = count(array_filter($filters)))
                    <sup class="filter-count">{{ $filterCount }}</sup>
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
                                        <option value="{{ LinguisticsHelper::transliterate($city) }}" @selected(isset($filters['city']) && $filters['city'] === $city)>
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
                                            <input type="radio" name="sex" value="" @checked(empty($filters['sex'])) id="sex-empty">
                                            <label for="sex-empty">Любой</label>
                                        </div>

                                        @foreach(Sex::cases() as $sex)
                                            <div class="radio-item">
                                                <input type="radio" name="sex" id="{{ $sex->value }}" value="{{ $sex->getFilterValue() }}" @checked(isset($filters['sex']) && $filters['sex'] === $sex)>
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
                                                <input type="radio" name="age" id="{{ $age->value }}" value="{{ LinguisticsHelper::transliterate($age->getFilterLabel()) }}" @checked(isset($filters['age']) && $filters['age'] === $age)>
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
                                                <input type="radio" name="fur" id="{{ $fur->value }}" value="{{ LinguisticsHelper::transliterate($fur->getFilterLabel()) }}" @checked(isset($filters['fur']) && $filters['fur'] === $fur)>
                                                <label for="{{ $fur->value }}">{{ $fur->getFilterLabel() }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="filter-buttons">
                            <button class="button filter-submit-button" type="submit">
                                Показать
                            </button>
                            <input class="button filter-reset-button" type="reset" value="Сбросить" onclick="location.href = @js(route('pigs.catalog'))">
                        </div>
                    </div>
                </form>
            </div>

            @if($pigs->isEmpty())
                <h3>Нет результатов</h3>
            @else
                <ul class="list">
                    @if($isAdmin)
                        <li class="list-item card add-card">
                            <a class="add-card-link" href="{{ route('pigs.show.create') }}" draggable="false">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                    <path d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                                </svg>
                                <p class="add-card-link-text">Добавить свинку</p>
                            </a>
                        </li>
                    @endif

                    @foreach($pigs as $pig)
                        <li @class(['can-edit' => $isAdmin, 'card-pink' => $pig->sex === Sex::FEMALE, 'list-item', 'card'])>
                            @if($isAdmin)
                                <a class="edit-icon-link" href="{{ route('pigs.show.update', compact('pig')) }}" draggable="false">
                                    <img src="{{ asset('images/icons/edit.svg') }}" alt="Иконка редактирования карточки" draggable="false">
                                </a>
                            @endif

                            <a href="{{ route('pigs.one', compact('pig')) }}">
                                <img class="card-image"
                                     src="{{ asset($pig->mainImage?->getFullUrl() ?? FileHelper::getDefaultImage($pig)) }}"
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
            @endif

            @if ($pigs->currentPage() !== $pigs->lastPage())
                <div class="button show_more_button">
                        <a href="{{ '?show_more=' . ($showMore + 1) }}">
                            Смотреть всех
                        </a>
                </div>
            @endif

            @if($pigs->total() > 1 && $pigs->lastPage() !== 1)
                <div class="pagination_wrapper">
                    <ul class="pagination_list">
                        <li @class(['item_active' => $pigs->currentPage() === 1])>
                            <a href="?page=1">
                                1
                            </a>
                        </li>

                        @if($pigs->lastPage() > 2)

                            @if($pigs->currentPage() !== 1 && $pigs->currentPage() - 1 !== 1 && $pigs->currentPage() !== $pigs->lastPage())
                                <li>
                                    <a href="{{ $pigs->previousPageUrl() }}">
                                        {{ $pigs->currentPage() - 1 }}
                                    </a>
                                </li>
                            @endif

                            @if($pigs->currentPage() === 1)
                                    <li>
                                        <a href="{{ $pigs->nextPageUrl() }}">
                                            {{ $pigs->currentPage() + 1 }}
                                        </a>
                                    </li>
                                @elseif($pigs->currentPage() === $pigs->lastPage())
                                    <li>
                                        <a href="{{ $pigs->previousPageUrl() }}">
                                            {{ $pigs->lastPage() - 1 }}
                                        </a>
                                    </li>
                                @else
                                    <li @class(['item_active'])>
                                        <a>
                                            {{ $pigs->currentPage()}}
                                        </a>
                                    </li>
                            @endif

                            @if($pigs->currentPage() !== 1 && $pigs->currentPage() + 1 !== $pigs->lastPage() && $pigs->currentPage() !== $pigs->lastPage())
                                <li>
                                    <a href="{{ $pigs->nextPageUrl() }}">
                                        {{ $pigs->currentPage() + 1 }}
                                    </a>
                                </li>
                            @endif
                        @endif

                        <li @class(['item_active' => $pigs->currentPage() === $pigs->lastPage()])>
                            <a href="{{ "?page=" . $pigs->lastPage()  }}">
                                {{ $pigs->lastPage() }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="footer_block">
        <div class="footer_text">
            <p>
                На нашей Пристани временно обрели пристанище очаровательные морские свинки, мечтающие о любящей семье.
                Эти маленькие пушистые комочки энергии ищут добрые руки, готовые подарить им тепло, заботу и
                безграничную любовь. Мы приютили их, чтобы дать им шанс на счастливую жизнь, полную радости и вкусной
                еды.
            </p>
            <p>
                Каждая свинка обладает своим уникальным характером и очарованием. Есть среди них робкие и застенчивые,
                нуждающиеся в терпеливом подходе и ласковом слове. Другие, наоборот, смелые и любопытные, готовые
                исследовать каждый уголок своего нового дома. Все они без исключения нуждаются в заботе, внимании и
                регулярном общении.
            </p>
            <p>
                Мы отдаем морских свинок бесплатно, но с обязательным условием: они должны попасть в добрые руки, где их
                будут любить и заботиться о них. Мы хотим убедиться, что новые владельцы готовы обеспечить им просторную
                клетку, хороший корм и вкусное сено. Для этого мы просим заполнить нашу анкету.
            </p>
            <p>
                Если вы мечтаете о верном и преданном друге, который будет радовать вас своим забавным поведением и
                милым видом, морская свинка – идеальный выбор. Подарите этим маленьким созданиям дом, и они отплатят вам
                безграничной любовью и преданностью. Свяжитесь с нами, чтобы узнать больше о наших подопечных. Мы
                уверены, что среди них найдется именно та свинка, которая покорит ваше сердце!
            </p>
        </div>
    </div>

    @include('components.summary')

    <style>
        .catalog_wrapper {
            position: relative;
            overflow: hidden;
            min-height: 800px;
        }

        .catalog_wrapper:before,
        .catalog_wrapper:after {
            content: '';
            position: absolute;
            z-index: 0;
        }

        .catalog_wrapper:before {
            top: 20%;
            left: 10%;
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

        .catalog_wrapper:after {
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

        .button {
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
            z-index: 3;
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
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-image: url("{{ asset('images/dots.jpg') }}");
            background-size: 25%;
            box-shadow: 0 4px 4px 0 var(--shadow_drop);

            @media (max-width: 1000px) {
                min-height: 300px;
            }
        }

        .footer_block {
            padding: 40px;
            border-top: 10px solid var(--main_pink);
            background-image: url("/images/texture-light.png");
        }

        .footer_text {
            display: flex;
            flex-direction: column;
            row-gap: 25px;
            font-size: 25px;
            text-align: justify;

            @media (max-width: 768px) {
                font-size: 15px;
            }
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
            background: var(--holiday_red);
            border-radius: 50%;
            border: 1px solid var(--main_font);
            cursor: default;
            user-select: none;
            z-index: 4;
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
            background-color: var(--button_gray);
        }

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
            padding: 0 1rem 1rem;
            row-gap: 5rem;
        }

        .list {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            max-width: 90vw;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .list {
                flex-direction: column;
            }
        }

        .list-item.card {
            display: flex;
            flex-direction: column;
            width: 350px;
            height: 430px;
            background-color: var(--light_blue);
            border-radius: 1rem;
            box-shadow: 0 4px 4px 0 var(--shadow_drop);
            cursor: pointer;
            transition: 250ms;
        }

        .card:hover {
            opacity: 0.9;
            scale: 1.01;
            transition: 250ms;
        }

        .card a {
            color: var(--main_font) !important;
        }

        .card p {
            margin: 0;
            padding: 0;
            font-size: 1.25rem;
            will-change: transform, opacity;
        }

        .list-item.card.card-pink {
            background-color: var(--light_pink);
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

        @media (max-width: 1200px) {
            .card.add-card {
                height: 250px;
                align-self: flex-start;
            }

            .add-card-link-text {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .card.add-card {
                height: max-content;
                align-self: unset;
            }
        }

        .card-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            will-change: transform, opacity;
        }

        @media (max-width: 768px) {
            .card-image {
                height: 200px;
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
            z-index: 5;
        }

        .edit-icon-link img {
            width: 100%;
            height: 100%;
            box-shadow: 0 4px 4px 0 var(--shadow_drop);
            border-radius: 10px;
        }

        .edit-icon-link:hover {
            background-color: var(--pale_yellow);
        }

        .card.add-card {
            background-color: var(--light_blue);
        }

        .card.add-card:hover {
            background-color: #FFFFFF;
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
            color: var(--main_green);
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

        /** Page footer **/
        .footer_block {
            padding: 40px;
            border-top: 10px solid var(--main_pink);
            background-image: url("/images/texture-light.png");
        }

        .footer_text {
            display: flex;
            flex-direction: column;
            row-gap: 25px;
            font-size: 1.5rem;
            text-align: justify;

            @media (max-width: 768px) {
                font-size: 1rem;
            }
        }

        .pagination_list {
            display: flex;
            column-gap: 20px;
        }

        .pagination_list li {
            padding: 10px 20px;
            font-size: 25px;
            cursor: pointer;
            border-radius: 50%;

            @media (max-width: 1000px) {
                font-size: 15px;
            }
        }

        .pagination_list li:hover a {
            color: var(--main_blue);
        }

        .item_active {
            background-color: var(--light_blue);
        }

        .pagination_list .item_active:hover a {
            color: var(--main_font);
        }
    </style>
@endsection
