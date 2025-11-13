@php use App\Models\Article; @endphp
@props(['articleToDelete'])

@php
    /** @var <Article> $articleToDelete */
@endphp

<form class="delete-form" data-title="{{ $articleToDelete->title }}" method="POST" action="{{ route('blog.delete', ['article' => $articleToDelete]) }}">
    @method('DELETE')
    <div class="delete-button">
        <button class='delete-button-icon' type="submit">
            <img src="{{ asset('/images/icons/delete.png') }}" width="20" alt="иконка удаления">
        </button>
    </div>
    @csrf
</form>

<style>
    .delete-form {
        margin-bottom: 0;
    }

    .delete-button-icon {
        padding: 5px;
        height: 28px;
        background-color: var(--main-pink);
        border-radius: 0.5rem;
        border: none;
        user-select: none;
        cursor: pointer;

        @media (max-width: 768px) {
            top: unset;
            bottom: 15px;
            right: 0.5rem;
        }
    }

    .delete-button-icon img {
        width: 100%;
        height: 100%;
    }

    .delete-button-icon:hover {
        background-color: var(--holiday-red);
    }
</style>
