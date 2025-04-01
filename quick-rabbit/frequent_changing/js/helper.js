"use strict";
/*
    Common helper js functions to use all file
 */
let app_url = $('input[name="app-url"]').attr("data-app_url");

function common_lan() {
  let common_lan = "";
  $.ajax({
    method: "GET",
    url: app_url + "/api/common-lang",
    async: false,
    success: function (response) {
      common_lan = response;
    },
  });
  return common_lan;
}
/**
 * Display sweetalert confirmation
 */
$(document).ready(function () {
  let warning = $("#warning").val();
  let a_error = $("#a_error").val();
  let ok = $("#ok").val();
  let cancel_text = $("#cancel_text").val();
  let are_you_sure = $("#are_you_sure").val();
  let cannot_revert = $("#cannot_revert").val();

  $(".deleteRow").click(function (e) {
    e.preventDefault();
    let this_class = $(this).attr("data-form_class");
    let message = $(this).attr("data-message");
    warnBeforeRedirect(this_class, message);
  });

  function warnBeforeRedirect(linkURL, message = cannot_revert) {
    Swal.fire({
      title: are_you_sure,
      text: message,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: ok,
      cancelButtonText: $("#cancel_text").val(),
    }).then((result) => {
      if (result.isConfirmed) {
        $("." + linkURL).submit();
      }
    });
  }
});

/**
 * Open a modal
 */
function openModal(modal) {
  $("#" + modal).modal("show");
}

/**
 * Close a modal
 */
function closeModal(modal) {
  $("#" + modal).modal("hide");
}

/**
 * Display error as modal
 */
function error(message) {
  Swal.fire({
    icon: "error",
    title: message,
  });
}

/**
 * Convert image size
 */
function bytesToSize(bytes) {
  let sizes = ["Bytes", "KB", "MB", "GB", "TB"];
  if (bytes === 0) return "0 Byte";
  let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
  return Math.round(bytes / Math.pow(1024, i), 2);
}

//auto scroll on active menu
$(window).on("load", function () {
  // Get the active link in the sidebar
  const activeLink = $(".sidebar-menu li.active");

  // Check if the active link exists
  if (activeLink.length) {
    // Get the top offset of the active link
    const offsetTop = activeLink.offset().top - 400;

    $(".sidebar-menu").animate(
      {
        scrollTop: offsetTop,
      },
      1000
    );
  }
});
