$(function () {
    'use strict';
    let base_url = $('input[name="app-url"]').attr('data-app_url');
    let user_id = $('input[name="app-user_id"]').attr('data-app_user_id');
    let please_login_first = $('#please_login_first').val();
    let str_login = $('#str_login').val();
    let ok = $('#ok').val();

    $(document).on('click','.login-alert',function() {       
        $(".login_msg").removeClass('d-none');
        $(".login_msg").html(`Please Login First. <a href="${base_url}/customer/login">Click here</a> to login.`);
    });

    function checkLogin(){
        let user_id_hidden = Number($("#user_id_hidden").attr("data-app_user_id"));
        if(!user_id_hidden){
          $(".login_msg_for_like").removeClass('d-none');
          $(".login_msg_for_like").html(`Please Login First. <a href="${base_url}/customer/login">Click here</a> to login.`)
        }else{
           return true;
        }
        
    }

    
    $(document).on('click','.vote_btn',function(e) {
        e.preventDefault();
        if((checkLogin())){
            let status = $(this).attr('data-status');
            let id = $(this).attr('data-id');
            let current_total = $(this).parent().find("span").text();
            let this_action = $(this);
            $.ajax({
              method: "post",
              url: base_url + "/api/forum-like-unlike-post",
              headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
              },
              data: {
                status: status,
                current_total: current_total,
                brower_id: user_id,
                id: id,
              },
              dataType: "json",
              success: function (response) {
                if (response.status == true) {
                  this_action
                    .parent()
                    .find("span")
                    .text(response.updated_counter);
                    showNotify("success", "Success!", 'Like added successfully!');
                } else {
                  showNotify("error", "Error!", 'Already Like Added!');
                }
              },
            });
        }
        
    });

    $(document).on('submit','#submit-question',function(e) {
        $('#make-disabled').prop('disabled',true);
        const subject = $('#subject').val();
        const product = $('#heroSelect').val();
        const description = $('#description').val();
        if(!(subject.length) && (subject.trim() === "")){
            $('#subject').css('border','1px solid red');
            $('#make-disabled').prop('disabled',false);
            return false;
        } else if(subject.length > 191){
            $('#subject').css('border','1px solid red');
            $('.subject-error').removeClass('d-none');
            $('#make-disabled').prop('disabled',false);
            return false;
        } else if(!product.length){
            $('.product-id').trigger('click');
            $('#make-disabled').prop('disabled',false);
            return false;
        } else if(!description.length) {
            $('#description').addClass('is-invalid');
            $('#make-disabled').prop('disabled',false);
            return false;
        } else if(description.length > 5000) {
            $('#description').addClass('is-invalid');
            $('.description-error').removeClass('d-none');
            $('#make-disabled').prop('disabled',false);
            return false;
        }  else {
            return true;
        }
    });



    $(document).on('change','#forumSelect',function() {
        let product = $('#forumSelect').val();
        let name = $(this).attr('name');
        if (!product) return;
        let url = new URL(window.location.href);
        url.searchParams.set(name, product);
        window.location.href = url;
    });

})
