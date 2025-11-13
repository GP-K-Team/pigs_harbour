<div class="landing-wrapper steps-wrapper">
    <h2 class="landing-header steps-wrapper-header">
        <a href="/blog/kak-vzyat">Если вы хотите взять у нас свинку</a>
    </h2>

    <div class="steps-main-wrapper">
        <ul class="steps-list">
            <li class="step-detail">
                <p>
                    Выберите понравившуюся морскую свинку
                </p>
            </li>
            <li class="step-detail">
                <p>
                    Подготовьте условия, в которые вы хотите принять нашего подопечного
                </p>
            </li>
            <li class="step-detail">
                <p>
                    Напишите нам в группу VK, если у вас есть вопросы по содержанию
                </p>
            </li>
            <li class="step-detail">
                <p>
                    Заполните анкету и отправьте в личные сообщения группы в VK
                </p>
            </li>
            <li class="step-detail">
                <p>
                    Дождитесь одобрения анкеты
                </p>
            </li>
            <li class="step-detail">
                <p>
                    Договоритесь о встрече с волонтером и станьте счастливым свинородителем
                </p>
            </li>
        </ul>
    </div>


    <section id="steps_splide" class="splide steps-splide-wrapper" aria-label="6 шагов к морской свинке">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide">
                    <div class="step-detail">
                        <p>
                            Выберите понравившуюся морскую свинку
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step-detail">
                        <p>
                            Подготовьте условия, в которые вы хотите принять нашего подопечного
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step-detail">
                        <p>
                            Напишите нам в группу VK, если у вас есть вопросы по содержанию
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step-detail">
                        <p>
                            Заполните анкету и отправьте в личные сообщения группы в VK
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step-detail">
                        <p>
                            Дождитесь одобрения анкеты
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step-detail">
                        <p>
                            Договоритесь о встрече с волонтером и станьте счастливым свинородителем
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <div class="button landing-button steps-button">
        <a href="/blog/kak-vzyat">
            Подробнее
        </a>
    </div>
</div>

<style>
    .steps-wrapper {
        background-image: url("/images/bright_dark.png");
        border-top: 10px solid var(--pale-orange);
    }

    .steps-splide-wrapper {
        display: none;
    }

    @media (max-width: 768px) {
        .steps-main-wrapper {
            display: none;
        }

        .steps-splide-wrapper {
            display: block;
        }
    }

    @media (max-width: 500px) {
        .steps-main-wrapper {
            display: block;
        }

        .steps-splide-wrapper {
            display: none;
        }
    }

    .steps-list {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: center;
        row-gap: 40px;
        column-gap: 80px;
        flex-wrap: wrap;
    }

    .step-detail {
        position: relative;
        padding: 20px 20px 20px 40px;
        width: 267px;
        height: 143px;
        box-sizing: border-box;
        border-radius: 10px;

        @media (max-width: 1000px) {
            margin-left: 40px;
        }
    }

    .step-detail:before {
        content: "";
        position: absolute;
        width: 103px;
        height: 143px;
        top: 0;
        left: -65px;
    }

    .step-detail:nth-child(1),
    .steps-splide-wrapper li:nth-child(1) .step-detail {
        background-color: var(--darker-green);
    }

    .step-detail:nth-child(2),
    .steps-splide-wrapper li:nth-child(2) .step-detail {
        background-color: var(--main-pink);
    }

    .step-detail:nth-child(3),
    .steps-splide-wrapper li:nth-child(3) .step-detail {
        background-color: var(--main-blue);
    }

    .step-detail:nth-child(4),
    .steps-splide-wrapper li:nth-child(4) .step-detail {
        background-color: var(--bright-blue);
    }

    .step-detail:nth-child(5),
    .steps-splide-wrapper li:nth-child(5) .step-detail {
        background-color: var(--pale-orange);
    }

    .step-detail:nth-child(6),
    .steps-splide-wrapper li:nth-child(6) .step-detail {
        background-color: var(--pale-yellow);
    }

    .step-detail:nth-child(1):before,
    .steps-splide-wrapper li:nth-child(1) .step-detail:before {
        background-image: url("/images/steps/1.png");
    }

    .step-detail:nth-child(2):before,
    .steps-splide-wrapper li:nth-child(2) .step-detail:before {
        background-image: url("/images/steps/2.png");
    }

    .step-detail:nth-child(3):before,
    .steps-splide-wrapper li:nth-child(3) .step-detail:before {
        background-image: url("/images/steps/3.png");
    }

    .step-detail:nth-child(4):before,
    .steps-splide-wrapper li:nth-child(4) .step-detail:before {
        background-image: url("/images/steps/4.png");
    }

    .step-detail:nth-child(5):before,
    .steps-splide-wrapper li:nth-child(5) .step-detail:before {
        background-image: url("/images/steps/5.png");
    }

    .step-detail:nth-child(6):before,
    .steps-splide-wrapper li:nth-child(6) .step-detail:before {
        background-image: url("/images/steps/6.png");
    }

    .splide__pagination__page.is-active {
        background-color: var(--main-pink);
    }

    .splide__pagination__page {
        background-color: var(--main-blue);
        opacity: 1;
    }

    .splide__pagination {
        bottom: -20px;
    }

    .splide__slide {
        display: flex;
        justify-content: center;
        padding: 5px 0;
    }
</style>
