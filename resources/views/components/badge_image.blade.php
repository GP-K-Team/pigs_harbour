@props([
    'src',
])

<div class="badge_image_block">
    <div class="badge_image_wrapper">
        <img src="/images/badge/{{$src}}" alt="Изображение со свинкой">
    </div>
    <div class="badge_image_caption">

    </div>
</div>

<style>
    .badge_image_block {
        display: flex;
        flex-direction: column;
        row-gap: 10px;
    }
</style>
