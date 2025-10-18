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
                <li class="list-item card @if(true) can-edit @endif">
                    @if(true)
                        <a class="edit-icon-link" href="{{ route('pigs.show.update', compact('pig')) }}" draggable="false">
                            <img src="{{ asset('images/icons/edit.svg') }}" alt="" draggable="false">
                        </a>
                    @endif

                    <a href="{{ route('pigs.one', compact('pig')) }}">
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

            @if(true)
                <li class="list-item card add-card">
                    <a class="add-card-link" href="{{ route('pigs.show.create') }}" draggable="false">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                        </svg>
                        <p class="add-card-link-text">Добавить свинку</p>
                    </a>
                </li>
            @endif
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
            background-image: url({{ asset('images/icons/filter-icon.svg') }});
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
            box-shadow: 0 4px 4px 0 #00000040;
        }

        .edit-icon-link:hover {
            background-color: var(--pale_yellow);
        }

        .card.add-card {
            background-color: var(--white-tpr);
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
        }

        .add-card-link:hover .add-card-link-text {
            visibility: visible;
        }
    </style>
@endsection
