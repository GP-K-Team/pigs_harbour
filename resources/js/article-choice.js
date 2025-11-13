import Choices from 'choices.js'
import 'choices.js/public/assets/styles/choices.css'

$(document).ready(function () {
    const hashtags = document.getElementById('hashtags')
    let choices = new Choices(hashtags, {
        removeItemButton: true,
        duplicateItemsAllowed: true,
        placeholderValue: 'Выберите категории',
        searchPlaceholderValue: 'Поиск...',
        loadingText: 'Загрузка...',
        noResultsText: 'Нет результатов',
        noChoicesText: 'Нет результатов',
        itemSelectText: '',
        addItems: true,
        addChoices: true,
        addItemFilter: () => true,
        addItemText: (value) => `${value}`,
        paste: true,
    })


    const wrapper = hashtags.closest('.choices')

    wrapper.addEventListener('click', (e) => {
        const el = e.target.closest('.add-choice');

        if (el) {
            const text = el.textContent.trim();
            const exists = choices.getValue(true).includes(text);

            if (!exists) {
                choices.setChoices(
                    [{ text, label: text, selected: true }],
                    'value',
                    'label',
                    false
                )
            }
        }
    })
});
