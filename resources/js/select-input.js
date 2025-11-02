import jqueryCustomSelect from "jquery-custom-select";

$(document).ready(function () {
    $('select').each(function (i, sel) {
        $(sel).customSelect({
            block: 'select-input',
            includeValue: true,
            placeholder: $(this).find('option[value=""]').text(),
            transition: 50,
            search: $(this).data('search'),
        });
    });
});
