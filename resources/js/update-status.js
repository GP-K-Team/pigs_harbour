
$(document).ready(function () {
    $('input[name="is_active"]').on('change', function (e) {

        $.ajax({
            url: '/pigs/status/' + $('.pig-wrapper').data('pig-slug'),
            type: 'POST',
            data: {
                is_active: $(this).val(),
            }
        });

        location.reload();
    });
});
