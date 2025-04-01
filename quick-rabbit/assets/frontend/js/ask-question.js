$(function () {
  "use strict";
  const isCaptchaEnable = $("#isCaptchaEnable").val();
  if (isCaptchaEnable == 1) {
    var captcha = new Captcha($("#canvas"), {
      length: 5,
    });
  }

  $(document).on("submit", "#submit-question", function () {
    if (isCaptchaEnable == 1) {
    var answer_length = $("#code").val();
    var answer = captcha.valid($('input[name="code"]').val());
    }
    const subject = $("#subject").val();
    const heroSelect = $("#heroSelect").val();
    const description = $("#description").val();

    if (!subject) {
      $("#subject").css("border", "1px solid red");
      showNotify("error", "Error!", "Subject field is required!");
      $("#subject").focus();
      return false;
    } else if (!heroSelect) {
      $("#heroSelect").css("border", "1px solid red");
      showNotify("error", "Error!", "Category field is required!");
      $("#heroSelect").focus();
      return false;
    } else if (!description) {
      $("#description").css("border", "1px solid red");
      showNotify("error", "Error!", "Question field is required!");
      $("#description").focus();
      return false;
    } else if (isCaptchaEnable == 1 && !answer_length.length > 0) {
      $("#code").css("border", "1px solid red");
      showNotify("error", "Error!", "Captcha field is required!");
      return false;
    } else if (isCaptchaEnable == 1 && !answer) {
      captcha.refresh();
      $("#captcha-error").removeClass("d-none");
      $("#make-disabled").prop("disabled", false);
      $("#code").val("");
      return false;
    } else {
      return true;
    }
  });

  $(document).on("click", "#change-code", function () {
    captcha.refresh();
  });
});
