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
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage', 'upload'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['emoji'],
            ['horizontalRule'],
            ['removeformat'],
        ],
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
    });

    $('#editor_window').closest('.window-container').on('close', function () {
        $('.trumbowyg-modal').remove();
    });

    $(document).on('change', '.trumbowyg-modal-box .trumbowyg-input-html input[type="file"]', function () {
        const filename = $(this).val();

        if (filename) {
            $('.trumbowyg-modal-box .trumbowyg-input-html input[type="file"]').css({visibility: 'hidden', height: 0})
                .parent().append(
                    filename.slice(
                        filename.lastIndexOf('\\') + 1
                    )
                );
        }
    });
});
