import './bootstrap';
import './select-input';
import './filepond';

$(document).ready(function() {
    $('.menu_burger').on('click', function() {
        $('.mobile_nav_wrapper').show();
    });

    $('.close_nav_button').on('click', function() {
        $('.mobile_nav_wrapper').hide();
    });
});
