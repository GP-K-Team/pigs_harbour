
$(document).ready(function () {
    $('input[name="status"]').on('change', function (e) {

        $.ajax({
            url: '/catalog/status/' + $('.pig-wrapper').data('pig-slug'),
            type: 'POST',
            data: {
                status: $(this).val(),
            }
        });

        location.reload();
    });
});
