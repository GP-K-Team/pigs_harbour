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

    <div class="button steps_button">
        <a href="{{ route('pigs.catalog') }}">
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
        margin: auto;
        display: flex;
        justify-content: center;
        row-gap: 40px;
        column-gap: 40px;
        flex-wrap: wrap;
    }

    .step_detail {
        padding: 20px;
        width: 267px;
        height: 140px;
        box-sizing: border-box;
    }

    .step_detail:nth-child(1) {
        background-color: var(--main_green);
    }

    .step_detail:nth-child(2) {
        background-color: var(--main_pink);
    }

    .step_detail:nth-child(3) {
        background-color: var(--light_blue);
    }

    .step_detail:nth-child(4) {
        background-color: var(--main_blue);
    }

    .step_detail:nth-child(5) {
        background-color: var(--pale_orange);
    }

    .step_detail:nth-child(6) {
        background-color: var(--pale_yellow);
    }
</style>
