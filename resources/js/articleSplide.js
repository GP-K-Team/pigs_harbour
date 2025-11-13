import '@splidejs/splide/css';

import Splide from '@splidejs/splide';

$(document).ready(function () {

    let windowWidth = $(window).width();
    let articlesSplide;

    if (windowWidth < 768) {
        initateSplide();
    }

    $(window).resize(function() {
        windowWidth = $(window).width();

        if (windowWidth > 768) {
            initateSplide();
        }
    });

    function initateSplide() {

        if (!articlesSplide) {
            articlesSplide = new Splide('#articles_splide').mount();
        }
    }
});
