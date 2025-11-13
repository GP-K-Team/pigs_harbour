@props([
    'src',
    'desc',
])

<div class="badge-image-block">
    <div class="badge-image-wrapper">
        <img src="/images/badge/{{$src}}" alt="Изображение со свинкой">
    </div>
    <div class="badge-image-caption">
        <p>{{ $desc }}</p>
    </div>
</div>

<style>
    .badge-image-block {
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 10px;
    }

    .badge-image-block img {
        width: 250px;
    }

    .badge-image-caption {
        width: 200px;
        font-size: 25px;
        text-align: center;
    }

    .badge-image-wrapper img{
        transition: transform 0.4s ease-in-out;
        animation: scale 3s ease-in-out infinite;
    }

    @keyframes scale {
        0% {
            transform: scale(1) translate(0);
        }
        50% {
            transform: scale(1.01) translate(2px);
        }
        100% {
            transform: scale(1) translate(0px);
        }
    }

    @media (max-width: 1000px) {
        .badge-image-caption {
            font-size: 15px;
        }

        .badge-image-block img {
            width: 140px;
        }
    }

    @media (max-width: 768px) {
        .badge-image-caption {
            width: 150px;
        }
    }
</style>
