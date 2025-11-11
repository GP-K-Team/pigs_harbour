<div class="window-container">
    <div class="window delete-modal">
        <div class="modal-content-wrapper">
            <p>
                Вы собираетесь удалить «<span class="delete-text-slot"></span>». Это действие <span class="permanent-text-marker">необратимо</span>. Вы уверены?
            </p>
            <div class="modal-buttons-container">
                <button class="confirm-delete button orange-button">
                    Да
                </button>
                <button class="button" onclick="$('.window-container').hide()">
                    Нет
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .permanent-text-marker {
        color: var(--holiday_red);
    }

    .window.delete-modal {
        height: 20vh;
    }

    .modal-content-wrapper {
        display: flex;
        flex-direction: column;
        row-gap: 25px;
        justify-content: center;
        align-items: center;
        height: 100%;
        font-size: 25px;
    }

    .modal-buttons-container {
        display: flex;
        column-gap: 25px;
        flex-wrap: wrap;
    }

    .delete-modal .button.orange-button {
        background-color: var(--pale_orange);
    }

    .delete-modal .button.orange-button:hover {
        background-color: var(--main_green);
    }

    .delete-modal .button:not(.orange-button):hover {
        background-color: var(--pale_yellow);
    }

    .delete-text-slot {
        color: var(--dark_blue_font);
    }
</style>
