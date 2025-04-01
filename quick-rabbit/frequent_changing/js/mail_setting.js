(function($){
    "use strict";

    $(document).on('click', '.open_modal_mail_from', function(e) {
        openModal('mail_from');
    });
    $(document).on('click', '.close_modal_mail_from', function(e) {
        closeModal('mail_from');
    });
    $(document).on('click', '.open_modal_from_name', function(e) {
        openModal('from_name');
    });
    $(document).on('click', '.close_modal_from_name', function(e) {
        closeModal('from_name');
    });

})(jQuery);
