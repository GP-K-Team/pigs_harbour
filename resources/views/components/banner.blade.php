<div class="banner_wrapper">
    <div class="banner_text_wrapper">
        <div class="banner_main_text_wrapper">
            <h1>Пристань <br> пушистых сердец</h1>
            <p class="special_text">
                Группа помощи морским <br>свинкам
            </p>
        </div>
    </div>
    <div class="pigs_banner">
        <img src="/images/3_pigs.svg">
    </div>
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
        width: 50%;
        background: rgba(255, 255, 255, 0.8);
    }

    .banner_main_text_wrapper {
        font-family: '315karusel', sans-serif;
        text-align: center;
    }

    .banner_main_text_wrapper h1 {
        font-size: 50px;
        font-weight: bold;
    }

    .pigs_banner {
        position: absolute;
        right: 0;
        bottom: -15%;
        width: 40%;
        z-index: 5;
    }

    .pigs_banner img {
        width: 100%;
    }

    .special_text {
        font-family: 'overdoze sans', sans-serif;
        font-size: 40px;
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
    }

    @media (max-width: 768px) {
        .banner_wrapper {
            min-height: 300px;
        }

        .banner_text_wrapper {
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
