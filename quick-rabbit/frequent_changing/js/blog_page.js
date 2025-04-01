$(function () {
    "use strict";
    $(document).on('change', '#category', function () {
        let link = $('#category').val();
        if (link) {
            location.href = link;
        }
    });
});
