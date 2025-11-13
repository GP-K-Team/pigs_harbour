$(document).ready(function () {
    function toggleActive() {
        const scrollTop = $(window).scrollTop();
        const scrollBottom = scrollTop + $(window).height();

        console.log('toggle');

        $('.animated-block').each(function () {
            const blockTop = $(this).offset().top;

            if (scrollBottom >= blockTop + 50 && !$(this).hasClass('active')) {
                $(this).addClass('active');
            }
        });
    }

    toggleActive();

    $(document).on('scroll mousewheel resize', toggleActive);
});
