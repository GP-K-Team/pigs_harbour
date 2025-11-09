

<div class="steps_wrapper">
    <h2 class="steps_wrapper_header">Если вы хотите взять у нас свинку</h2>

    <div class="steps_main_wrapper">
        <ul class="steps_list">
            <li class="step_detail">
                <p>
                    Выберите понравившуюся морскую свинку
                </p>
            </li>
            <li class="step_detail">
                <p>
                    Подготовьте условия, в которые вы хотите принять нашего подопечного
                </p>
            </li>
            <li class="step_detail">
                <p>
                    Напишите нам в группу VK, если у вас есть вопросы по содержанию
                </p>
            </li>
            <li class="step_detail">
                <p>
                    Заполните анкету и отправьте в личные сообщения группы в VK
                </p>
            </li>
            <li class="step_detail">
                <p>
                    Дождитесь одобрения анкеты
                </p>
            </li>
            <li class="step_detail">
                <p>
                    Договоритесь о встрече с волонтером и станьте счастливым свинородителем
                </p>
            </li>
        </ul>
    </div>


    <section id="steps_splide" class="splide steps_splide_wrapper" aria-label="6 шагов к морской свинке">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide">
                    <div class="step_detail">
                        <p>
                            Выберите понравившуюся морскую свинку
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step_detail">
                        <p>
                            Подготовьте условия, в которые вы хотите принять нашего подопечного
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step_detail">
                        <p>
                            Напишите нам в группу VK, если у вас есть вопросы по содержанию
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step_detail">
                        <p>
                            Заполните анкету и отправьте в личные сообщения группы в VK
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step_detail">
                        <p>
                            Дождитесь одобрения анкеты
                        </p>
                    </div>
                </li>
                <li class="splide__slide">
                    <div class="step_detail">
                        <p>
                            Договоритесь о встрече с волонтером и станьте счастливым свинородителем
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <div class="button steps_button">
        <a href="{{ route('catalog.index') }}">
            Подробнее
        </a>
    </div>
</div>

<style>
    .steps_wrapper {
        border-top: 10px solid var(--pale_orange);
        padding: 20px 40px;
        background-image: url("/images/bright_dark.png");
    }

    .steps_splide_wrapper {
        display: none;
    }

    @media (max-width: 768px) {
        .steps_main_wrapper {
            display: none;
        }

        .steps_splide_wrapper {
            display: block;
        }
    }

    @media (max-width: 500px) {
        .steps_main_wrapper {
            display: block;
        }

        .steps_splide_wrapper {
            display: none;
        }
    }

    .steps_wrapper_header {
        font-family: '315karusel', sans-serif;
        font-size: 50px;
        text-align: center;

        @media (max-width: 1300px) {
            font-size: 25px;
        }
    }

    .steps_button {
        margin: 40px auto 20px;
    }

    .button {
        position: relative;
        width: fit-content;
        padding: 0.25rem 1.5rem;
        text-transform: uppercase;
        font-family: inherit;
        font-size: 2rem;
        background-color: #C3E9EA;
        border: solid 2px #000000;
        border-radius: 0.75rem;
        cursor: pointer;
        z-index: 4;

        @media (max-width: 450px) {
            font-size: 20px;
        }
    }

    .steps_list {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: center;
        row-gap: 40px;
        column-gap: 80px;
        flex-wrap: wrap;
    }

    .step_detail {
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

    .step_detail:before {
        content: "";
        position: absolute;
        width: 103px;
        height: 143px;
        top: 0;
        left: -65px;
    }

    .step_detail:nth-child(1),
    .steps_splide_wrapper li:nth-child(1) .step_detail {
        background-color: var(--darker_green);
    }

    .step_detail:nth-child(2),
    .steps_splide_wrapper li:nth-child(2) .step_detail {
        background-color: var(--main_pink);
    }

    .step_detail:nth-child(3),
    .steps_splide_wrapper li:nth-child(3) .step_detail {
        background-color: var(--main_blue);
    }

    .step_detail:nth-child(4),
    .steps_splide_wrapper li:nth-child(4) .step_detail {
        background-color: var(--bright_blue);
    }

    .step_detail:nth-child(5),
    .steps_splide_wrapper li:nth-child(5) .step_detail {
        background-color: var(--pale_orange);
    }

    .step_detail:nth-child(6),
    .steps_splide_wrapper li:nth-child(6) .step_detail {
        background-color: var(--pale_yellow);
    }

    .step_detail:nth-child(1):before,
    .steps_splide_wrapper li:nth-child(1) .step_detail:before {
        background-image: url("/images/steps/1.png");
    }

    .step_detail:nth-child(2):before,
    .steps_splide_wrapper li:nth-child(2) .step_detail:before {
        background-image: url("/images/steps/2.png");
    }

    .step_detail:nth-child(3):before,
    .steps_splide_wrapper li:nth-child(3) .step_detail:before {
        background-image: url("/images/steps/3.png");
    }

    .step_detail:nth-child(4):before,
    .steps_splide_wrapper li:nth-child(4) .step_detail:before {
        background-image: url("/images/steps/4.png");
    }

    .step_detail:nth-child(5):before,
    .steps_splide_wrapper li:nth-child(5) .step_detail:before {
        background-image: url("/images/steps/5.png");
    }

    .step_detail:nth-child(6):before,
    .steps_splide_wrapper li:nth-child(6) .step_detail:before {
        background-image: url("/images/steps/6.png");
    }

    .splide__pagination__page.is-active {
        background-color: var(--main_pink);
    }

    .splide__pagination__page {
        background-color: var(--main_blue);
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
