import '@splidejs/splide/css';

import Splide from '@splidejs/splide';

$(document).ready(function () {

    let windowWidth = $(window).width();

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
        new Splide('#articles_splide').mount();
    }
});
