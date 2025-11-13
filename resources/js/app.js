import './bootstrap';

$(document).ready(function() {
    $('.menu-burger').on('click', function() {
        $('.mobile-nav-wrapper').show();
    });

    $('.close-nav-button').on('click', function() {
        $('.mobile-nav-wrapper').hide();
    });

    $('img').on('error', function () {
        $(this).addClass('card-image_alt-shown');
    });
});

$.ajaxSetup({
    headers: {
        // attach header with CSRF token to every ajax request
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});

window.trim = function trim(str, char) {
    let start = 0;
    let end = str.length;

    while(start < end && str[start] === char)
        ++start;

    while(end > start && str[end - 1] === char)
        --end;

    return (start > 0 || end < str.length) ? str.substring(start, end) : str;
}
