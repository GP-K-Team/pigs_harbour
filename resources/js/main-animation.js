$(document).ready(function () {
    function toggleActive() {
        $('.animated-block').each(function () {
            const blockTop = $(this).offset().top;
            const scrollBottom = $(window).scrollTop() + $(window).height();

            console.log(scrollBottom);
            console.log(blockTop);

            if (scrollBottom > blockTop + 50 && !$(this).hasClass('active')) {
                $(this).addClass('active');
            }
        });
    }

    toggleActive();

    $(window).on('scroll mousewheel', toggleActive);
});
