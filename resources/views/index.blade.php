@extends('layouts.main')

@push('js')
    @vite('resources/js/splide.js')
    @vite('resources/js/main-animation.js')
@endpush

@section('title')
    Главная
@endsection

@section('content')
    @include('components.banner')
    @include('components.badge')

    <div class="animated-block">
        @include('components.main_pigs')
    </div>

    <div class="animated-block">
        @include('components.steps')
    </div>

    <div class="animated-block">
        @include('components.main_articles')
    </div>

    @include('components.summary')
@endsection

@prepend('styles')
    <style>
        .landing_wrapper {
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .landing_header {
            margin-top: 0;
            margin-bottom: 3.75rem;
            font-family: '315karusel', sans-serif;
            font-size: 3.125rem;
            text-align: center;
        }

        .landing_header:hover {
            color: var(--dark_blue_font);
        }

        .landing_header:active {
            color: rgb(from var(--dark_blue_font) r g b / 50%);
        }

        .landing_button {
            width: 90%;
            max-width: 215px;
            margin: 40px 0 0;
            padding-left: 0;
            padding-right: 0;
            display: block;
            text-align: center;
            z-index: 5;
        }

        @media screen and (max-width: 768px) {
            .landing_wrapper {
                padding: 1.25rem 0;
            }

            .landing_header {
                margin-bottom: 1.75rem;
                font-size: 1.5rem;
            }

            .landing_button {
                max-width: 300px;
            }
        }

        @media screen and (max-width: 1200px) {
            .landing_header {
                margin-bottom: 2.5rem;
                font-size: 2.5rem;
            }
        }

        .animated-block {
            opacity: 0;
            translate: -30%;
            transition-duration: 700ms;
            transition-property: opacity, translate;

            @media (max-width: 768px) {
                opacity: 1;
                translate: initial;
            }
        }

        .animated-block:nth-child(odd) {
            translate: 130%;

            @media (max-width: 768px) {
                opacity: 1;
                translate: initial;
            }
        }

        .animated-block.active {
            opacity: 1;
            translate: 0;
        }
    </style>
@endprepend
