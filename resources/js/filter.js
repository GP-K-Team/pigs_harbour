$(document).ready(function () {
    $('[name="filter"]').on('submit', function (e) {
        e.preventDefault();

        const filterParams = Array.from((new FormData(this)).values()).filter(s => s);
        const filterUrlQuery = 'catalog/' + filterParams.map(s => trim(s, '/')).join('/');

        const constructedUrl = `${location.protocol}//${location.hostname}:${location.port}/${filterUrlQuery}`;

        location.replace(trim(constructedUrl, '/'));
    });
});
