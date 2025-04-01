$(function () {
  "use strict";
  const isCaptchaEnable = $("#isCaptchaEnable").val();
  if (isCaptchaEnable == 1) {
    var captcha = new Captcha($("#canvas"), {
      length: 5,
    });
  }

  $(document).on("submit", "#blog-comment", function () {
    const comment = $("#comment").val();
    const name = $("#name").val();
    if (isCaptchaEnable == 1) {
    var answer_length = $("#code").val();
    var answer = captcha.valid($('input[name="code"]').val());
    }
    if (!name.length && name.trim() === "") {
      $("#name").addClass("is-invalid");
      showNotify("error", "Error!", "Name Field is required!");
      return false;
    } else if (name.length > 1000) {
      $("#name").addClass("is-invalid");
      showNotify("error", "Error!", "Name must be less then 1000 characters!");
      hideSpin("spinner", "make-disabled");
      return false;
    } else if (!comment.length && comment.trim() === "") {
      $("#comment").focus();
      $("#comment").addClass("is-invalid");
      showNotify("error", "Error!", "Comment field is required!");
      return false;
    } else if (comment.length > 1000) {
      $("#comment").addClass("is-invalid");
      showNotify(
        "error",
        "Error!",
        "Comment must be less then 1000 characters!"
      );
      return false;
    } else if (isCaptchaEnable == 1 && !answer_length.length > 0) {
      $("#code").css("border", "1px solid red");
      showNotify("error", "Error!", "Captcha code field is required!");
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

  $(document).on("click", "#change-code", function () {
    captcha.refresh();
  });

  $(document).on("click", "#reply_btn", function (e) {
    $("html, body").animate(
      {
        scrollTop: $(".reply-form").offset().top,
      },
      500
    );

    let name = $(this).attr("data-name");
    $("#comment").html("replying to " + name);
  });
});
