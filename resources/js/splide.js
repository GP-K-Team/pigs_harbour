import '@splidejs/splide/css';

import Splide from '@splidejs/splide';

$(document).ready(function () {

    let windowWidth = $(window).width();
    let stepSplide;
    let pigsSplide;
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
        if (!stepSplide && $('#steps_splide').length) {
            stepSplide = new Splide('#steps_splide').mount();
        }

        if (!pigsSplide && $('#pigs_splide').length) {
            pigsSplide = new Splide('#pigs_splide').mount()
        }

        if (!articlesSplide && $('#articles_splide').length) {
            articlesSplide = new Splide('#articles_splide').mount();
        }
    }
});
