$(document).ready(function () {
    $('.thumbnail-list').on('click', '.thumbnail-element img', function () {
        const newSrc = $(this).attr('src');
        const $mainImage = $('.main-pig-image');
        const $blurredImage = $('.main-image_blurred');

        $mainImage.add($blurredImage).fadeOut(200, function () {
            $(this).attr('src', newSrc).fadeIn(200);
        });
    });
});
