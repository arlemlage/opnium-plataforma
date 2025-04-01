$(function () {
    "use strict";
    $('.select2').select2();
    $(document).on('submit','#update-chat-agent',function() {
        let agent_id = $('#agent_id').val();
        if(! agent_id) {
            let op1 = $('#agent_id').data("select2");
            op1.open();
            return false;
        } else {
            return true;
        }
    
    });
});