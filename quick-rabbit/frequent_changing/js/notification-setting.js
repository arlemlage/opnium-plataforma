(function($){
    "use strict";
    $(document).on('change', '.disable_notifications', function (){
        if($(this).prop("checked") == true){
            $(this).val('1');
            $('.enable').val('on');
            $('.enable').prop('checked', true);
        }else{
            $(this).val('0');
            $('.enable').val('off');
            $('.enable').prop('checked', false);
        }
    });

    $(document).on('change', '.web_push_n', function (){
        if($(this).prop("checked") == true){
            $(this).val('on');
            $(this).parent().find('.web_push_n_val').val('on');
        }else{
            $(this).val('off');
            $(this).parent().find('.web_push_n_val').val('off');
        }
    });


    $(document).on('change', '.mail_n', function (){
        if($(this).prop("checked") == true){
            $(this).val('on');
            $(this).parent().find('.mail_n_val').val('on');
        }else{
            $(this).val('off');
            $(this).parent().find('.mail_n_val').val('off');
        }
    });

    $(document).on('change', '.browser_notification', function (){
        if($(this).prop("checked") == true){
            $('.firebase-info-div').removeClass('display-none');
        }else{
            $('.firebase-info-div').addClass('display-none');
        }
    });

    $(document).on('click', '.open_modal_pusher_setting', function(e) {
        openModal('pusher_setting_modal');
    });
    $(document).on('click', '.close_modal_pusher_setting', function(e) {
        closeModal('pusher_setting_modal');
    });
})(jQuery);
