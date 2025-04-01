(function($){
    "use strict";

    $(document).on('click','#enable_gdpr',function () {
        if($('#enable_gdpr').prop("checked") === true) {
            $('.gdpr-setting').removeClass('displayNone');
        } else {
            $('.gdpr-setting').addClass('displayNone');
        }
    });

    CKEDITOR.replace( 'cookie_message', {
        toolbar: [
            [ 'Bold','Italic','Strike','JustifyLeft','JustifyCenter', 'JustifyRight','NumberedList', 'BulletedList','Outdent','Indent'],
        ]
    });

    CKEDITOR.addCss(".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}");

    $(document).on('submit','#gdpr-setting-form',function() {
        let cookie_message = CKEDITOR.instances['cookie_message'].getData().replace(/<[^>]*>/gi, '').length;
        let user_agreement_message = CKEDITOR.instances['user_agreement_message'].getData().replace(/<[^>]*>/gi, '').length;

        if($('#enable_gdpr').prop("checked") === true) {
            if(cookie_message == 0) {
                $('#cke_cookie_message').css('border','1px solid red');
                $('.content-invalid').show();
                return false;
            } else if(user_agreement_message == 0) {
                $('#cke_user_agreement_message').css('border','1px solid red');
                $('.content-invalid').show();
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }


    });

})(jQuery);
