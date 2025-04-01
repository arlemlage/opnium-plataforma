$(function () {
    'use strict';

    CKEDITOR.replace( 'mail_body', {
        toolbar: [
            [ 'Bold','Italic','Strike','JustifyLeft','JustifyCenter', 'JustifyRight','NumberedList', 'BulletedList','Outdent','Indent'],
        ]
    });
    CKEDITOR.addCss(".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}");

    $(document).on('click','#auto_response',function () {
        if($('#auto_response').prop("checked") === true) {
            $('#body_div,#subject_div').removeClass('displayNone');
        } else {
            $('#body_div,#subject_div').addClass('displayNone');
        }
    });

    $(document).on('click',)
});
