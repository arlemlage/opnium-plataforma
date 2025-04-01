(function($){
    "use strict";

    $(document).on('change', '.envato_set_up', function(e) {
        if($(this).prop("checked") == true){
            $('.envato_set_up_input_field').removeClass('d-none');
            $('.envato_api_key').attr('required', true);
        }else{
            $('.envato_set_up_input_field').addClass('d-none');
            $('.envato_api_key').attr('required', false);
        }
    });

    $(document).on('change', '.woocommerce_set', function(e) {
        if($(this).prop("checked") == true){
            $('.woocommerce_set_up_input_field').removeClass('d-none');
            $('.w_customer_key').attr('required', true);
            $('.w_customer_secret').attr('required', true);
            $('.w_store_url').attr('required', true);
        }else{
            $('.woocommerce_set_up_input_field').addClass('d-none');
            $('.w_customer_key').attr('required', false);
            $('.w_customer_secret').attr('required', false);
            $('.w_store_url').attr('required', false);
        }
    });

    $(document).on('change', '.shopify_set', function(e) {
        if($(this).prop("checked") == true){
            $('.shopify_set_up_input_field').removeClass('d-none');
            $('.shopify_store_url').attr('required', true);
            $('.shopify_api_key').attr('required', true);
            $('.shopify_password').attr('required', true);
            $('.shopify_secret_key').attr('required', true);
        }else{
            $('.shopify_set_up_input_field').addClass('d-none');
            $('.shopify_store_url').attr('required', false);
            $('.shopify_api_key').attr('required', false);
            $('.shopify_password').attr('required', false);
            $('.shopify_secret_key').attr('required', false);
        }
    });

})(jQuery);
