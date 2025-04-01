(function($){
    "use strict";

    $(document).on('click', '.open_modal_pusher_setting', function(e) {
        openModal('pusher_setting_modal');
    });
    $(document).on('click', '.close_modal_pusher_setting', function(e) {
        closeModal('pusher_setting_modal');
    });

    $(document).on('click','#auto_reply_out_of_schedule',function () {
        if($('#auto_reply_out_of_schedule').prop("checked") === true) {
            $('#body_div').removeClass('displayNone');
        } else {
            $('#body_div').addClass('displayNone');
        }
    });

})(jQuery);
