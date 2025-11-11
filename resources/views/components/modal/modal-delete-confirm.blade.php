<div class="window-container">
    <div class="window delete-modal">
        <div class="modal-content-wrapper">
            <p>
                Вы собираетесь удалить <span class="delete-text-slot"></span>. Это действие <span class="permanent-text-marker">необратимо</span>. Вы уверены?
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
        color: var(--main_pink);
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

    .button.orange-button {
        background-color: var(--pale_orange);
    }
</style>
