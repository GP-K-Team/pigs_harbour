@props([
    'showPigs' => true,
    'specialHeader',
    'specialText',
    'imageSrc',
    'imageCaption',
])

<div class="banner_wrapper">
    <div @class(['with_pigs' => $showPigs, "banner_text_wrapper"])>
        @if($showPigs)
            <div class="banner_main_text_wrapper">
                <h1>Пристань <br> пушистых сердец</h1>
                <p class="special_text">
                    Группа помощи морским <br>свинкам
                </p>
            </div>
        @elseif (isset($imageSrc))
            <div class="banner_image">
                <img src="{{'/images/' . $imageSrc }}" alt="{{ $imageCaption ?? '' }}">
            </div>
        @else
            <div class="banner_side_text_wrapper">
                <h1>{{ $specialHeader }}</h1>
                @if(isset($specialText))
                    <p class="special_text">
                        {{ $specialText }}
                    </p>
                @endif
            </div>
        @endif
    </div>
    @if ($showPigs)
        <div class="pigs_banner">
            <img src="/images/3_pigs.svg">
        </div>
    @endif
</div>

<style>
    .banner_wrapper {
        position: relative;
        margin: 0 auto;
        width: 100%;
        display: flex;
        align-items: center;
        min-height: 500px;
        background-image: url("/images/header_background.png");
        background-size: cover;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
    }

    .banner_text_wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        min-height: 50%;
        background: rgba(255, 255, 255, 0.8);
    }

    .banner_text_wrapper.with_pigs {
        width: 50%;
    }

    .banner_main_text_wrapper {
        text-align: center;
    }

    .banner_main_text_wrapper h1,
    .banner_side_text_wrapper h1 {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        font-weight: bold;
    }

    .banner_side_text_wrapper {
        width: 100%;
        min-height: 50%;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        text-align: center;
    }

    .pigs_banner {
        position: absolute;
        right: 0;
        bottom: -15%;
        width: 40%;
        z-index: 5;

        @media (max-width: 768px) {
            z-index: 1;
        }
    }

    .pigs_banner img {
        width: 100%;
    }

    .special_text {
        font-family: 'overdoze sans', sans-serif;
        font-size: 40px;
    }

    .banner_image {
        margin: auto;
        display: flex;
        justify-content: center;
    }

    @media (min-width: 1400px) {
        .pigs_banner {
            right: 10%;
            width: 600px;
        }
    }

    @media (max-width: 1000px) {
        .banner_main_text_wrapper h1 {
            font-size: 35px;
        }

        .special_text {
            font-size: 30px;
        }

        .banner_image img {
            max-width: 50%;
        }

    }

    @media (max-width: 768px) {
        .banner_wrapper {
            min-height: 300px;
        }

        .banner_text_wrapper.with_pigs  {
            width: 100%;
        }

        .pigs_banner {
            bottom: -55%;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .pigs_banner img {
            width: 300px;
        }

        .banner_main_text_wrapper h1 {
            font-size: 25px;
        }

        .special_text {
            font-size: 20px;
        }
    }
</style>
