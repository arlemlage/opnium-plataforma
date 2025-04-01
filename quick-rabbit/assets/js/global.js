"use strict";
// we skip use strict here due to global call
function makeMatchingBold(target_string, target_class) {
  $("." + target_class).each(function () {
    $(this).data("original", $(this).text());
  });
  let search_string = target_string.toLowerCase();
  let length = target_string.length;

  $("." + target_class).each(function () {
    let text = $(this).data("original"),
      textL = text.toLowerCase(),
      index = textL.indexOf(search_string);

    if (index !== -1) {
      let htmlR =
        text.substr(0, index) +
        "<b>" +
        text.substr(index, length) +
        "</b>" +
        text.substr(index + length);
      $(this).html(htmlR).show();
      return true;
    } else {
      return false;
    }
  });
}

function matchingBold(target_string) {
  // Replace the search term with the same term wrapped in a bold tag
  $(".match_bold").each(function () {
    let text = $(this).text();
    let highlightedText = text.replace(
      new RegExp(target_string, "gi"),
      "<b>$&</b>"
    );
    $(this).html(highlightedText);
  });
}

function highLightColor(target_string) {
  // Replace the search term with the same term wrapped in a bold tag
  $(".make_color").each(function () {
    let text = $(this).text();
    let highlightedText = text.replace(
      new RegExp(target_string, "gi"),
      "<b style='color: #36405e !important;'>$&</b>"
    );
    $(this).html(highlightedText);
  });
}

function getUserIp() {
  let original_ip = localStorage.getItem("user_ip");
  return original_ip.replaceAll(".", "-");
}

let is_submit = $("#is_submit").val();
let please_wait = $("#please_wait").val();
let submit_text =
  '<i class="fa fa-spinner fa-spin me-2 ticket-add-edit-spin d-none"></i>' +
  is_submit;
let please_wait_text =
  '<i class="fa fa-spinner fa-spin me-2 ticket-add-edit-spin"></i>' +
  please_wait;

function showSpin(spinner, button) {
  localStorage.setItem("button_html", $("#" + button).html());
  let please_wait_text_this_button =
    '<i class="fa fa-spinner fa-spin me-2 ' + spinner + '"></i>' + please_wait;
  $("." + spinner).removeClass("d-none");
  $("#" + button).addClass("no_accss");
  $("#" + button).html(please_wait_text_this_button);
}

function hideSpin(spinner, button) {
  $("." + spinner).addClass("d-none");
  let old_text_this_button = localStorage.getItem("button_html");
  $("#" + button).html(old_text_this_button);
  $("#" + button).removeClass("no_accss");
}

function showSpinTicektAdd(spinner, button) {
  $("." + spinner).removeClass("d-none");
  $("#" + button).html(please_wait_text);
  $("#" + button).addClass("no_accss");
}

function hideSpinTicektAdd(spinner, button) {
  $("." + spinner).addClass("d-none");
  $("#" + button).html(submit_text);
  $("#" + button).removeClass("no_accss");
}

$(document).on("change", ".file_checker_global", function () {
  let this_file_size_limit = Number($(this).attr("data-this_file_size_limit"));

  let file = this.files[0];
  let file_size_required = $(
    "#file_size_required_" + this_file_size_limit
  ).val();
  let ok = $("#ok").val();
  // Check if a file is selected
  if (file) {
    // Get the file size in bytes
    let fileSize = file.size;
    // Convert the file size to megabytes (MB) if needed
    let fileSizeKB = fileSize / 1024;
    let fileSizeMB = fileSizeKB / 1024;
    if (fileSizeMB > this_file_size_limit) {
      Swal.fire({
        icon: "warning",
        title: file_size_required,
        confirmButtonColor: "#7367F0",
        confirmButtonText: ok,
        allowOutsideClick: false,
      });
      $(this).val("");
    }
  }
});
