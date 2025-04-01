(function ($) {
  "use strict";
  let app_url = $('input[name="app-url"]').attr("data-app_url");

  $(document).on("click", ".open_common_image_modal", function (e) {
    openModal("commonImage");
  });
  $(document).on("click", ".close_common_image_modal", function (e) {
    closeModal("commonImage");
  });
  $(document).on("click", ".open_preview_image", function (e) {
    openModal("preview_image");
  });
  $(document).on("click", ".close_preview_image", function (e) {
    closeModal("preview_image");
  });
  $(document).on("click", ".close_modal_crop", function (e) {
    closeModal("crop_image");
  });

  let cropImg = $(".img-container > img");
  let cropper;

  // Initialize the Cropper.js instance
  cropImg.cropper({
    movable: true,
    zoomable: true,
    rotatable: false,
    scalable: false,
    aspectRatio: 770 / 421,
    cropBoxResizable: false,
    dragMode: "move",
    minCropBoxWidth: 770,
    minCropBoxHeight: 421,
  });

  // Perform the cropping and update the preview
  function performCrop() {
    // Get the cropped canvas
    let croppedCanvas = cropImg.cropper("getCroppedCanvas", {
      width: 770,
      height: 421,
      minWidth: 770,
      minHeight: 421,
    });

    // Convert the cropped canvas to a data URL
    let imgBlob = croppedCanvas.toDataURL();

    // Update the preview with the cropped image
    $("#image_block").addClass("displayNone");
    $("#preview_block").removeClass("displayNone");
    $("#crop-preview").attr("src", imgBlob);
    $("#image_url").val(imgBlob);
    closeModal("crop_image");
  }

  // Call the performCrop function when needed, such as on a button click event
  $("#crop_result").on("click", function () {
    performCrop();
  });

  const sleep = (n) => new Promise((r) => setTimeout(r, n));

  async function previewFile() {
    openModal("crop_image");
    await sleep(500);
    let file = document.querySelector("#profile_photo").files[0];
    let reader = new FileReader();
    reader.onloadend = function () {
      $(".img-container > img").show();
      cropImg.cropper("replace", reader.result);
    };
    if (file) {
      reader.readAsDataURL(file);
    } else {
      cropImg.cropper("replace", "");
    }
  }

  $(document).on("change", "#profile_photo", previewFile);
})(jQuery);
