/**
 * Bind a translit source input to the translit target,
 * send an ajax request for generating the value on change.
 */

$('[data-translit-source]').on('change', function () {
    const value = this.value;
    const target = $('[data-translit-target]');

    if (!value.length) {
        return target.val(value);
    }

    $.ajax({
        url: '/ajax',
        data: {
            method: 'transliterate',
            data: value,
        },
        success(res) {
            $(target).val(res);
        },
        error(err) {
            console.log(err);
        },
    });
});
