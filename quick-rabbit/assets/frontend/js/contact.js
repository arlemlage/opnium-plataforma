$(function () {
  "use strict";
  const isCaptchaEnable = $("#isCaptchaEnable").val();
  if (isCaptchaEnable == 1) {
    var captcha = new Captcha($("#canvas"), {
      length: 5,
    });
  }

  $(document).on("submit", "#formContact", function () { 
    const message = $("#message").val();
    const name = $("#name").val();
    const subject = $("#subject").val();
    const email = $("#email").val();
    
    if (isCaptchaEnable == 1) {
      var answer_length = $("#code").val();
      var answer = captcha.valid($("#code").val());
    }
    if (!name.length && name.trim() === "") {
      $("#name").addClass("is-invalid");
      showNotify("error", "Error!", 'Name Field is required!');
      return false;
    } else if (name.length > 1000) {
      $("#name").addClass("is-invalid");
      showNotify("error", "Error!", 'Name must be less then 1000 characters!');
      return false;
    } else if (!email.length && email.trim() === "") {
      $("#email").addClass("is-invalid");
      showNotify("error", "Error!", 'Email field is required!');
      return false;
    } else if (!validateEmail(email)) {
      $("#email").addClass("is-invalid");
      showNotify("error", "Error!", 'Invalid email format!');
      return false;
    } else if (!subject.length && subject.trim() === "") {
      $("#subject").addClass("is-invalid");
      showNotify("error", "Error!", 'Subject field is required!');
      return false;
    } else if (!message.length && message.trim() === "") {
      $("#message").focus();
      $("#message").addClass("is-invalid");
      showNotify("error", "Error!", 'Message field is required!');
      return false;
    } else if (message.length > 1000) {
      $("#message").addClass("is-invalid");
      showNotify("error", "Error!", 'Message must be less then 1000 characters!');
      return false;
    } else if (isCaptchaEnable == 1 && answer_length > 0) {
      $("#code").css("border", "1px solid red");
      showNotify("error", "Error!", 'Captcha code field is required!');
      $('#code').val('');
      return false;
    } else if (isCaptchaEnable == 1 && !answer) {
      captcha.refresh();
      showNotify("error", "Error!", 'Captcha is invalid!');
      $('#code').val('');
      return false;
    } else {
      console.log("Form is valid");
      return true;
    }
  });

  function validateEmail(email) {
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
  }

  $(document).on("click", "#change-code", function () {
    captcha.refresh();
  });

  $(document).on("focus", ".contact_name", function () {
    $(".contact_name_r").addClass("d-none");
  });

  $(document).on("blur", ".contact_name", function () {
    if (!$(this).val().length) {
      $(".contact_name_r").removeClass("d-none");
    }    
  });

  $(document).on("focus", ".contact_email", function () {
    $(".contact_email_r").addClass("d-none");
  });

  $(document).on("blur", ".contact_email", function () {
    if (!$(this).val().length) {
      $(".contact_email_r").removeClass("d-none");
    }    
  });

  $(document).on("focus", ".contact_subject", function () {
    $(".contact_subject_r").addClass("d-none");
  });

  $(document).on("blur", ".contact_subject", function () {
    if (!$(this).val().length) {
      $(".contact_subject_r").removeClass("d-none");
    }    
  });
});
