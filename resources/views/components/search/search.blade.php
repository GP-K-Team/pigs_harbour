@props([
    'type' => null,
    'placeholder' => 'Поиск...',
    'buttonText' => 'Искать',
    'icon' => null,
])

<form class="search-form" method="GET" role="search">
    <input
        class="search-input"
        type="search"
        name="search_query"
        value="{{ request()->query('search_query')}}"
        placeholder="{{ $placeholder }}"
        aria-label="{{ $placeholder }}"
        @if($type) data-search-type="{{ $type }}" @endif
    >

    @if($icon)
        <img class="search-icon" src="{{ $icon }}" alt="" aria-hidden="true" draggable="false">
    @endif

    <button class="button search-button" type="submit">{{ $buttonText }}</button>
</form>

<style>
    .search-form {
        position: relative;
        display: flex;
        align-items: center;
        width: 90vw;
        max-width: 1080px;
        margin: 0 auto;
    }

    .search-input {
        width: 100%;
        padding: 10px clamp(190px, 23vw, 280px) 10px 32px;
        font-family: inherit;
        font-size: 1.25rem;
        color: var(--main-font);
        background-color: white;
        border: 2px solid var(--main-font);
        border-radius: 12px;
        box-shadow: 0 4px 4px 0 var(--shadow-drop);
    }

    .search-input::placeholder {
        color: rgb(from var(--main-font) r g b / 35%);
    }

    .search-input:focus {
        outline: 2px solid var(--main-blue);
        outline-offset: 2px;
    }

    .search-input::-webkit-search-cancel-button,
    .search-input::-webkit-search-decoration {
        appearance: none;
        -webkit-appearance: none;
    }

    .search-input::-ms-clear,
    .search-input::-ms-reveal {
        display: none;
        width: 0;
        height: 0;
    }

    .search-button {
        position: absolute;
        top: 2px;
        right: 2px;
        bottom: 2px;
        padding: 0 28px;
        font-size: 1.25rem;
        text-transform: uppercase;
        background-color: #C3E9EA;
        border: none;
        border-left: 2px solid var(--main-font);
        border-radius: 0 10px 10px 0;
        box-shadow: none;
    }

    .search-icon {
        position: absolute;
        top: -5px;
        right: 150px;
        width: 72px;
        height: 72px;
        object-fit: contain;
        transform: translateX(50%);
        filter: drop-shadow(0 2px 2px var(--shadow-drop));
        pointer-events: none;
        z-index: 2;
    }

    .search-button:hover {
        background-color: var(--main-green);
        color: var(--main-font);
    }

    @media (max-width: 768px) {
        .search-input {
            padding-right: 132px;
            padding-left: 16px;
            font-size: 1rem;
        }

        .search-button {
            min-width: 104px;
            padding: 0 16px;
            font-size: 1rem;
        }

        .search-icon {
            right: 110px;
            width: 62px;
            height: 62px;
        }
    }
</style>
