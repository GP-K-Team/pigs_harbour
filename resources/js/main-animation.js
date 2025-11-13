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

    $(document).on('scroll mousewheel wheel resize', toggleActive);
    $(window).on('scroll mousewheel wheel resize', toggleActive);
    $('body').on('scroll mousewheel wheel resize', toggleActive);
});
