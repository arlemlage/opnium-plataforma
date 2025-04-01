$(function () {
  "use strict";
  let base_url = $('input[name="app-url"]').attr("data-app_url");

  $('[data-toggle="tooltip"]').tooltip();
  const isCaptchaEnable = $("#isCaptchaEnable").val();
  if (isCaptchaEnable == 1) {
    var captcha = new Captcha($("#canvas"), {
      length: 5,
    });
  }
  $(document).on("click", "#change-code", function () {
    captcha.refresh();
  });
  $(document).on("keyup", ".search_article", function () {
    let str_search = $(".search_article").val();

    if (str_search) {
      $(".main_group_article").each(function (i, obj) {
        let status_exist = false;
        $(this)
          .find(".article_title")
          .each(function (i, obj) {
            let article_title = $(this).text().toLowerCase();
            if (article_title.includes(str_search.toLowerCase())) {
              highLightColor(str_search);
              status_exist = true;
            }
          });
        matchingBold(str_search);
        if (status_exist) {
          $(this).find(".accordion-collapse").addClass("show");
        } else {
          $(this).find(".accordion-collapse").removeClass("show");
          $(this)
            .find(".article_title")
            .each(function (i, obj) {
              let article_title = $(this).text();
              $(this).text(article_title);
            });
        }
      });
    } else {
      $(".main_group_article").find(".accordion-collapse").removeClass("show");
      $(".active-article")
        .parent()
        .parent()
        .parent()
        .parent()
        .parent()
        .addClass("show");
      $(".article_title").each(function (i, obj) {
        let article_title = $(this).text();
        $(this).text(article_title);
      });
    }
  });

  //trigger active title
  let active_article_id = Number($("#active_article_id").val());
  if (active_article_id) {
    $("#title_" + active_article_id).click();
    $("#number" + active_article_id).addClass("show");
  }

  // Capcha Code Check
  $(document).on("submit", "#article_comment", function () {
    if (isCaptchaEnable == 1) {
    var answer_length = $("#code").val();
    var answer = captcha.valid($('input[name="code"]').val());
    }
    const comment = $("#comment").val();
    if (!comment.length && comment.trim() === "") {
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
      $("#code").val("");
      return false;
    } else {
      return true;
    }
  });

  //Reply Comment
  $(document).on("click", "#reply_btn", function (e) {
    $("html, body").animate(
      {
        scrollTop: $(".article-comment-box").offset().top,
      },
      500
    );
    let parentCommentId = $(this).data("id");
    let html =
      '<input type="hidden" name="parent_id" value="' + parentCommentId + '">';
    $("#article_comment").append(html);
  });
});
