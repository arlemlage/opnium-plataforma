(function($){
    "use strict";
    //App Url
    let app_url = $('input[name="app-url"]').attr('data-app_url');

    let config = {
        extraPlugins: 'codesnippet',
        codeSnippet_theme: 'monokai_sublime',
         removeButtons: 'HorizontalRule,SpecialChar,Source,Save,Preview,NewPage,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,CreateDiv,BidiLtr,BidiRtl,Language,Flash,Smiley,Iframe,ShowBlocks,About',
    };
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.addCss(".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}");
    CKEDITOR.replace('page_content', config);

    $(document).on('click', '.open_modal_tag', function(e) {
        openModal('add_tag');
    });
    $(document).on('click', '.close_modal_tag', function(e) {
        closeModal('add_tag');
    });

    $(document).on('click', '.add_new_tag', function () {
        let title = $('#tag_title').val();
        if(title == "") {
            $('#title-error').removeClass('displayNone');
            return false;
        } else {
            let form_data = {
                title: title,
                description: $('#tiny_tag').val(),
                selected_tag_ids: $('#selected_tag_ids').val(),
            };
            $.ajax({
                url: app_url+"/tag",
                type: 'POST',
                data: form_data,
                success: function(data){
                    if (data.status==1){
                        $('#tag_title').val('');
                        $('#tiny_tag').val('');
                        $('.ajax_data_field_alert').empty();
                        toastr.success(data.msg);

                        $('#tags').empty();
                        $.each(data.all_tag_options, function (index, val) {
                            $('#tags').append(val);
                        });
                        $('#selected_tag_ids').val(data.selected_tag_ids);
                        $('#title-error').hide();
                        closeModal('add_tag');
                    }else if((data.status==0)) {
                        $('.ajax_data_field_alert').empty();
                        $('.ajax_data_field_alert').text(data.msg);
                        toastr.error(data.msg);
                    }
                }
            });
        }
    });

    $(document).on('change', '#tags', function () {
        $('#selected_tag_ids').val($(this).val());
    });

     $(document).on('change','#product_category_id',function() {
        let product_category_id = $('#product_category_id').val();
        $('#article_group_id') .find('option') .remove() .end() .append('<option value="">Select</option>');
        $.ajax({
            method: 'GET',
            url: app_url+"/api/product-wise-groups/"+product_category_id,
            success: function(response){
                let list = response;
                let select = document.getElementById("article_group_id");
                let i = 0;
                for(i = 0; i < list.length ;i ++){
                    let el = document.createElement("option");
                    let group = list[i];
                    let grouptitle = group.title;
                    let groupId = group.id;
                    el.textContent = grouptitle;
                    el.value = groupId;
                    select.appendChild(el);
                }
            }
        });
    });
    let product_category_id = $('#product_category_id').val();
    $.ajax({
        method: 'GET',
        url: app_url+"/api/product-wise-groups/"+product_category_id,
        success: function(response){
            let list = response;
            let select = document.getElementById("article_group_id");
            let i = 0;
            for(i = 0; i < list.length ;i ++){
                let el = document.createElement("option");
                let group = list[i];
                let grouptitle = group.title;
                let groupId = group.id;
                el.textContent = grouptitle;
                el.value = groupId;
                select.appendChild(el);
            }
        }
    });

    setTimeout(function() {
        hideCKEditorButtons();
    }, 1000);
    function hideCKEditorButtons() {
        $('.cke_button__image ').css('display','none');
    }

})(jQuery);
