@extends('layouts.main', ['background' => 'texture-light'])

@section('title')
    Свинки
@endsection

@php
    /** @var \Illuminate\Support\Collection|iterable<\App\Models\Pig> $pigs */
@endphp

@section('content')
    <div class="list-container">
        <div class="list-header">
            <button class="list-filter-button" type="button">Фильтры</button>
        </div>
        <ul class="list">
            @foreach($pigs as $pig)
                <li class="list-item card">
                    <a href="{{ route('pigs.show.update', compact('pig')) }}">
                        <img class="card-image" src="{{ $pig->mainImage?->getFullUrl() ?? \App\Helpers\FileHelper::getDefaultImage($pig) }}"
                                    width="350" height="250" alt="Фотография морской свинки по имени {{ $pig->name }}">
                        <div class="card-bio">
                            <h2 class="card-title">{{ $pig->name }}</h2>
                            <p class="card-age">{{ $pig->age ?? 'Возраст неизвестен' }}</p>

                            @if($pig->city)
                                <p class="card-city">Находится
                                    в {{ \App\Helpers\LinguisticsHelper::getCityLocativeForm($pig->city->name) }}</p>
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
        .list-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 4rem 1rem 1rem;
            row-gap: 5rem;
        }

        .list-header {
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
            text-transform: uppercase;
            font-family: inherit;
            font-size: 2rem;
            background-color: #C3E9EA;
            border: solid 2px #000000;
            border-radius: 1rem;
            cursor: pointer;
        }

        .list-filter-button::before {
            content: "";
            display: inline-flex;
            width: 35px;
            height: 35px;
            background-image: url({{ asset('images/filter-icon.svg') }});
            background-repeat: no-repeat;
        }

        .list {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            max-width: 75vw;
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
            box-shadow: 0 4px 4px 0 #00000040;
            cursor: pointer;
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
            width: 350px;
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
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
    </style>
@endsection
