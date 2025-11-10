$(document).ready(function () {
    $(document).on('input', '[contenteditable]', function() {
        clearTimeout($(this).data('timer'));

        const timer = setTimeout(() => {
            $.ajax({
                url: '/page_text/' + $(this).data('page-text-id'),
                type: 'PUT',
                data: {
                    content: $(this).text(),
                }
            });

            console.log('Send update from');
        }, 500);

        $(this).data('timer', timer);
    });
});
