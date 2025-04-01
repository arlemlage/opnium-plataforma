(function($){
    "use strict";
    $(document).on('click', '.ds_modal_open', function() {
        let modal = $(this).attr("data")
        $('#'+modal).modal('show');
    });

    $(document).on('click', '.ds_close_modal', function() {
        let modal = $(this).attr("data")
        $('#'+modal).modal('hide');
    });
})(jQuery);
