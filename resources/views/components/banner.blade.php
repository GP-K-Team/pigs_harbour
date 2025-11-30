@props([
    'showPigs' => true,
    'specialHeader',
    'specialSubHeader',
    'specialText',
    'imageSrc',
    'imageCaption',
])

<div class="banner-wrapper">
    <div @class(['with-pigs' => $showPigs, 'banner-text-wrapper'])>
        @if($showPigs)
            <div class="banner-main-text-wrapper">
                <h1>Пристань <br> пушистых сердец</h1>
                <p class="special-text">
                    Группа помощи морским <br>свинкам
                </p>
            </div>
        @elseif (isset($imageSrc))
            <div class="banner-image">
                <img src="{{'/images/' . $imageSrc }}" alt="{{ $imageCaption ?? '' }}">
            </div>
        @else
            <div class="banner-side-text-wrapper">
                <h1>
                    {{ $specialHeader }}
                    @if(isset($specialSubHeader))
                        <br>
                        {{ $specialSubHeader }}
                    @endif
                </h1>

                @if(isset($specialText))
                    <p class="special-text">
                        {{ $specialText }}
                    </p>
                @endif
            </div>
        @endif
    </div>
    @if ($showPigs)
        <div class="pigs-banner">
            <img src="/images/3_pigs.svg" alt="">
        </div>
    @endif
</div>

<style>
    .banner-wrapper {
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

    .banner-text-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        min-height: 50%;
        background: rgba(255, 255, 255, 0.8);
    }

    .banner-text-wrapper.with-pigs {
        width: 50%;
    }

    .banner-main-text-wrapper {
        text-align: center;
    }

    .banner-main-text-wrapper h1,
    .banner-side-text-wrapper h1 {
        padding: 10px 15px;
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        font-weight: bold;
    }

    .banner-side-text-wrapper {
        width: 100%;
        min-height: 50%;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        text-align: center;
    }

    .pigs-banner {
        position: absolute;
        right: 0;
        bottom: -15%;
        width: 40%;
        z-index: 5;

        @media (max-width: 768px) {
            z-index: 1;
        }
    }

    .pigs-banner img {
        width: 100%;
    }

    .special-text {
        font-family: 'overdoze sans', sans-serif;
        font-size: 40px;
    }

    .banner-image {
        margin: auto;
        display: flex;
        justify-content: center;
    }

    @media (min-width: 1400px) {
        .pigs-banner {
            right: 10%;
            width: 600px;
        }
    }

    @media (max-width: 1000px) {
        .banner-main-text-wrapper h1,
        .banner-side-text-wrapper h1 {
            padding: 5px 10px;
        }

        .banner-main-text-wrapper h1 {
            font-size: 35px;
        }

        .special-text {
            font-size: 30px;
        }

        .banner-image img {
            max-width: 50%;
        }

    }

    @media (max-width: 768px) {
        .banner-wrapper {
            min-height: 300px;
        }

        .banner-text-wrapper.with-pigs  {
            width: 100%;
        }

        .pigs-banner {
            bottom: -55%;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .pigs-banner img {
            width: 300px;
        }

        .banner-main-text-wrapper h1 {
            font-size: 25px;
        }

        .special-text {
            font-size: 20px;
        }

        .banner-side-text-wrapper h1 {
            font-size: 20px;
        }
    }
</style>
