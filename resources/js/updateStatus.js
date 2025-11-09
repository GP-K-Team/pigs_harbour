
$(document).ready(function () {
    $('input[name="is_active"]').on('change', function (e) {

        $.ajax({
            url: '/pigs/status/' + $('.pig_wrapper').data('pig-slug'),
            type: 'POST',
            data: {
                is_active: $(this).val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
});
