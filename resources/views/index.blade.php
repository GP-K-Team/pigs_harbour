@extends('layouts.main')

@push('js')
    @vite('resources/js/splide.js')
@endpush

@section('title')
    Главная
@endsection

@section('content')
    @include('components.banner')
    @include('components.badge')
    @include('components.main_pigs')
    @include('components.steps')
    @include('components.main_articles')
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
    </style>
@endprepend
