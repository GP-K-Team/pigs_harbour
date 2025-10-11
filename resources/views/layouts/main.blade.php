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
        display: flex;
        flex-direction: column;
        height: calc(100vh);
        margin: 0;
        padding: 0;
        background-color: #F0F8FF;
        font-family: Nunito, Arial, sans-serif;
        color: var(--main_font);
    }

    main {
        height: 100%;
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
