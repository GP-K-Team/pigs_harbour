import './bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $


$(document).ready(function() {
    $('.menu_burger').on('click', function() {
        $('.mobile_nav_wrapper').css('display', 'block');
    });

    $('.close_nav_button').on('click', function() {
        $('.mobile_nav_wrapper').css('display', 'none');
    });
});
