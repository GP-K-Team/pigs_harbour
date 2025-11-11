$(document).ready(function () {
    let closestForm;

    $('.delete-form').on('submit', function (e) {
        e.preventDefault();
        closestForm = $(this);
        $('.window-container').show();

        $('.delete-text-slot').text(closestForm.data('title'));

        $('.confirm-delete').on('click', function (e) {
            e.preventDefault();

            if (closestForm) {
                closestForm[0].submit();
            }
        })
    });
});
