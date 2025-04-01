(function($){
  "use strict";
  const cropImg = $('.img-container > img');
  cropImg.cropper({
    movable: true,
    zoomable: true,
    rotatable: false,
    scalable: false
  });

  function previewFile() {
    let file    = document.querySelector('#upload').files[0];
    let reader  = new FileReader();
    
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

  $(document).on('change', '#upload', previewFile);
  $('.upload-result').on('click',function(){
		let imgBlob = cropImg.cropper('getCroppedCanvas').toDataURL();
    $('.preview-img').attr('src',imgBlob);
  });

})(jQuery);
