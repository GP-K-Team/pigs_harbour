$(document).ready(function () {
    $(document).on('input', '[contenteditable]', function() {
        clearTimeout($(this).data('timer'));

        const timer = setTimeout(() => {
            $.ajax({
                url: '/page-text/' + $(this).data('page-text-id'),
                type: 'PUT',
                data: {
                    content: $(this).text(),
                }
            });
        }, 500);

        $(this).data('timer', timer);
    });
});
