(function($){
    "use strict";

    $(document).on('click', '.open-facebook-config-modal', function(e) {
        openModal('facebook-config-modal');
    });
    $(document).on('click', '.close-facebook-config-modal', function(e) {
        closeModal('facebook-config-modal');
    });

    $(document).on('click','#auto_reply_out_of_schedule',function () {
        if($('#auto_reply_out_of_schedule').prop("checked") === true) {
            $('#body_div').removeClass('displayNone');
        } else {
            $('#body_div').addClass('displayNone');
        }
    });

})(jQuery);
