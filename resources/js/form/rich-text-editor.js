import 'trumbowyg/dist/trumbowyg.min.js';
import 'trumbowyg/dist/langs/ru.min.js';
import 'trumbowyg/dist/ui/trumbowyg.min.css';

import 'trumbowyg/dist/plugins/upload/trumbowyg.upload.min.js';

import 'trumbowyg/dist/plugins/emoji/trumbowyg.emoji.min.js';
import 'trumbowyg/dist/plugins/emoji/ui/trumbowyg.emoji.min.css';

$(document).ready(function () {
    $('.rich-text-editor').trumbowyg({
        svgPath: '/images/icons/trumbowyg.svg',
        lang: 'ru',
        btns: [
            ['viewHTML'],
            ['undo', 'redo'], // Only supported in Blink browsers
            ['formats'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage', 'upload'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['blockquote'],
            ['emoji'],
        ],
        btnsDef: {
            formats: {
                dropdown: ['p', 'h2', 'h3'],
                ico: 'p',
            },
        },
        plugins: {
            upload: {
                serverPath: '/editor/upload',
                fileFieldName: 'image',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            },
        },
        removeformatPasted: true, // prevent style carryover from other web pages or, say, Word
        tagsToRemove: ['script', 'iframe'],
    })
        .on('tbwinit', function () {
            clearEmptyBlocks();
            wrapImages();
        })
        .on('tbwblur', function () {
            wrapImages();
            clearEmptyBlocks();

            if (!$(this).val().length) {
                $(this).trumbowyg('empty');
            }
    });

    $('#editor_window').closest('.window-container').on('close', function () {
        $('.trumbowyg-modal').remove();
    });

    $(document).on('change', '.trumbowyg-modal-box .trumbowyg-input-html input[type="file"]', function () {
        const filename = $(this).val();

        if (filename) {
            // hide input button and display file name instead
            $('.trumbowyg-modal-box .trumbowyg-input-html input[type="file"]').css({visibility: 'hidden', height: 0})
                .parent().append(
                    filename.slice(filename.lastIndexOf('\\') + 1)
            );
        }
    });
});

function wrapImages() {
    $('.trumbowyg-editor img').not('figure img').each(function (i, img) {
        const caption = $('<figcaption>').text( $(img).attr('alt') );

        caption.insertAfter($(img).wrap('<figure>'));
    });

    updateEditorInnerValue();
}

function clearEmptyBlocks() {
    $('.trumbowyg-editor br').remove();
    $('.trumbowyg-editor > p:empty').remove();

    updateEditorInnerValue();
}

function updateEditorInnerValue() {
    $('.rich-text-editor').trigger('tbwchange');
}
