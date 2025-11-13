<div class="badge-wrapper">
    <div class="volunteer-message">
        <p>
            Мы — команда единомышленников, оказывающая помощь морским свинкам в беде. Мы даём им временный приют, лечим
            и находим новый уютный дом у любящих хозяев.
            Наши волонтеры есть в @foreach($cities as $index => $city)
                {{ ($index === 0 ? '' : ', ') . \App\Helpers\LinguisticsHelper::getCityLocativeForm($city->name) }}
            @endforeach.
        </p>
        <div class="heart-icon-wrapper">
            <img src="/images/heart.png" alt="Иконка сердечка">
        </div>
    </div>
    <div class="badge-scheme-wrapper">
        <div class="badge-scheme-block">
            @include('components.badge-image', ['src' => 'badge_1.png', 'desc' => 'Принимаем морских свинок'])
            <img class="badge-arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge-scheme-block">
            @include('components.badge-image', ['src' => 'badge_2.png', 'desc' => 'Обрабатываем и лечим при необходимости'])
            <img class="badge-arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge-scheme-block">
            @include('components.badge-image', ['src' => 'badge_3.png', 'desc' => 'Подбираем новых хозяев'])
            <img class="badge-arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge-scheme-block">
            @include('components.badge-image', ['src' => 'badge_4.png','desc' => 'Отправляем в другие города'])
            <img class="badge-arrow" src="/images/badge/arrow.png" width="230px" alt="стрелочка">
        </div>
        <div class="badge-scheme-block">
            @include('components.badge-image', ['src' => 'badge_5.png', 'desc' => 'Остаемся на связи с новыми хозяевами'])
        </div>
    </div>
    <div class="banner-pig-image-wrapper">
        <img src="/images/banner_pig.png">
    </div>
</div>

<style>
    .badge-wrapper {
        position: relative;
        padding: 40px;
        background-image: url("/images/bright_dark.png");
        min-height: 1200px;
    }

    .volunteer-message {
        position: relative;
        width: 45%;
        padding: 30px 20px;
        border-radius: 20px;
        background-color: white;
        font-size: 25px;
    }

    .heart-icon-wrapper {
        position: absolute;
        right: -40px;
        bottom: -65px;
    }

    .heart-icon-wrapper img {
        width: 115px;
    }

    .badge-scheme-wrapper {
        min-height: 800px;
        position: relative;
        padding: 20px 0;
    }

    .badge-scheme-block {
        position: absolute;
    }

    .badge-arrow {
        position: absolute;
    }

    .banner-pig-image-wrapper {
        position: absolute;
        bottom: 20px;
        left: 0;
    }

    .banner-pig-image-wrapper img {
        width: 376px;
    }

    .badge-scheme-block:nth-child(1) {
        top: 80px;
        left: 0;

        .badge-arrow {
            top: -20px;
            right: -220px;
        }

        @media (max-width: 1000px) {
            .badge-arrow {
                right: -120px;
            }
        }

        @media (max-width: 768px) {
            .badge-arrow {
                top: 130px;
                right: 115px;
                transform: rotateZ(45deg);
            }
        }
    }

    .badge-scheme-block:nth-child(2) {
        top: 180px;
        left: 29%;

        .badge-arrow {
            top: -20px;
            right: -220px;
            transform: scaleX(-1) rotate(214deg);
        }

        @media (min-width: 1000px) and (max-width: 1300px) {
            .badge-arrow {
                top: 20px;
            }
        }

        @media (max-width: 1000px) {
            .badge-arrow {
                right: -120px;
            }
        }

        @media (max-width: 768px) {
            .badge-image-wrapper {
                order: 2;
            }

            .badge-image-caption {
                order: 1;
            }

            .badge-arrow {
                top: 125px;
                right: 115px;
                transform: rotateZ(318deg) scaleX(-1);
            }
        }
    }

    .badge-scheme-block:nth-child(3) {
        top: -70px;
        right: 18%;

        .badge-arrow {
            right: -200px;
            bottom: 30px;
            transform: rotate(46deg);
        }

        @media (min-width: 1000px) and (max-width: 1300px) {
            top: -170px;

            .badge-arrow {
                transform: rotate(72deg);
            }
        }

        @media (max-width: 1000px) {
            .badge-arrow {
                right: -120px;
            }
        }

        @media (max-width: 830px) {
            .badge-arrow {
                bottom: 0;
                transform: rotate(71deg);
            }
        }

        @media (max-width: 768px) {
            .badge-arrow {
                top: 130px;
                right: 115px;
                transform: rotateZ(45deg);
            }
        }
    }

    .badge-scheme-block:nth-child(4) {
        right: 0;
        bottom: 170px;

        .badge-arrow {
            top: 60px;
            right: 250px;
            transform: scaleX(-1) rotate(24deg);
        }

        @media (min-width: 1000px) and (max-width: 1300px) {
            bottom: 220px;

            .badge-arrow {
                top: 170px;
                transform: scaleX(-1) rotate(50deg);
            }
        }

        @media (max-width: 1000px) {
            .badge-arrow {
                right: 180px;
            }
        }

        @media (max-width: 830px) {
            .badge-arrow {
                top: 80px;
                right: 160px;
                transform: scaleX(-1) rotate(36deg);

            }
        }

        @media (max-width: 768px) {
            .badge-image-wrapper {
                order: 2;
            }

            .badge-image-caption {
                order: 1;
            }

            .badge-arrow {
                top: 125px;
                right: 115px;
                transform: rotateZ(318deg) scaleX(-1);
            }
        }
    }

    .badge-scheme-block:nth-child(5) {
        right: 31%;
        bottom: -40px;

        @media (min-width: 1000px) and (max-width: 1300px) {
            bottom: -170px;

            .badge-arrow {
                top: 150px;
            }
        }

        @media (max-width: 1000px) {
            right: 28%;
            bottom: 0;

            .badge-arrow {
                right: 170px;
            }
        }

        @media (max-width: 830px) {
            bottom: -10px;
        }

    }

    @media (max-width: 1300px) {
        .badge-wrapper {
            min-height: 1350px;
        }
    }

    @media (max-width: 1000px) {
        .badge-wrapper {
            min-height: 700px;
        }

        .badge-scheme-wrapper {
            min-height: 550px;
        }

        .badge-arrow {
            width: 150px;
        }

        .banner-pig-image-wrapper img {
            width: 270px;
        }
    }

    @media (max-width: 768px) {
        .badge-wrapper {
            padding-top: 200px;
            min-height: 1300px;
        }

        .badge-arrow {
            width: 70px;
        }

        .volunteer-message {
            width: calc(100% - 40px);
            font-size: 15px;
        }

        .heart-icon-wrapper {
            right: -20px;
            bottom: -30px;
        }

        .heart-icon-wrapper img {
            width: 71px;
        }

        .badge-scheme-wrapper {
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            row-gap: 10px;
        }

        .badge-scheme-block {
            top: unset !important;
            right: unset !important;
            left: unset !important;
            bottom: unset !important;
            position: relative;
        }

        .badge-image-block {
            display: flex;
            flex-direction: row;
            column-gap: 5px;
        }

        .banner-pig-image-wrapper {
            right: 0;
            left: unset;
        }

        .banner-pig-image-wrapper img {
            width: 240px;
            transform: scaleX(-1);
        }
    }

    @media (max-width: 500px) {
        .badge-wrapper {
            min-height: 1250px;
        }

        .banner-pig-image-wrapper img {
            width: 160px;
            transform: scaleX(-1);
        }
    }
</style>
