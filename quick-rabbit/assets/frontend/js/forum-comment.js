$(function () {
  "use strict";
  let base_url = $('input[name="app-url"]').attr("data-app_url");
  let user_id = $('input[name="app-user_id"]').attr("data-app_user_id");
  const isCaptchaEnable = $("#isCaptchaEnable").val();
  if (isCaptchaEnable == 1) {
    var captcha = new Captcha($("#canvas"), {
      length: 5,
    });
  }
  $(document).on("click", "#change-code", function () {
    captcha.refresh();
  });

  $(document).on("click", ".login-alert", function () {
    $(".login_msg").removeClass("d-none");
    $(".login_msg").html(
      `Please Login First. <a href="${base_url}/customer/login">Click here</a> to login.`
    );
  });

  $(document).on("submit", "#submit-comment", function () {
    const comment = $("#comment").val();
    if (isCaptchaEnable == 1) {
      var answer_length = $("#code").val();
      var answer = captcha.valid($('input[name="code"]').val());
    }
    if (!comment.length && comment.trim() === "") {
      $("#comment").addClass("is-invalid");
      $("#comment").focus();
      showNotify("error", "Error!", "Comment field is required!");
      return false;
    } else if (comment.length > 1000) {
      $("#comment").addClass("is-invalid");
      $("#comment").focus();
      showNotify("error", "Error!", "Comment must be less than 1000!");
      return false;
    } else if (isCaptchaEnable == 1 && !answer_length.length > 0) {
      $("#code").css("border", "1px solid red");
      showNotify("error", "Error!", "Captcha code is required!");
      $("#code").val("");
      return false;
    } else if (isCaptchaEnable == 1 && !answer) {
      captcha.refresh();
      $("#captcha-error").removeClass("d-none");
      $("#make-disabled").prop("disabled", false);
      hideSpin("spinner", "make-disabled");
      $("#code").val("");
      return false;
    } else {
      return true;
    }
  });

  function checkLogin() {
    let user_id_hidden = Number($("#user_id_hidden").attr("data-app_user_id"));
    if (!user_id_hidden) {
      $(".login_msg_for_like").removeClass("d-none");
      $(".login_msg_for_like").html(
        `Please Login First. <a href="${base_url}/customer/login">Click here</a> to login.`
      );
    } else {
      return true;
    }
  }

  $(document).on("click", ".vote_btn", function (e) {
    e.preventDefault();
    if (checkLogin()) {
      let status = $(this).attr("data-status");
      let id = $(this).attr("data-id");
      let type = $(this).attr("data-type");
      let current_total = $(this).parent().find("span").text();
      let this_action = $(this);
      $.ajax({
        method: "post",
        url: base_url + "/api/forum-like-unlike-post",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          status: status,
          current_total: current_total,
          brower_id: user_id,
          id: id,
          type: type,
        },
        dataType: "json",
        success: function (response) {
          if (response.status == true) {
            this_action.parent().find("span").text(response.updated_counter);
            showNotify("success", "Success!", "Like added successfully!");
          } else {
            showNotify("error", "Error!", "Already Like Added!");
          }
        },
      });
    }
  });

  // Image Upload
  $(document).on("click", ".attatch_ment_icon", function () {
    $("#imageInput").click();
  });

  $(document).on("change", "#imageInput", function () {
    let fileName = $(this).val().split("\\").pop();
    $("#image_name_show").text(fileName);
  });

  //Reply Comment
  $(document).on("click", "#reply_btn", function (e) {
    $("html, body").animate(
      {
        scrollTop: $(".reply-form").offset().top,
      },
      500
    );

    let name = $(this).attr("data-name");
    $("#comment").html(`replying to ${name}`);
    $("#replying_to").val(`replying to ${name}`);
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
});
