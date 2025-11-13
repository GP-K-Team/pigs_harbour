$(document).ready(function () {
    function toggleActive() {
        $('.animated-block').each(function () {
            const blockTop = $(this).offset().top;
            const scrollBottom = $(window).scrollTop() + $(window).height();

            console.log(scrollBottom);
            console.log(blockTop);

            if (scrollBottom > blockTop + 100 && !$(this).hasClass('active')) {
                $(this).addClass('active');
            }
        });
    }

    $(window).on('scroll mousewheel', toggleActive);
    toggleActive();
});
