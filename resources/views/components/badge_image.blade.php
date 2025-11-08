@props([
    'src',
    'desc',
])

<div class="badge_image_block">
    <div class="badge_image_wrapper">
        <img src="/images/badge/{{$src}}" alt="Изображение со свинкой">
    </div>
    <div class="badge_image_caption">
        <p>{{ $desc }}</p>
    </div>
</div>

<style>
    .badge_image_block {
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 10px;
    }

    .badge_image_block img {
        width: 250px;
    }

    .badge_image_caption {
        width: 200px;
        font-size: 25px;
        text-align: center;
    }

    /*@media (max-width: 1300px) {*/
    /*    .badge_image_block img {*/
    /*        width: 200px;*/
    /*    }*/
    /*}*/

    @media (max-width: 1000px) {
        .badge_image_caption {
            font-size: 15px;
        }

        .badge_image_block img {
            width: 140px;
        }
    }

    @media (max-width: 768px) {
        .badge_image_caption {
            width: 150px;
        }
    }
</style>
