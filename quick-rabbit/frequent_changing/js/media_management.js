(function($){
    "use strict";

    let app_url = $('input[name="app-url"]').attr('data-app_url');
    let pageAt = $('#page-at').val();

    $(document).on('click', '.open_media_modal', function(e) {
        openModal('media_modal');
    });
    $(document).on('click', '.close_media_modal', function(e) {
        $(".cr-image").attr("src",'');
        closeModal('media_modal');
    });

    const cropImg = $('.img-container > img');
    cropImg.cropper({
        movable: true,
        zoomable: true,
        rotatable: false,
        scalable: false
    });

    function scrallBottom(){
        $("#media_modal").animate({
            scrollTop: $("#media_modal").get(0).scrollHeight
            }, 1000);
        
    }
    function media_body_animation(){
        setTimeout(function(){
            $(".media_body").animate({
                scrollTop: $(".media_body").get(0).scrollHeight
                }, 1000);
         }, 1000); 
    }
    $(document).on('click', '#nav-profile-tab', function(e) {
        media_body_animation();
    });
    // Trigger file input when button is clicked
    $('#browse-files').on('click', function () {
        alert('clicked');
        $('#upload').click();
    });

    function previewFile() {
        scrallBottom();
        let file   = document.querySelector('#upload').files[0];
        let reader = new FileReader();
        reader.onloadend = function () {
            $('.img-container > img').show(); 
            cropImg.cropper('replace',reader.result);
        }
        if (file) {
          reader.readAsDataURL(file);
        } else {
            cropImg.cropper('replace','');
        }
        let tmp_title = (this.files[0].name).split(".");
        if($('#media-title').val() == "") {
            $("#media-title").val(tmp_title[0]);
        }
        reader.readAsDataURL(this.files[0]);
    }
    
    $(document).on('change', '#upload', previewFile);

    $(document).on('click', '.upload-result', function (ev) {
        let title = $('#media-title').val();
        let group = $('#media-group').val();
        let media_file = $('#upload').val();
        if(title == "") {
            $('#media-title').focus();
            $('.media-title-error').removeClass('displayNone');
            return false;
        } 
        if(title.length > 250) {
            $('.media-title-error').removeClass('displayNone').text($('#title_max_250').val());
            return false;
        }
        if(group == "") {
            $('#media-group').data("select2").focus();
            $('#media-group').siblings(".select2-container").css({
                'border':'1px solid red',
                'border-radius': '4px'
            });
            $('.media-group-error').removeClass('displayNone');
            return false;
        } if(media_file == "") {
            $('#upload').focus();
            $('.media-file-error').removeClass('displayNone');
            return false;
        } else {
            let selected_image =  $("#upload").val();
            if(selected_image==''){
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select an image!',
                    confirmButtonColor: '#36405E',
                    cancelButtonText: 'Cancel',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok',
                });
                return false;
            } else {
                showSpin('media-spinner','upload-media');
                let imgBlob = cropImg.cropper('getCroppedCanvas').toDataURL();
                $.ajax({
                    method: 'POST',
                    url: app_url+"/store-on-media",
                    data: {
                        "image" : imgBlob,
                        "title" : $('#media-title').val(),
                        'group' : $('#media-group').val()
                    },
                    success: function (response) {
                        let img_src = app_url+'/'+response.thumb_img;
                        let data_src = app_url+'/'+response.media_path;
                        $('#selected_src').val(data_src);
                        $('.cursor-pointer').removeClass('border-blue');
                        let append_div = `<div class="file_media cursor-pointer border-blue col-xl-2 col-lg-2 col-md-3 col-sm-4" data-src="${data_src}">
                            <figure>
                            <img src="${img_src}" class="img-fluid p-1">
                            <figcaption class="text-truncate">
                                <small class="media_title_text">
                                    ${response.title}
                                </small>
                            </figcaption>
                            </figure>
                        </div>`;

                        $('.media_files').append(append_div);
                        $('#nav-profile-tab').trigger('click');
                        $("#media-title").val('');
                        $("#upload").val('');
                        $("#media-group").val('').change();
                        $("#media-upload-form").find(".img-fluid").attr("src",'');
                        $(".cropper-bg").remove();

                        media_body_animation();


                        hideSpin('media-spinner','upload-media');
                        closeModal('add_media_file');
                    }
                });
            }
        }
    });

    $(document).on('click','.cancle_media',function() {
        $('#media-title').val("");
        $('#media-group').val("");
        $(".cr-image").attr("src",'');
        closeModal('media_modal');
    });

    $(document).on('click','.cursor-pointer',function(){
        $('.cursor-pointer').removeClass('border-blue');
        $(this).addClass('border-blue');
        let selected_src = $('.border-blue').attr('data-src');
        $('#selected_src').val(selected_src);
    });

    $(document).on('click','#insert_media',function(){
        let img_src = $('#selected_src').val();
        let media = `<img src="${img_src}">`;

        isertToEditor(media);
        $('.close_media_modal').trigger('click');
    });

    $(document).on('click','#file_insert_btn',function() {
        let img_src = $('#file_url').val();
        if(img_src == "") {
             $('#file_url_error').removeClass("display-none");
            return false;
        } else {
             $('#file_url_error').addClass("display-none");
            let media = `<img src="${img_src}" class="img-fluid p-1" alt="">`;
            isertToEditor(media);
            $('#file_url').val('');
            $('.close_media_modal').trigger('click');
        }
    });

    $(document).on('click','#video_insert_btn',function() {
        let video_src = $('#video_url').val();
        $('#hidden_video_url').val(video_src);
        if(video_src == "") {
             $('#video_error').removeClass("display-none");
            return false;
        } else {
             $('#video_error').addClass("display-none");
             let video_id = getVideoId(video_src);
            let embed_src = "https://www.youtube.com/embed/"+video_id;
            let media = `<iframe width="100%" height="315"  src="${embed_src}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
            isertToEditor(media);
            $('#video_url').val('');
            $('.close_media_modal').trigger('click');
        }
    });

    function getVideoId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url?.match(regExp);
        return (match && match[2].length === 11)
          ? match[2]
          : null;
    }


    $(document).on('change','#media_group',function() {
        let title = $('#media_title').val();
        let group = $('#media_group').val();
        filterMedia(title,group);
    });
    $(document).on('keyup','#media_title',function() {
        let title = $('#media_title').val();
        let group = $('#media_group').val();
        if(title.length>=3 && title){
            filterMedia(title,group);
        }else if(title==''){
            filterMedia(title,group);
        }
    });

    function filterMedia(title,group) {
        let query = {
            title: title,
            group: group
        };
        $.ajax({
            method: 'GET',
            url: app_url+'/api/filter-media',
            data: query,
            success: function(response) {
                $('.cursor-pointer').removeClass('border-blue');
                $('.media_files').empty().html(response);
                makeMatchingBold(title,'media_title_text');
            }
        });
    }

    function isertToEditor(media) {
        if(pageAt == "articles") {
            CKEDITOR.instances.page_content.filter.check( 'iframe' );
            CKEDITOR.instances.page_content.insertHtml(media);
        } else if(pageAt == "blog") {
            CKEDITOR.instances.blog_content.filter.check( 'iframe' );
            CKEDITOR.instances.blog_content.insertHtml(media);
        } else if(pageAt == "pages") {
            CKEDITOR.instances.page_content.filter.check( 'iframe' );
            CKEDITOR.instances.page_content.insertHtml(media);
        }
        $('.cursor-pointer').removeClass('border-blue');
    }

})(jQuery);
