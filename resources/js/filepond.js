import 'filepond/dist/filepond.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import '../css/filepond.css';

$(document).ready(function () {
    const existingFiles = window.preloadedFiles || [];

    FilePond.setOptions({
        server: {
            load: (source, load, error, progress, abort, headers) => {
                const myRequest = new Request(source);

                fetch(myRequest).then(response => {
                    if (response.ok) {
                        return response.blob();
                    }

                    throw new Error('Failed to load image');
                }).then(load).catch(error);
            },
        },
    });

    const target = document.querySelector('.filepond');
    const isMultiple = Boolean(target.dataset.multiple);
    const pond = FilePond.create(target, {
        name: (target.dataset.filepondInputName ?? 'files') + (isMultiple ? '[]' : ''),
        storeAsFile: true,
        labelIdle: '<span class="filepond--label-action"></span>',
        allowMultiple: isMultiple,
        allowReorder: true,
        allowBrowse: true,
        acceptedFileTypes: ['image/*'],
        labelFileTypeNotAllowed: 'Неверный тип файла',
        fileValidateTypeLabelExpectedTypes: 'Принимаются только картинки',
        imagePreviewHeight: 150,
        files: existingFiles,
    });

    pond.on('removefile', (error, file) => {
        if (file.getMetadata('id')) {
            fetch(`/files/${file.getMetadata('id')}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });
        }
    });

    $('.filepond--root').on('FilePond:updatefiles', function (e) {
        const items = e.originalEvent.detail.items;

        adjustFilepondListHeight(pond, items);

        if (items.length) {
            $(this).find('.filepond--drop-label').hide();
        } else {
            $(this).find('.filepond--drop-label').show();
        }
    });

    $(window).on('resize', function () {
        adjustFilepondListHeight(pond);
    });
});

function adjustFilepondListHeight(pond, items = null) {
    const container = document.querySelector('.filepond--root');
    const previewItemHeight = pond.imagePreviewHeight;
    items ??= pond.getFiles();

    const itemList = container.querySelector('.filepond--list');
    const containerWidth = itemList.offsetWidth;

    let numberOfRows;

    if (items.length) {
        const itemWidth = itemList.children[0].offsetWidth;
        numberOfRows = Math.ceil(items.length / Math.floor(containerWidth / itemWidth));
    } else {
        numberOfRows = 0;
    }

    const containerDesiredHeight = previewItemHeight * numberOfRows;

    itemList.style.height = `calc(${containerDesiredHeight}px + ${Math.ceil(numberOfRows / 2)}rem)`;
}
