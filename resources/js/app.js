import './bootstrap';
import jqueryCustomSelect from "jquery-custom-select";
import $ from 'jquery';

window.$ = window.jQuery = $;

$(document).ready(function() {
    $('.menu_burger').on('click', function() {
        $('.mobile_nav_wrapper').show();
    });

    $('.close_nav_button').on('click', function() {
        $('.mobile_nav_wrapper').hide();
    });

    $('select').each(function (i, sel) {
        $(sel).customSelect({
            block: 'select-input',
            includeValue: true,
            placeholder: $(this).attr('placeholder'),
            transition: 50,
            search: $(this).data('search'),
        })
    });
});
