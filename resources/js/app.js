import './bootstrap';

$(document).ready(function() {
    $('.menu_burger').on('click', function() {
        $('.mobile_nav_wrapper').show();
    });

    $('.close_nav_button').on('click', function() {
        $('.mobile_nav_wrapper').hide();
    });
});

$.ajaxSetup({
    headers: {
        // attach header with CSRF token to every ajax request
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});
