(function($){
    "use strict";
    let app_url = $('input[name="app-url"]').attr('data-app_url');
    $(document).on('click', '.open_modal_customer', function(e) {
        openModal('add_customer');
    });
    $(document).on('click', '.close_modal_customer', function(e) {
        closeModal('add_customer');
    });
    $(document).on('click', '.add_new_customer', function () {
        showSpin('customer-spinner','submit-customer');
        if($('.first_name').val() == "") {
            $('.error_f_name').text($('#first_name_required').val());
            hideSpin('customer-spinner','submit-customer');
            return false;
        } if($('.first_name').val().length > 191) {
            $('.error_f_name').text($('#first_name_max_191').val());
            hideSpin('customer-spinner','submit-customer');
            return false;
        } else if($('.last_name').val() == "") {
            $('.error_l_name').text($('#first_name_required').val());
            hideSpin('customer-spinner','submit-customer');
            return false;
        } else if($('.last_name').val().length > 191) {
            $('.error_l_name').text($('#last_name_max_191').val());
            hideSpin('customer-spinner','submit-customer');
            return false;
        } else if($('.email').val() == "") {
            $('.error_email').text($('#email_required').val());
            hideSpin('customer-spinner','submit-customer');
            return false;
        } else if($('.email').val().length > 50) {
            $('.error_email').text($('#email_max_50').val());
            hideSpin('customer-spinner','submit-customer');
            return false;
        } else {
            let form_data = {
                first_name: $('.first_name').val(),
                last_name: $('.last_name').val(),
                email: $('.email').val(),
                status: $('.status').val(),
            };

            $.ajax({
                url: app_url+'/customer',
                type: 'POST',
                data: form_data,
                success: function(data){
                    hideSpin('customer-spinner','submit-customer');
                    if (data.status==1){
                        $('.first_name').val('');
                        $('.last_name').val('');
                        $('.email').val('');
                        $('.ajax_data_alert').empty();
                        $('.ajax_data_field_alert').empty();
                        $('.ajax_data_alert_show_hide').removeClass('d-none');
                        $('.ajax_data_alert').text(data.msg);
                        $('#append_c_option_by_ajax').empty();
                        $.each(data.all_customer_options, function (index, val) {
                            $('#append_c_option_by_ajax').append(val);
                        });
                        //modal close
                        closeModal('add_customer');
                    }
                    else if((data.status==0)) {
                        hideSpin('customer-spinner','submit-customer');
                        $('.ajax_data_field_alert').empty();
                        $('.error_f_name').text(data.first_name);
                        $('.error_l_name').text(data.last_name);
                        $('.error_email').text(data.email);
                    }
                }
            });
        }
    });
})(jQuery);
