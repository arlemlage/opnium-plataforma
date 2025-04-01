(function ($) {
  "use strict";
  let page_name = $("#page-name").val();

  $(document).on("change", "#group", function (e) {
    if (page_name != undefined && page_name == "media-list") {
      let link = $("#group").val();
      if (link) {
        location.href = link;
      }
    }
  });
  $(document).on("click", ".add_file", function (e) {
    openModal("add_media_file");
  });
  $(document).on("click", ".close_modal", function (e) {
    closeModal("add_media_file");
  });

  function show_hide_button() {
    let media_path = $("#media_path").val();
    let media_path_old = $("#media_path_old").val();
    let tmp_path = "";
    if (media_path) {
      tmp_path = media_path;
    } else {
      tmp_path = media_path_old;
    }
    if (media_path || media_path_old) {
      $("#set_image_src").attr("src", tmp_path);
      $(".viw_file_td").show();
    } else {
      $(".viw_file_td").hide();
    }
  }

  setTimeout(function () {
    show_hide_button();
  }, 300);

  const cropImg = $(".img-container > img");
  cropImg.cropper({
    movable: true,
    zoomable: true,
    rotatable: false,
    scalable: false,
  });
  // Trigger file input when button is clicked
  $("#browse-files").on("click", function () {
    $("#upload").click();
  });

  $(".cancel_button").on("click", function () {
    cropImg.cropper("replace", "");
    $(".img-container").addClass("displayNone");
    $(".upload-area").show();
  });

  function previewFile() {
    let file = document.querySelector("#upload").files[0];
    let reader = new FileReader();
    reader.onloadend = function () {
      $(".img-container").removeClass("displayNone");
      $(".img-container > img").show();
      cropImg.cropper("replace", reader.result);
      $(".upload-area").hide();
    };
    if (file) {
      reader.readAsDataURL(file);
    } else {
      cropImg.cropper("replace", "");
    }
    let title = $(".title").val();
    if (title == "") {
      let tmp_title = this.files[0].name.split(".");
      $(".title").val(tmp_title[0]);
    }
  }

  $(document).on("change", "#upload", previewFile);
  $(".upload-result").on("click", function () {
    let imgBlob = cropImg.cropper("getCroppedCanvas").toDataURL();
    $(".viw_file").show();
    $("#media_path").val(imgBlob);
    $("#set_image_src").attr("src", imgBlob);
    show_hide_button();
    closeModal("add_media_file");
  });

  $(".popup-with-move-anim").magnificPopup({
    type: "inline",
    fixedContentPos: false,
    fixedBgPos: true,
    overflowY: "auto",
    closeBtnInside: true,
    preloader: false,
    midClick: true,
    removalDelay: 300,
    mainClass: "my-mfp-slide-bottom",
  });

  var isUpload = true;

  if (isUpload) {
    var $form = $(".upload-area");
    var droppedFiles = false;
    $form.on(
      "drag dragstart dragend dragover dragenter dragleave drop",
      function (e) {
        e.preventDefault();
        e.stopPropagation();
      }
    );
    $form
      .on("dragover dragenter", function () {
        $form.addClass("is-dragover");
      })
      .on("dragleave dragend drop", function () {
        $form.removeClass("is-dragover");
      })
      .on("drop", function (e) {
        droppedFiles = e.originalEvent.dataTransfer.files;
        $("#upload")[0].files = droppedFiles;
        previewFile();
      });
  }
})(jQuery);
