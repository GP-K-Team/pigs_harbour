@extends('layouts.main')

@section('title')
    Страница не найдена
@endsection

@section('content')
    @include('components.banner', ['showPigs' => false, 'imageSrc' => 'icons/404.png', 'imageCaption' => 'Ошибка 404'])

    <div class="main-banner">
        <div class="error-message">
            <h1>
                Страница не найдена
            </h1>
            <p>
                Ой, вы перешли по неправильной ссылке, или страница была удалена
            </p>
            <div class="home-button">
                <a href="{{ route('home') }}">
                    Главная
                </a>
            </div>
            <div class="additional-links">
                <div class="link_wrapper">
                    <a href="{{ route('catalog.index') }}">
                        Морские свинки в поиске дома
                    </a>
                </div>
                <div class="link_wrapper">
                    <a href="/blog/kak-vzyat">
                        Как взять морскую свинку у нас
                    </a>
                </div>
                <div class="link_wrapper">
                    <a href="{{ route('blog.index') }}">
                        Полезные статьи
                    </a>
                </div>
                <div class="link_wrapper">
                    <a href="/blog/o-nas">
                        О нас
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .main-banner {
        height: 100%;
        background-image: url('/images/texture-light.png');
    }

    .error-message {
        padding: 10px 0;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 20px;
        font-size: 25px;
        text-align: center;

        @media (max-width: 1000px) {
            font-size: 15px;
        }
    }

    .error-message h1 {
        font-size: 50px;

        @media (max-width: 1000px) {
            font-size: 25px;
        }
    }

    .additional-links {
        display: flex;
        flex-direction: column;
        row-gap: 10px;
        align-items: center;
        text-align: center;
    }

    .additional-links .link_wrapper {
        width: fit-content;
        padding: 2px 1px;
        border-bottom: 1px solid var(--main_font);
    }

    .link_wrapper {
        cursor: pointer;
    }

    .link_wrapper:hover, .link_wrapper:has(a:hover) {
        border-bottom: 1px solid var(--dark_blue_font);
    }

    .home-button {
        padding: 5px;
        border: 1px solid #000000;
        border-radius: 10px;
    }

    .home-button:hover {
        border-color: var(--dark_blue_font);
    }

    .home-button:hover a {
        color: var(--dark_blue_font);
    }
</style>
