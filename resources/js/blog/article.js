$(document).ready(function () {
    $(':is(.article-container, .trumbowyg-editor) > p > img').each(function (i, img) {
        const caption = $('<figcaption>').text( $(img).attr('alt') );

        caption.insertAfter($(img).wrap('<figure>'));
    });
});
