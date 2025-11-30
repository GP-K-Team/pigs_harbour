$(document).ready(function () {
    $('.list-item.card.animated-block').on('click', function (e) {
        window.location.replace($(this).data('url'));
    });
});
