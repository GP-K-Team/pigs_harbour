<div class="badge_wrapper">
    <div class="volunteer_message">
        <p>
            Мы — команда единомышленников, оказывающая помощь морским свинкам в беде. Мы даём им временный приют, лечим и находим новый уютный дом у любящих хозяев.
            Наши волонтеры есть в @foreach($cities as $index => $city){{ ($index === 0 ? '' : ', ') . \App\Helpers\LinguisticsHelper::getCityLocativeForm($city->name) }}@endforeach.
        </p>
        <div class="heart_icon_wrapper">
            <img src="/images/heart.png" alt="Иконка сердечка">
        </div>
    </div>
    <div class="badge_scheme_wrapper">
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_1.png', 'desc' => 'Принимаем морских свинок'])
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_2.png', 'desc' => 'Обрабатываем и лечим при необходимости'])
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_3.png', 'desc' => 'Подбираем новых хозяев'])
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_4.png','desc' => 'Отправляем в другие города'])
            <img class="badge_arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge_scheme_block">
            @include('components.badge_image', ['src' => 'badge_5.png', 'desc' => 'Остаемся на связи с новыми хозяевами'])
        </div>
    </div>
    <div class="banner_pig_image_wrapper">
        <img src="/images/banner_pig.png">
    </div>
</div>

<style>
    .badge_wrapper {
        position: relative;
        padding: 40px;
        background-image: url("/images/bright_dark.png");
        min-height: 1200px;
    }

    .volunteer_message {
        position: relative;
        width: 45%;
        padding: 30px 20px;
        border-radius: 20px;
        background-color: white;
        font-size: 25px;
    }

    .heart_icon_wrapper {
        position: absolute;
        right: -40px;
        bottom: -65px;
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

    .badge_arrow {
        position: absolute;
    }

    .banner_pig_image_wrapper {
        position: absolute;
        bottom: 20px;
        left: 0;
    }

    .banner_pig_image_wrapper img {
        width: 376px;
    }

    .badge_scheme_block:nth-child(1) {
        top: 80px;
        left: 0;

        .badge_arrow {
            top: -20px;
            right: -220px;
        }

        @media (max-width: 1000px) {
            .badge_arrow {
                right: -120px;
            }
        }

        @media (max-width: 768px) {
            .badge_arrow {
                top: 130px;
                right: 115px;
                transform: rotateZ(45deg);
            }
        }
    }

    .badge_scheme_block:nth-child(2) {
        top: 180px;
        left: 29%;

        .badge_arrow {
            top: -20px;
            right: -220px;
            transform: scaleX(-1) rotate(214deg);
        }

        @media (min-width: 1000px) and (max-width: 1300px) {
            .badge_arrow {
                top: 20px;
            }
        }

        @media (max-width: 1000px) {
            .badge_arrow {
                right: -120px;
            }
        }

        @media (max-width: 768px) {
            .badge_image_wrapper {
                order: 2;
            }

            .badge_image_caption {
                order: 1;
            }

            .badge_arrow {
                top: 125px;
                right: 115px;
                transform: rotateZ(318deg) scaleX(-1);
            }
        }
    }

    .badge_scheme_block:nth-child(3) {
        top: -70px;
        right: 18%;

        .badge_arrow {
            right: -200px;
            bottom: 30px;
            transform: rotate(46deg);
        }

        @media (min-width: 1000px) and (max-width: 1300px) {
            top: -170px;

            .badge_arrow {
                transform: rotate(72deg);
            }
        }

        @media (max-width: 1000px) {
            .badge_arrow {
                right: -120px;
            }
        }

        @media (max-width: 830px) {
            .badge_arrow {
                bottom: 0;
                transform: rotate(71deg);
            }
        }

        @media (max-width: 768px) {
            .badge_arrow {
                top: 130px;
                right: 115px;
                transform: rotateZ(45deg);
            }
        }
    }

    .badge_scheme_block:nth-child(4) {
        right: 0;
        bottom: 170px;

        .badge_arrow {
            top: 60px;
            right: 250px;
            transform: scaleX(-1) rotate(24deg);
        }

        @media (min-width: 1000px) and (max-width: 1300px) {
            bottom: 220px;

            .badge_arrow {
                top: 170px;
                transform: scaleX(-1) rotate(50deg);
            }
        }

        @media (max-width: 1000px) {
            .badge_arrow {
                right: 180px;
            }
        }

        @media (max-width: 830px) {
            .badge_arrow {
                top: 80px;
                right: 160px;
                transform: scaleX(-1) rotate(36deg);

            }
        }

        @media (max-width: 768px) {
            .badge_image_wrapper {
                order: 2;
            }

            .badge_image_caption {
                order: 1;
            }

            .badge_arrow {
                top: 125px;
                right: 115px;
                transform: rotateZ(318deg) scaleX(-1);
            }
        }
    }

    .badge_scheme_block:nth-child(5) {
        right: 31%;
        bottom: -40px;

        @media (min-width: 1000px) and (max-width: 1300px) {
            bottom: -170px;

            .badge_arrow {
                top: 150px;
            }
        }

        @media (max-width: 1000px) {
            right: 28%;
            bottom: 0;

            .badge_arrow {
                right: 170px;
            }
        }

        @media (max-width: 830px) {
            bottom: -10px;
        }

    }

    @media (max-width: 1300px) {
        .badge_wrapper {
            min-height: 1350px;
        }
    }

    @media (max-width: 1000px) {
        .badge_wrapper {
            min-height: 700px;
        }

        .badge_scheme_wrapper {
            min-height: 550px;
        }

        .badge_arrow {
            width: 150px;
        }

        .banner_pig_image_wrapper img {
            width: 270px;
        }
    }

    @media (max-width: 768px) {
        .badge_wrapper {
            padding-top: 200px;
            min-height: 1300px;
        }

        .badge_arrow {
            width: 70px;
        }

        .volunteer_message {
            width: calc(100% - 40px);
            font-size: 15px;
        }

        .heart_icon_wrapper {
            right: -20px;
            bottom: -30px;
        }

        .heart_icon_wrapper img {
            width: 71px;
        }

        .badge_scheme_wrapper {
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            row-gap: 10px;
        }

        .badge_scheme_block {
            top: unset !important;
            right: unset !important;
            left: unset !important;
            bottom: unset !important;
            position: relative;
        }

        .badge_image_block {
            display: flex;
            flex-direction: row;
            column-gap: 5px;
        }

        .banner_pig_image_wrapper {
            right: 0;
            left: unset;
        }

        .banner_pig_image_wrapper img {
            width: 240px;
            transform: scaleX(-1);
        }
    }

    @media (max-width: 500px) {
        .badge_wrapper {
            min-height: 1250px;
        }

        .banner_pig_image_wrapper img {
            width: 160px;
            transform: scaleX(-1);
        }
    }
</style>
