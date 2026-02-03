<!doctype html>
<html lang="ru">
    <head>
        @hasSection('full_title')
            <title>@yield('full_title')</title>
        @else
            <title>
                @yield('title')
                @unless(request()->is('blog/*'))&mdash;&nbsp;{{ config('app.name') }}@endunless
            </title>
        @endif

        <meta name="description" content="@yield('description')" />

        <meta property="og:title" content="@yield('og_title', 'Пристань пушистых сердец')">
        <meta property="og:image" content="@yield('og_image', '/images/logo.svg')">
        <meta property="og:site_name" content="Помощь бездомным морским свинкам">
        <meta property="og:type" content="{{ request()->routeIs('blog.*') ? 'article' : 'website' }}">

        <meta charset="UTF-8">
        <meta name="authors" content="whatevernumber, the_nepodarok" />
        <meta name="keywords" content="морские свинки, пристань пушистых сердец, помощь животным, волонтёрский проект">
        <meta name="viewport" content="width=device-width" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if(!\Illuminate\Support\Facades\App::environment('production'))
            <meta name="robots" content="noindex">
        @endunless

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function(m,e,t,r,i,k,a){
                m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
            })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=105505481', 'ym');

            ym(105505481, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/105505481" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <script src="https://vk.com/js/api/openapi.js?169" type="text/javascript"></script>

        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="apple-mobile-web-app-title" content="Пристань Пушистых Сердец">

        @stack('additionalHeader')
    </head>

    <body>
        <header>
           @include('components.main-nav')
        </header>

        <main class="main {{ isset($background) ? "bg-$background" : '' }}">
            @yield('content')
        </main>

        <footer>
            <div class="footer-logo-wrapper">
                <a href="{{ route('home') }}">
                    <img src="/images/logo.svg" alt="Логотип пристани" width="80">
                </a>
            </div>
            <div class="footer-links">
                <div class="links">
                    @include('components.links')
                </div>
                <div class="footer-small-logo-wrapper">
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
                        $(e.target).closest('.window-container').hide().trigger('close');
                    }
                });

                $('.window-close-button').on('click', function () {
                    $(this).closest('.window-container').hide().trigger('close');

                    return false;
                });
            });
        </script>

        <div id="vk_community_messages"></div>
        @vite('resources/js/widgets.js')
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
        font-family: Nunito, Arial, sans-serif;
        color: var(--main-font);
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
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
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
        background-color: var(--main-blue);
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
        background-color: var(--light-blue);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 10px solid var(--main-blue);
        box-sizing: border-box;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);

        @media (max-width: 768px) {
            justify-content: center;
        }
    }

    footer p {
        margin: 0;
    }

    .footer-small-logo-wrapper {
        display: flex;
        align-items: center;
        column-gap: 10px;
    }

    .footer-small-logo-wrapper a {
        display: none;

        @media (max-width: 768px) {
            display: block;
        }
    }

    .footer-small-logo-wrapper img {
        width: 40px;

        @media (max-width: 400px) {
            width: 20px;
        }
    }

    .footer-links {
        display: flex;
        column-gap: 20px;
        align-items: center;

        @media (max-width: 768px) {
            flex-direction: column;
            row-gap: 10px;
        }
    }

    @media (max-width: 768px) {
        .footer-logo-wrapper {
            display: none;
        }
    }

    .container {
        width: 100%;
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }
</style>
