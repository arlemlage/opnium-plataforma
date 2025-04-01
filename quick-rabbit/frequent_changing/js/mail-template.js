(function($){
    "use strict";
    var pointed_on;
    let has_customer_mail_body = $('#has_customer_mail_body').val();
    let has_admin_agent_mail_body = $('#has_admin_agent_mail_body').val();

    if(has_customer_mail_body == 'yes') {
        CKEDITOR.replace( 'customer_mail_body', {
            toolbar: [
                [ 'Bold','Italic','Strike','JustifyLeft','JustifyCenter', 'JustifyRight','NumberedList', 'BulletedList','Outdent','Indent'],
            ]
        });
        CKEDITOR.instances['customer_mail_body'].on('contentDom', function() {
            this.document.on('click', function(event){
                 pointed_on = "customer_mail_body";
             });
        });
        CKEDITOR.addCss(".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}");
    }
    

    if(has_admin_agent_mail_body == "yes") {
        CKEDITOR.replace( 'admin_agent_mail_body', {
            toolbar: [
                [ 'Bold','Italic','Strike','JustifyLeft','JustifyCenter', 'JustifyRight','NumberedList', 'BulletedList','Outdent','Indent'],
            ]
        });
        CKEDITOR.instances['admin_agent_mail_body'].on('contentDom', function() {
            this.document.on('click', function(event){
                 pointed_on = "admin_agent_mail_body";
             });
        });
        CKEDITOR.addCss(".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}");
    }

    $(document).on('click','#customer_mail_subject',function(e) {
        pointed_on = 'customer_mail_subject';
    });

    $(document).on('click','#admin_agent_mail_subject',function(e) {
        pointed_on = 'admin_agent_mail_subject';
    });

   
    $(document).on('click','.parameter',function(e){
        let value = $(this).attr('data-value');
        if(pointed_on === "customer_mail_subject") {
            setParamater('customer_mail_subject',value);
        } else if(pointed_on === "admin_agent_mail_subject") {
            setParamater('admin_agent_mail_subject',value);
        } else if(pointed_on === "customer_mail_body") {
            CKEDITOR.instances['customer_mail_body'].insertHtml(value);
        } else if(pointed_on === "admin_agent_mail_body") {
            CKEDITOR.instances['admin_agent_mail_body'].insertHtml(value);
        } else {
            error("Put your mouse cursor on Mail Subject Or Mail Body first.");
        }
    });

    function setParamater(position,paramater) {
        let cursor_position = document.getElementById(position).selectionStart;
        let target_id = $('#'+position);
        let current_value = target_id.val();
        target_id.val(current_value.slice(0, cursor_position) + paramater + current_value.slice(cursor_position));
    }

})(jQuery);



