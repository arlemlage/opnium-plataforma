(function($){
    "use strict";
    let app_url = $('input[name="app-url"]').attr('data-app_url');

    CKEDITOR.replace( 'description', {
        toolbar: [
            [ 'Bold','Italic','Strike','JustifyLeft','JustifyCenter', 'JustifyRight','NumberedList', 'BulletedList','Outdent','Indent'],
        ]
    });
    CKEDITOR.addCss(".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}");

    $(document).on('click', '.open_modal_photo', function(e) {
        openModal('product_photo');
    });
    $(document).on('click', '.close_modal_photo', function(e) {
        closeModal('product_photo');
    });

    //on change product_category--check relevant verification field
    $( document ).on('change','#verification',function(){
        let verification_type = $(this).val();
        if (verification_type == 1){
            $('.envato_product_code_field').removeClass('d-none');
            $('.envato_product_code').prop('required', true);
        }else {
            $('.envato_product_code_field').addClass('d-none');
            $('.envato_product_code').prop('required', false);
        }
    });

    $(document).on('change', '#photo_thumb_', function () {
        let reader = new FileReader();
        reader.onload = function (e) {
            uploadCrop.croppie('bind', {
                url: e.target.result
            });
        }
        reader.readAsDataURL(this.files[0]);
        openModal('crop_image');
    });

    let uploadCrop = $('#img-div').croppie({
        enableExif: true,
        viewport: {
            width: 80,
            height: 80,
            type: 'square'
        },
        boundary: {
            width: 130,
            height: 130
        }
    });

    $(document).on('click','#crop_result',function() {
        uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (result) {
            $.ajax({
                method: 'POST',
                url: app_url+"/bas64-to-image",
                data: {"image":result},
                success: function (response) {
                    $('#photo_thumb').val('');
                    $('#image_url').val(response);
                    $('#image_block').addClass('displayNone');
                    $('#preview_block').removeClass('displayNone');
                    $('#crop-preview').attr('src',app_url+'/'+response);
                    $('.modal-trash').removeClass('displayNone');
                    closeModal('crop_image');
                }
            });
        });
    });

    $(document).on('click', '.open_preview_image', function(e) {
        openModal('preview_image');
    });
    $(document).on('click', '.close_preview_image', function(e) {
        closeModal('preview_image');
    });

    $(document).on('click','.modal-trash',function() {
        let image_url = $('#image_url').val();
        axios.delete(app_url+'/delete-image?image_url='+image_url).then((response) => {
            $('#image_url').val("");
            $('.modal-trash').addClass('displayNone');
            $('#crop-preview').attr('src','');
            $('#preview_block').addClass('displayNone');
            $('#image_block').removeClass('displayNone');
            $('.close_preview_image').trigger('click');
        });
    });


    $(document).on('click', '.close_modal_crop', function(e) {
        closeModal('crop_image');
    });

    $(document).on('keyup','#title',function() {
        let title = $('#title').val();
        if(title.length) {
            $.ajax({
                url: app_url+"/api/get-product-code",
                method: 'GET',
                data: {
                 title: title
                },
                success: function(response) {
                 $('#product_code').val(response);
                }
            });
        } else {
            $('#product_code').val('');
        }
        
    });

   
})(jQuery);
