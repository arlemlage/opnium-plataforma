$(function () {
    "use strict";
    let base_url = $('input[name="app-url"]').attr('data-app_url');
    let active_tab = 'group';

    setTimeout(function() {
        let auth_id = $('.auth-user-id').val();
        let active_group = $('.active-group');
        let group_id = active_group.attr('data-id');
        let pair_key = active_group.attr('pair-key');
        $('#message_box').addClass("group_chat_box_"+pair_key); 
        setGroupChaBox(auth_id,group_id,pair_key,true); 
    }, 1000);


    $(document).on('click','#pills-agent-tab',function () {
        active_tab = 'agent';
        displaySingleChatBox();
    });

    $(document).on('click','#pills-customer-tab',function () {
        active_tab = "group";
        displayGroupChatBox();
        
    });

    $(document).on('keyup','#search-agent-group',function() {
        let search_key = sanitizeInput($('#search-agent-group').val());
        if(active_tab == "agent") {
            $.ajax({
               url: base_url+'/chat/search-agent',
               data: {
                search_key: search_key
               },
               method: 'GET',
               success: function(response) {
                $('#pills-agent').html(response);
               }
            });
        } else if(active_tab == "group") {
            $.ajax({
               url: base_url+'/chat/search-group',
               data: {
                search_key: search_key
               },
               method: 'GET',
               success: function(response) {
                $('#pills-customer').html(response);
               }
            });
        }
    });

    // Single chat box fetch
    $(document).on('click','.single-chat-item',function() {
        let auth_id = $('.auth-user-id').val();
        let user_id = $(this).attr('data-id');
        let current_pair_key = $('.active-user').attr('pair-key');
        let new_pair_key = auth_id+'_'+user_id;
        // Remove and set active user design and class
        $(".single-pair-class_"+current_pair_key).removeClass("user-list-active active-user").addClass("unseen-item");
        $(".single-pair-class_"+new_pair_key).addClass("user-list-active active-user").removeClass("unseen-item");
        // Remove and set class for chat box set
        $('#message_box').addClass("single_chat_box_"+new_pair_key).removeClass("single_chat_box_"+current_pair_key);
        setSingleChatBox(auth_id,user_id,new_pair_key,false) // Set single chat box

    });

    // Group chat box fetch
    $(document).on('click','.group-chat-item',function() {
        let auth_id = $('.auth-user-id').val();
        let group_id = $(this).attr('data-id');
        let current_pair_key = $('.active-group').attr('pair-key');
        let new_pair_key = auth_id+'_'+group_id;
        // Remove and set active user design and class
        $(".group-pair-class_"+current_pair_key).removeClass("user-list-active active-group").addClass("unseen-item");
        $(".group-pair-class_"+new_pair_key).addClass("user-list-active active-group").removeClass("unseen-item");
        // Remove and set class for chat box set
        $('#message_box').addClass("group_chat_box_"+new_pair_key).removeClass("group_chat_box_"+current_pair_key);
        setGroupChaBox(auth_id,group_id,new_pair_key,false); // Set group chat box
    });

    function displaySingleChatBox(){
        let auth_id = $('.auth-user-id').val();
        let has_friend = getUserHasFriend();
        if(has_friend) {
            let last_chat_id = getLastSingleChatId();
            if(last_chat_id === "no-message") {
                let active_div = $('.active-user');
                let user_id = active_div.attr('data-id');
                let pair_key = active_div.attr('pair-key');
                $('#message_box').addClass("single_chat_box_"+pair_key);
                setSingleChatBox(auth_id,user_id,pair_key,false) // Set single chat box
            } else {
                let current_pair_key = $('.active-user').attr('pair-key');
                let new_pair_key = auth_id+'_'+last_chat_id;
                $(".single-pair-class_"+current_pair_key).removeClass("user-list-active active-user").addClass("unseen-item");
                $(".single-pair-class_"+new_pair_key).addClass("user-list-active active-user").removeClass("unseen-item");
                // Remove and set class for chat box set
                $('#message_box').addClass("single_chat_box_"+new_pair_key);
                setSingleChatBox(auth_id,last_chat_id,new_pair_key,true) // Set single chat box
            }
        } else {
            $('#message_box').empty();
            return false;
        }
    }

    function displayGroupChatBox(){
        let auth_id = $('.auth-user-id').val();
        let has_group = getUserHasGroup();
        if(has_group) {
            let last_chat_id = getLastGroupChatId();
            if (last_chat_id === "no-message") {
                let active_group = $('.active-group');
                let group_id = active_group.attr('data-id');
                let pair_key = active_group.attr('pair-key');
                $('#message_box').addClass("group_chat_box_"+pair_key);
                setGroupChaBox(auth_id,group_id,pair_key,false);
            } else {
                let pair_key = auth_id+'_'+last_chat_id;
                let current_pair_key = $('.active-group').attr('pair-key');
                $(".group-pair-class_"+current_pair_key).removeClass("user-list-active active-group").addClass("unseen-item");
                $(".group-pair-class_"+pair_key).addClass("user-list-active active-group").removeClass("unseen-item");
                $('#message_box').addClass("group_chat_box_"+pair_key); // Remove and set class for chat box set
                setGroupChaBox(auth_id,last_chat_id,pair_key); // Set group chat box
            }
        } else {
            $('#message_box').empty();
            return false;
        }
    }

    function setGroupChaBox(auth_id,group_id,pair_key,is_prepend=true) {
        // Send ajax request to get chat box
        $.ajax({
            method: 'GET',
            url: base_url+'/chat/group-chat-box',
            data: {
                group_id: group_id
            },
            success: function(response) {
                $('.group_chat_box_'+pair_key).html(response); // Set chat box on messages
                // Chat scroll on bottom
                if (is_prepend) {
                    $('.group-chat-users_'+auth_id).prepend($(".group-pair-class_"+pair_key)).animate('slow');
                }
                let group_chat_last_message = $('#group-chat-messages_'+pair_key);
                if(group_chat_last_message.length > 0) {
                    group_chat_last_message.scrollTop(group_chat_last_message[0].scrollHeight);
                }
            }
        });
    }

    function setSingleChatBox(auth_id,user_id,pair_key,is_prepend=true) {
        // Send ajax request to get chat box
        $.ajax({
            method: 'GET',
            url: base_url+'/chat/single-chat-box',
            data: {
                user_id: user_id
            },
            success: function(response) {
                $('.single_chat_box_'+pair_key).html(response); // Set chat box on messages
                // Chat scroll on bottom
                if(is_prepend) {
                    $('.single-chat-users_'+auth_id).prepend($(".single-pair-class_"+pair_key)).animate('slow');
                }
                let single_chat_last_message = $('#single-chat-messages_'+pair_key);
                if(single_chat_last_message.length > 0) {
                    single_chat_last_message.scrollTop(single_chat_last_message[0].scrollHeight);
                }
            }
        });
    }

    function getLastSingleChatId() {
        let last_chat_id = '';
        $.ajax({
            method: 'GET',
            async: false,
            url: base_url+'/chat/get-user-single-chat-id',
            success: function(response) {
                last_chat_id = response;
            }
        });
        return last_chat_id;
    }

    function getUserHasFriend() {
        let has_group = false;
        $.ajax({
            method: 'GET',
            url: base_url+'/chat/check-user-has-friend',
            async: false,
            success: function (response) {
                has_group = response
            }
        });
        return has_group;
    }

    function getUserHasGroup() {
        let has_group = false;
        $.ajax({
            method: 'GET',
            url: base_url+'/chat/check-user-has-group',
            async: false,
            success: function (response) {
                has_group = response
            }
        });
        return has_group;
    }

    function getLastGroupChatId() {
        let last_chat_id = '';
        $.ajax({
            method: 'GET',
            async: false,
            url: base_url+'/chat/get-user-group-chat-id',
            success: function(response) {
                last_chat_id = response;
            }
        });
        return last_chat_id;
    }

    $(document).on('submit','#customer-group-create-form',function() {
        let product_id = $('#product_id').val();
       
        if(! product_id) {
            let op1 = $('#product_id').data("select2");
            op1.open();
            return false;
        } else {
            return true;
        }
    });
    $(document).on('click','#close-chat-',function() {
        Swal.fire({
          title: 'Are you sure?',
          text: "You want to close this chat",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, close it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $('#close-chat-form').submit();
          }
        })
    });

    $(document).on('click','#forward-chat-button',function() {
        let agent_id = $('#agent_id').val();
        if(! agent_id) {
            let op1 = $('#agent_id').data("select2");
            op1.open();
            return false;
        } else {
            $('.forward-chat-add-edit-spin').removeClass('d-none');
            $('#forward-chat-button').prop("disabled", true);
            let formData = {
                group_id : $('#group_id').val(),
                agent_id : $('#agent_id').val()
            }
            $.ajax({
                method: 'GET',
                url: base_url+'/chat/forward-chat',
                data: formData,
                success: function(response) {
                    location.reload();
                }
            });
        }
       
    });


    $(document).on('click','.pre_sale_after_sale_btn',function() {
        let this_button_text = $(this).text();
        $(".message-box_text_box").val(this_button_text);
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

       let auth_id = localStorage.getItem('auth_id');
       let group_id = $('#group_id').val();
       let pair_key = auth_id + '_' + group_id;

       $.ajax({
           url: base_url+'/api/envato-validation',
           type: 'GET',
           data: form_data,
           dataType:'json',
           success: function(data){
              if(data.status==true){
               successValidation();
               this_action.parent().find(".envato_err").text('');
               this_action.text("Verified");
              }else{
               this_action.parent().find(".envato_err").text(data.message);
               this_action.removeClass("verified");
               this_action.text("Verify Now");
               $('#group-chat-messages_' + pair_key).scrollTop($('#group-chat-messages_' + pair_key)[0].scrollHeight);
              }

           }
       }); 
   }
   $(document).on('click','.yes_no_btn',function(e) {
       e.preventDefault();
       let this_button_text = $(this).text();
       if(this_button_text=="Yes"){
           this_button_text = "Yes, I got that answer."
       }else{
           this_button_text = "No, I need agent support."
       }
       $(".message-box_text_box").val(this_button_text);
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
   
});
