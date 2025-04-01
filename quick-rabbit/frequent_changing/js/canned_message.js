(function ($) {
  ("use strict");
  CKEDITOR.replace("canned_msg_content", {
    toolbar: [
      [
        "Bold",
        "Italic",
        "Strike",
        "JustifyLeft",
        "JustifyCenter",
        "JustifyRight",
        "NumberedList",
        "BulletedList",
        "Outdent",
        "Indent",
        "Link",
        "Unlink",
      ],
    ],
  });
  CKEDITOR.addCss(
    ".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}"
  );

  //Article search Modal open/close
  $(document).on("click", ".open_article_modal", function (e) {
    openModal("article_modal");
    let update_textarea_id = $(this).data("update_textarea_id");
    if (update_textarea_id) {
      $(".update_textarea_id_a").val(update_textarea_id);
    } else {
      $(".update_textarea_id_a").val("");
    }
  });
  $(document).on("click", ".close_article_modal", function (e) {
    closeModal("article_modal");
  });

  //search article
  $(document).on("keyup", ".article_search", function (e) {
    let title = $(this).val();
    $.ajax({
      type: "POST",
      url: app_url + "/get-article-searched-data",
      data: {
        title: title,
      },
      cache: false,
      success: (data) => {
        if (data.status == 1) {
          $(".article_msg_ul").empty();
          $(".article_msg_ul").append(data.all_articles);
          makeMatchingBold(title, "matched_article");
        } else {
          $(".article_msg_ul").empty();
        }
      },
      error: function (response) {
        console.log(response.responseJSON.message);
      },
    });
  });
  //insert article
  $(document).on("click", ".matched_article", function (e) {
    let article_url = $(this).data("url");
    console.log(article_url);
    let title = $(this).text();
    let title_link =
      '<a class="ds_link" target="_blank" href="' +
      article_url +
      '">' +
      title +
      "</a>";
    let canned_msg_content = $(".canned_msg_content").val();
    if (canned_msg_content) {
      CKEDITOR.instances[canned_msg_content].insertHtml(" " + title_link + " ");
    } else {
      CKEDITOR.instances["canned_msg_content"].insertHtml(
        " " + title_link + " "
      );
    }
    closeModal("article_modal");
  });
})(jQuery);
