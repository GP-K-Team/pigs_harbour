<!doctype html>
<html lang="ru">
    <head>
        <title>@yield('title')&mdash; Пристань Пушистых Сердец</title>
        <meta name="authors" content="whatevernumber, the_nepodarok" />
        <meta name="keywords" content="морские свинки, пристань пушистых сердец, помощь животным, волонтёрский проект">
        <meta name="viewport" content="width=device-width" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        </footer>
    </body>
</html>

<style>
    html {
        height: 100%;
    }

    body {
        margin: 0;
        padding: 0;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        font-family: Nunito, Arial, sans-serif;
        color: var(--main_font);
    }

    main {
        margin: 0 auto;
        width: 100%;
        max-width: 100vw;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    header {
        position: relative;
        width: 100%;
        height: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: var(--main_blue);
        font-size: 18px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06), 0 2px 6px rgba(0, 0, 0, 0.06), 0 0 1px rgba(0, 0, 0, 0.06);
    }

    footer {
        width: 100%;
        height: 80px;
        margin-top: auto;
        background-color: var(--light_blue);
        display:flex;
        justify-content: flex-start;
        align-items: center;
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

    ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }
</style>
