@php
    use App\Models\Pig;
    use App\Helpers\FileHelper;
    use App\Helpers\LinguisticsHelper;
    use Illuminate\Support\Collection;

    /** @var Collection|iterable<Pig> $pigs */
@endphp

<div class="pigs_wrapper">
    <h2 class="pigs_wrapper_header">Ищут дом →</h2>

    <div>
        <ul class="list">
            @foreach($pigs as $pig)
                <li class="list-item card">
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

        <ul class="list list_mobile">
            @foreach($pigs->take(3) as $pig)
                <li class="list-item card">
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

        <section id="pigs_splide" class="splide pigs_splide_wrapper list_mobile_splide" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($pigs->take(3) as $pig)
                        <li class="splide__slide">
                            <div class="list-item card">
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
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <div class="button catalog_button">
            <a href="{{ route('pigs.catalog') }}">
                Смотреть всех
            </a>
        </div>

    </div>
</div>

<style>
    .pigs_wrapper {
        padding: 40px;
        position: relative;
        overflow: hidden;
        min-height: 500px;
        background-image: url("/images/texture-light.png");
        border-top: 10px solid var(--pale_yellow);
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
        background-color: var(--pale_orange);

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
        background-color: var(--pale_yellow);

        @media (max-width: 768px) {
            bottom: 5%;
            right: -30%;
            height: 30vh;
            width: 30vh;
        }
    }

    .pigs_wrapper_header {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        text-align: center;

        @media (max-width: 1300px) {
            font-size: 25px;
        }
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
        background-color: var(--light_blue);
        border-radius: 1rem;
        box-shadow: 0 4px 4px 0 var(--shadow_drop);
        cursor: pointer;
        z-index: 2;
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

    .catalog_button {
        margin: 40px auto 20px;
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
        z-index: 4;

        @media (max-width: 450px) {
            font-size: 20px;
        }
    }

    .splide__pagination__page.is-active {
        background-color: var(--main_pink);
    }

    .splide__pagination__page {
        background-color: var(--main_blue);
        opacity: 1;
    }

    .splide__pagination {
        bottom: -20px;
    }

    .splide__slide {
        display: flex;
        justify-content: center;
        padding: 5px 0;
    }
</style>
