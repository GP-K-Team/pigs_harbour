/**
 * Bind a translit source input to the translit target,
 * send an ajax request for generating the value on change.
 */

const sourceInput = $('[data-translit-source]');
const targetInput = $('[data-translit-target]');

if (!targetInput.val().length) {
    prependInputPrefix(targetInput);
}

sourceInput.on('change', function () {
    const value = this.value;

    if (!value.length) {
        return prependInputPrefix(targetInput);
    }

    $.ajax({
        url: '/ajax',
        data: {
            method: 'transliterate',
            data: value,
        },
        success(res) {
            prependInputPrefix(targetInput, res);
        },
        error(err) {
            console.log(err);
        },
    });
});

targetInput.on('change', function () {
    prependInputPrefix(targetInput, $(this).val());
});

function prependInputPrefix(elm, val = '') {
    const inputPrefix = $(elm).data('input-prefix');

    $(elm).val(inputPrefix + val.replace(inputPrefix, ''));
}
