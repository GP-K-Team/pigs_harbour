<form class="logout-form" method="GET" action="{{ route('auth.logout') }}">
    <div class="logout-button">
        <button class='logout-button-icon' type="submit">
            <img src="{{ asset('/images/icons/logout-black.png') }}" width="20" alt="иконка выхода">
        </button>
    </div>
    @csrf
</form>

<style>
    .logout-form {
        margin-bottom: 0;
    }

    .logout-button-icon {
        padding: 5px;
        height: 28px;
        border-radius: 0.5rem;
        border: none;
        user-select: none;
        cursor: pointer;
        background-color: unset;

        @media (max-width: 768px) {
            top: unset;
            bottom: 15px;
            right: 0.5rem;
        }
    }

    .logout-button-icon:hover {
        opacity: 0.7;
    }
</style>
