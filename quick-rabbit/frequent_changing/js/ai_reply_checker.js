(function($){
    "use strict";
    let app_url = $('input[name="app-url"]').attr('data-app_url');
    
    function setAiReply(ticket_id,p_id) {
        $.ajax({
            url: app_url+'/set-ai-reply/',
            method: 'GET',
            dataType:"json",
            data: {"ticket_id":ticket_id,p_id:p_id},
            success: function(response) {
                if(response.msg){
                    setTimeout(function(){ 
                        $(".loader-img").hide();
                        $(".card_title_h2").hide();
                        $(".ai_reply_success").show();
                        $(".ai_reply_success").html(response.msg);
                     }, 10000);
                }
            }
        });
    }
let ticket_id = $("#ticket_id").val();
let p_id = $("#p_id").val();
    setAiReply(ticket_id,p_id);

})(jQuery);
