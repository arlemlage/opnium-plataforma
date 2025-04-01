$(function () {
    'use strict';
    let base_url = $('input[name="app-url"]').attr('data-app_url');
    let user_id = $('input[name="app-user_id"]').attr('data-app_user_id');

    $(document).on('click','.pre_sale_after_sale_btn',function() {
         let this_button_text = $(this).text();
         $(".message-box").val(this_button_text);
         $(".customer-send-message").click();
    });
    function successValidation(){
        let product_category_id = $("#product_category_id").val();
        let verify_group_id = $("#verify_group_id").val();

        let form_data = {
            product_id: product_category_id,
            verify_group_id: verify_group_id
        };
        $.ajax({
            url: base_url+'/success-validation',
            type: 'GET',
            data: form_data,
            dataType:'json',
            success: function(data){

            }
        }); 
    }
    function envatoVerification(username,purchase_code,this_action) {
        let product_category_id = $('#product_category_id').val();
        let form_data = {
            product_category_id: product_category_id,
            username: username,
            purchase_code: purchase_code
        };
        $.ajax({
            url: base_url+'/api/envato-validation',
            type: 'GET',
            data: form_data,
            dataType:'json',
            success: function(data){
               if(data.status==true){
                successValidation();
                $(".envato_err").text('');
                this_action.text("Verified");
               }else{
                $(".envato_err").text(data.message);
                this_action.removeClass("verified");
                this_action.text("Verify Now");
               }

            }
        }); 
    }
    $(document).on('click','.yes_no_btn',function(e) {
        e.preventDefault();
        let this_button_text = $(this).attr('data-type');
        console.log(this_button_text);
        if(this_button_text=="yes"){
            this_button_text = "Yes, I got that answer."
        }else{
            this_button_text = "No, I need agent support."
        }
        $(".message-box").val(this_button_text);
         $(".customer-send-message").click();
    });

    $(document).on('click','.verify_now',function(e) {
        e.preventDefault();
        let username = sanitizeInput($('#envato_u_name').val());
        let purchase_code = sanitizeInput($('#envato_p_code').val());
           
        if (!username.length && username.trim() == "") {
            $('#envato_u_name').addClass("is-invalid").css('border', '1px solid red !important;');
          return false;
        } else if (!purchase_code.length && purchase_code.trim() == "") {
            $('#envato_p_code').addClass("is-invalid").css('border', '1px solid red !important;');
          return false;
        } else {
            $(this).addClass("verified");
            $(this).text("Verifying...");
            envatoVerification(username,purchase_code,$(this));
        }
        
    });

    function sanitizeInput(input) {
        return input
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }


})
