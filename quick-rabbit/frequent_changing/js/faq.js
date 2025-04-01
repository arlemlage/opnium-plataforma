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
    CKEDITOR.replace('answer', config);

    $(document).on('click', '.open_modal_tag', function(e) {
        openModal('add_tag');

    });
    $(document).on('click', '.close_modal_tag', function(e) {
        closeModal('add_tag');
    });



    $(document).ready(function() {
        setTimeout(function() {
            hideCKEditorButtons();
        }, 1000);
    });

    function hideCKEditorButtons() {
        $('.cke_button__image ').css('display','none');
    }

    $(document).on('click', '.add_new_tag', function () {
        showSpin('tag-spinner','submit-tag');
        let title = $('#tag_title').val();
        if(title == "") {
            $('#title-error').removeClass('displayNone');
            hideSpin('tag-spinner','submit-tag');
            return false;
        } else if($('#tag_title').val().length > 50) {
            hideSpin('tag-spinner','submit-tag');
            $('#title-error').removeClass('displayNone').text($('#title_max_50').val());
        }else {
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
                        hideSpin('tag-spinner','submit-tag');
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
                        hideSpin('tag-spinner','submit-tag');
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
})(jQuery);
