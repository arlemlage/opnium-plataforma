
(function($){
    "use strict";

    $(document).on('click', '.open_modal_photo', function(e) {
        openModal('photo');
    });
    $(document).on('click', '.close_modal_photo', function(e) {
        closeModal('photo');
    });

    $(document).on('click', '.open_preview_image', function(e) {
        openModal('preview_image');
    });
    $(document).on('click', '.close_preview_image', function(e) {
        closeModal('preview_image');
    });

    $(document).on('keyup', '.first_name', function(e) {
        makeSignature();
    });
    $(document).on('keyup', '.last_name', function(e) {
        makeSignature();
    });

    function makeSignature(){
        let f_name = $('.first_name').val();
        let l_name = $('.last_name').val();
        let company_name = $('#company_name').val();
        let signature = f_name+' '+l_name+'\r\n'+company_name;
        $('.signature').val('');
        $('.signature').val(signature);
    }

    let cropImg = $('.img-container > img');
    let cropper;

    // Initialize the Cropper.js instance
    cropImg.cropper({
        movable: true,
        zoomable: true,
        rotatable: false,
        scalable: false,
        aspectRatio: 100 / 100, // Set the aspect ratio to match the desired width and height
        cropBoxResizable: false, // Disable resizing of the crop box
        dragMode: 'move'
    });

    // Perform the cropping and update the preview
    function performCrop() {
        // Get the cropped canvas
        let croppedCanvas = cropImg.cropper('getCroppedCanvas');

        // Limit the cropped canvas size to a maximum width of 350px and maximum height of 300px
        let croppedWidth = Math.min(100, croppedCanvas.width);
        let croppedHeight = Math.min(100, croppedCanvas.height);

        // Create a new canvas with the limited size
        let resizedCanvas = document.createElement('canvas');
        resizedCanvas.width = croppedWidth;
        resizedCanvas.height = croppedHeight;
        let ctx = resizedCanvas.getContext('2d');
        ctx.drawImage(
            croppedCanvas,
            0,
            0,
            croppedCanvas.width,
            croppedCanvas.height,
            0,
            0,
            croppedWidth,
            croppedHeight
        );

        // Convert the resized canvas to a data URL
        let imgBlob = resizedCanvas.toDataURL();

        // Update the preview with the cropped image
        $('#image_block').addClass('displayNone');
        $('#preview_block').removeClass('displayNone');
        $('#crop-preview').attr('src', imgBlob);
        $('#image_url').val(imgBlob);
        closeModal('crop_image');
    }

    // Call the performCrop function when needed, such as on a button click event
    $('#crop_result').on('click', function() {
        performCrop();
    });

    const sleep = (n) => new Promise(r => setTimeout(r, n));

    function checkImage(){
        let this_file_size_limit = 1;

        let file = document.querySelector('#agent_image').files[0];
        let file_size_required = $("#file_size_required_"+this_file_size_limit).val();
        let ok = $("#ok").val();
        // Check if a file is selected
        if (file) {
            // Get the file size in bytes
            let fileSize = file.size;
            // Convert the file size to megabytes (MB) if needed
            let fileSizeKB = fileSize / 1024;
            let fileSizeMB = fileSizeKB / 1024;
            if(fileSizeMB>this_file_size_limit){
                Swal.fire({
                    icon: 'warning',
                    title: file_size_required,
                    confirmButtonColor: '#7367F0',
                    confirmButtonText: ok,
                    allowOutsideClick: false
                });
                $("#agent_image").val('');
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    async function previewFile() {

        if(checkImage()){
            openModal('crop_image');
            await sleep(500);
            let file   = document.querySelector('#agent_image').files[0];
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
        }
    }
    
    $(document).on('change', '#agent_image', previewFile);

    $(document).on('click', '.close_modal_crop', function(e) {
        closeModal('crop_image');
    });
})(jQuery);
