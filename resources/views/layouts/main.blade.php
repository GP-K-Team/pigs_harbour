<!doctype html>
<html lang="ru">
    <head>
        <title>@yield('title') &mdash; Пристань Пушистых Сердец</title>
        <meta name="authors" content="whatevernumber, the_nepodarok" />
        <meta name="keywords" content="морские свинки, пристань пушистых сердец, помощь животным, волонтёрский проект">
        <meta name="viewport" content="width=device-width" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')

        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
        <link rel="manifest" href="/site.webmanifest" />
        <meta name="apple-mobile-web-app-title" content="Пристань Пушистых Сердец" />
    </head>

    <body>
        <header>
           @include('components.main_nav')
        </header>

        <main class="main {{ isset($background) ? "bg-$background" : '' }}">
            @yield('content')
        </main>

        <footer>
            <div class="footer_logo_wrapper">
                <a href="{{ route('home') }}">
                    <img src="/images/logo.svg" alt="Логотип пристани" width="80">
                </a>
            </div>
            <div class="footer_links">
                <div class="links">
                    @include('components.links')
                </div>
                <div class="footer_small_logo_wrapper">
                    <a href="{{ route('home') }}">
                        <img src="/images/logo.svg" alt="Логотип пристани">
                    </a>
                    <p>Пристань пушистых сердец  | {{ now()->year }}</p>
                </div>
            </div>
        </footer>

        @stack('js')

        <script type="module">
            $(document).ready(function () {
                $(document).on('click', function (e) {
                    if (!$('.window-container').length) {
                        return;
                    }

                    if (!$(e.target).closest('.window').length) {
                        $(e.target).closest('.window-container').hide();
                    }
                });

                $('.window-close-button').on('click', function () {
                    $(this).closest('.window-container').hide();

                    return false;
                });
            });
        </script>
    </body>
</html>

<style>
    html {
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
        height: calc(100vh);
        margin: 0;
        padding: 0;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        font-family: Nunito, Arial, sans-serif;
        color: var(--main_font);
        overflow-x: hidden;
    }

    html, body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    main {
        margin: 0 auto;
        display: flex;
        width: 100%;
        flex-direction: column;
        max-width: 1400px;
        flex-grow: 1;
    }

    header {
        margin: auto;
        position: relative;
        width: 100%;
        max-width: 1400px;
        height: 80px;
        min-height: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: var(--main_blue);
        font-size: 18px;
        /*box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06), 0 2px 6px rgba(0, 0, 0, 0.06), 0 0 1px rgba(0, 0, 0, 0.06);*/
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        z-index: 2;
    }

    footer {
        padding: 20px 40px;
        margin: auto;
        width: 100%;
        max-width: 1400px;
        min-height: 120px;
        background-color: var(--light_blue);
        display:flex;
        justify-content: space-between;
        align-items: center;
        border-top: 10px solid var(--main_blue);
        box-sizing: border-box;

        @media (max-width: 768px) {
            justify-content: center;
        }
    }

    footer p {
        margin: 0;
    }

    .footer_small_logo_wrapper {
        display: flex;
        align-items: center;
        column-gap: 10px;
    }

    .footer_small_logo_wrapper a {
        display: none;

        @media (max-width: 768px) {
            display: block;
        }
    }

    .footer_small_logo_wrapper img {
        width: 40px;

        @media (max-width: 400px) {
            width: 20px;
        }
    }

    .footer_links {
        display: flex;
        column-gap: 20px;
        align-items: center;

        @media (max-width: 768px) {
            flex-direction: column;
            row-gap: 10px;
        }
    }

    @media (max-width: 768px) {
        .footer_logo_wrapper {
            display: none;
        }
    }

    .container {
        width: 100%;
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    a {
        color: var(--main_font);
        text-decoration: none;
    }

    a:hover {
        color: var(--dark_blue_font);
    }

    a:active {
        color: var(--main_blue);
    }

    ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }
</style>
