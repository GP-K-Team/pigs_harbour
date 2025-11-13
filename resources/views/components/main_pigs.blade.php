@php
    use App\Models\Pig;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;

    /** @var Collection|iterable<Pig> $pigs */
@endphp

<div class="landing_wrapper pigs_wrapper">
    <h2 class="landing_header pigs_wrapper_header">
        <a href="{{ route('catalog.index') }}">Ищут дом →</a>
    </h2>

    <div class="list_wrapper">
        <ul class="list">
            @foreach($pigs as $pig)
                <li @class(['card-pink' => ($pig->sex->value === 'female'), 'list-item', 'card'])>
                    <a href="{{ route('catalog.one', compact('pig')) }}">
                        <img class="card-image"
                             src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
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

        <ul class="list list_mobile">
            @foreach($pigs->take(3) as $pig)
                <li class="list-item card">
                    <a href="{{ route('catalog.one', compact('pig')) }}">
                        <img class="card-image"
                             src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
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

        <section id="pigs_splide" class="splide pigs_splide_wrapper list_mobile_splide" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($pigs->take(3) as $pig)
                        <li class="splide__slide">
                            <div class="list-item card">
                                <a href="{{ route('catalog.one', compact('pig')) }}">
                                    <img class="card-image"
                                         src="{{ asset($pig->mainImage?->getFullUrl() ?? $pig::getDefaultImage()) }}"
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
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <a class="button landing_button catalog-button" href="{{ route('catalog.index') }}">
            Смотреть всех
        </a>

    </div>
</div>

<style>
    .pigs_wrapper {
        position: relative;
        overflow: hidden;
        min-height: 500px;
        background-image: url("/images/texture-light.png");
        border-top: 10px solid var(--pale-yellow);
    }

    .pigs_wrapper:before,
    .pigs_wrapper:after {
        content: '';
        position: absolute;
        z-index: 0;
    }

    .pigs_wrapper:before {
        top: 20%;
        left: 10%;
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

    .pigs_wrapper:after {
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

    .list_wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .list.list_mobile {
        display: none;
    }

    .list_mobile_splide {
        display: none;
        z-index: 5;
    }

    .list {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        max-width: 90vw;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        z-index: 5;
    }

    .list-item.card {
        display: flex;
        flex-direction: column;
        width: 350px;
        height: 430px;
        background-color: var(--light-blue);
        border-radius: 1rem;
        box-shadow: 0 4px 4px 0 var(--shadow-drop);
        cursor: pointer;
        z-index: 2;
        transition: 250ms;
    }

    @media (max-width: 1200px) {
        .list-item.card {
            width: 217px;
        }
    }

    @media (max-width: 768px) {
        .list-item.card {
            width: 90%;
            max-width: 400px;
            height: 380px;
            overflow: hidden;
        }
    }

    @media (max-width: 500px) {
        .list-item.card {
            max-width: 300px;
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

    .list-item.card.card-pink {
        background-color: var(--light-pink);
    }

    .card:hover {
        opacity: 0.9;
        scale: 1.01;
        transition: 250ms;
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

        .list {
            display: none;
        }

        .list_mobile_splide {
            display: block;
        }
    }

    @media (max-width: 500px) {
        .list.list_mobile {
            display: flex;
        }

        .list_mobile_splide {
            display: none;
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

    #pigs_splide-track + .splide__pagination {
        bottom: 2rem;
    }

    .splide__pagination__page.is-active {
        background-color: var(--main-pink);
    }

    .splide__pagination__page {
        background-color: var(--main-blue);
        opacity: 1;
    }

    .splide__slide {
        display: flex;
        justify-content: center;
        padding: 5px 0;
    }
</style>
