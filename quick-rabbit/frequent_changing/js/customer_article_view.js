(function($){
    "use strict";
    let please_login = $("#please_login").val();
    $(document).on('click', '.review_submit_btn', function(e) {
        Swal.fire({
            icon: 'warning',
            title: please_login,
            confirmButtonColor: '#36405E',
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            showCancelButton: true
        });
    });

})(jQuery);
