<div class="badge_wrapper">
    <div class="volunteer_message">
        <p>
            Мы — команда единомышленников, оказывающая помощь морским свинкам в беде. Мы даём им временный приют, лечим и находим новый уютный дом у любящих хозяев.
            Наши волонтеры есть в Москве, Санкт-Петербурге, Перми, Краснодаре и Вологде.
        </p>
        <div class="heart_icon_wrapper">
            <img src="/images/heart.png" alt="Иконка сердечка">
        </div>
    </div>
    <div class="badge_scheme_wrapper">
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_1.png']);
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_2.png']);
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_3.png']);
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_4.png']);
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_5.png']);
        </div>
    </div>
</div>

<style>
    .badge_wrapper {
        padding: 40px;
        background-image: url("/images/dark.jpg");
    }

    .volunteer_message {
        position: relative;
        width: 45%;
        padding: 20px;
        border-radius: 20px;
        text-align: justify;
        background-color: white;
        font-size: 25px;
    }

    .heart_icon_wrapper {
        position: absolute;
        right: -30px;
        bottom: -30px;
    }

    .heart_icon_wrapper img {
        width: 115px;
    }

    .badge_scheme_wrapper {
        min-height: 800px;
        position: relative;
        padding: 20px 0;
    }

    .badge_scheme_block {
        position: absolute;
    }

    .badge_scheme_block:nth-child(1) {
        top: 80px;
        left: 0;

        .badge_arrow {
            position: absolute;
            top: -20px;
            right: -220px;
        }
    }

    .badge_scheme_block:nth-child(2) {
        top: 180px;
        left: 350px;

        .badge_arrow {
            position: absolute;
            top: -20px;
            right: -220px;
            transform: scaleX(-1) rotate(214deg);
        }
    }

    .badge_scheme_block:nth-child(3) {
        top: -120px;
        right: 290px;

        .badge_arrow {
            position: absolute;
            right: -160px;
            bottom: -120px;
            transform: rotate(74deg);
        }
    }

    .badge_scheme_block:nth-child(4) {
        right: 110px;
        bottom: 170px;

        .badge_arrow {
            position: absolute;
            top: 60px;
            right: 250px;
            transform: scaleX(-1) rotate(24deg);
        }
    }

    .badge_scheme_block:nth-child(5) {
        right: 480px;
        bottom: -40px;
    }

    @media (max-width: 768px) {
        .badge_wrapper {
            padding-top: 150px;
        }

        .volunteer_message {
            width: auto;
            font-size: 15px;
        }
    }
</style>
