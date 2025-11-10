// Default theme
import '@splidejs/splide/css';

import Splide from '@splidejs/splide';

$(document).ready(function () {

    $('.hashtag-item').on('click', function (e) {
        e.stopPropagation();
        let newLocation = `${location.protocol}//${location.hostname}:${location.port}/blog`

        let clickedTag = $(this);

        if (clickedTag.data('hashtag') === 'vse' && !clickedTag.hasClass('hashtag-item-active')) {
            location.replace(trim(newLocation, '/'));
        } else if (clickedTag.data('hashtag') !== 'vse') {

            let hashtags = '';

            $('.hashtag-item-active').each((index,element) => {
                if (hashtags > 0) {
                    hashtags += ','
                }

                let currentTagData = $(element).data('hashtag');

                if (currentTagData === 'vse') {
                    return;
                }

                if (clickedTag.data('hashtag') === currentTagData && clickedTag.hasClass('hashtag-item-active')) {
                    return;
                }

                hashtags += currentTagData;

            });

            if (!clickedTag.hasClass('hashtag-item-active')) {
                hashtags += hashtags ? (',' + clickedTag.data('hashtag')) : clickedTag.data('hashtag');
            }

            if (hashtags && hashtags.length) {
                newLocation += '?hashtags=' + hashtags;
            }

            location.replace(trim(newLocation, '/'));
        }
    })
});
