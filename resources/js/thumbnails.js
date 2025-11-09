$(document).ready(function () {
    $('.thumbnail_list').on('click', '.thumbnail_element img', function () {
        const newSrc = $(this).attr('src');
        const $mainImage = $('.main_pig_image');
        const $blurredImage = $('.blurred_main_pig_image');

        $mainImage.add($blurredImage).fadeOut(200, function () {
            $(this).attr('src', newSrc).fadeIn(200);
        });
    });
});
