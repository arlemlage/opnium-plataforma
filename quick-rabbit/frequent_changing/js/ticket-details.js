(function ($) {
  "use strict";
  setTimeout(function () {
    $(".replay_btn").trigger("click");
    $("html, body").animate(
      {
        scrollTop: $("#ticket_post_reply_form").offset().top,
      },
      1000
    );
  }, 500);
  //App Url
  let app_url = $('input[name="app-url"]').attr("data-app_url");
  let category_id = $(".get_this_category_id").val();
  //Ticket Replies //Comments
  let agent_customers = CKEDITOR.ajax.load(
    app_url + "/editor-mentioned-data?category_id=" + category_id
  );
  let users = jQuery.parseJSON(agent_customers);

  CKEDITOR.replace("ticket_comment", {
    toolbar: [
      [
        "Bold",
        "Italic",
        "Strike",
        "JustifyLeft",
        "JustifyCenter",
        "JustifyRight",
        "Link",
        "Unlink",
        "-",
        "Font",
        "FontSize",
        "NumberedList",
        "BulletedList",
        "Outdent",
        "Indent",
      ],
    ],
    height: 150,
    mentions: [
      {
        feed: dataFeed,
        itemTemplate:
          '<li data-id="{id}">' +
          '<strong class="email">{email}</strong>' +
          '<span class="fullname"> {fullname} </span>' +
          "</li>",
        outputTemplate:
          '<a href="mailto:{email}">@{fullname}</a><span>&nbsp;</span>',
        minChars: 0,
      },
    ],
    removeButtons: "PasteFromWord",
  });
  CKEDITOR.addCss(
    ".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}"
  );
  //The Function used for mentions( @ )
  function dataFeed(opts, callback) {
    let matchProperty = "email",
      data = users.filter(function (item) {
        return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
      });

    data = data.sort(function (a, b) {
      return a[matchProperty].localeCompare(b[matchProperty], undefined, {
        sensitivity: "accent",
      });
    });
    callback(data);
  }

  $(document).on("click", ".replay_btn", function (e) {
    $(this).hide();
    $("#post_replay_form").removeClass("d-none");
    $("#note_form").addClass("d-none");
    CKEDITOR.instances.ticket_comment.focus();
  });

  $(document).on("click", ".set_replay_btn", function (e) {
    e.preventDefault();
    let title =
      "I couldn't find my solution from the AI response, need manual assistance from an agent.";
    let update_textarea_id_c = $(".update_textarea_id_c").val();
    if (update_textarea_id_c) {
      CKEDITOR.instances[update_textarea_id_c].insertHtml(" " + title + " ");
    } else {
      CKEDITOR.instances["ticket_comment"].insertHtml(" " + title + " ");
    }
    $("#is_menual_assist").val(1);
    $(".post_replay").click();
  });
  $(document).on("click", ".cancel_post_reply", function (e) {
    $("#post_replay_form").addClass("d-none");
    $("#note_form").addClass("d-none");
    $(".replay_btn").show();
  });

  //Add Customer Note Modal
  $(document).on("click", ".open_cus_note_modal", function (e) {
    openModal("add_customer_note");
  });
  $(document).on("click", ".close_cus_note_modal", function (e) {
    closeModal("add_customer_note");
    $(".customer_note_error").text("");
  });
  //insert new customer note
  $(document).on("click", ".add_new_customer_note", function (e) {
    showSpin("cus-note-form-spinner", "submit-customer-note");
    let customer_note = $(".customer_note").val();
    if (customer_note == "") {
      $(".customer_note_error").text($("#note_field_required").val());
      hideSpin("cus-note-form-spinner", "submit-customer-note");
      return false;
    } else {
      let form_data = {
        customer_note: $(".customer_note").val(),
        customer_id: $(".customer_id").val(),
      };
      $.ajax({
        url: app_url + "/add-customer-note",
        type: "POST",
        data: form_data,
        success: function (data) {
          if (data.status == 1) {
            hideSpin("cus-note-form-spinner", "submit-customer-note");
            $("#append_new_added_note").empty();
            $("#append_new_added_note").append(data.notes);
            $(".customer_note").val("");
            $(".customer_note_error").text("");
            //modal close
            closeModal("add_customer_note");
            toastr.success(data.msg);
          } else if (data.status == 0) {
            hideSpin("cus-note-form-spinner", "submit-customer-note");
            $(".customer_note").val("");
            $(".customer_note_error").text(data.msg);
          }
        },
      });
    }
  });
  //Modal
  $(document).on("click", ".open_cus_note_list_modal", function (e) {
    openModal("customer_note_list");
  });
  $(document).on("click", ".close_cus_note_list_modal", function (e) {
    closeModal("customer_note_list");
  });

  $(document).on("click", ".open-customer-info-modal", function (e) {
    openModal("customer_info");
  });
  $(document).on("click", ".close-customer-info-modal", function (e) {
    closeModal("customer_info");
  });

  $(document).on("click", ".open_ticket_note_modal", function (e) {
    openModal("add_ticket_note");
  });

  $(document).on("click", ".close_ticket_note_modal", function (e) {
    closeModal("add_ticket_note");
    $(".ticket_note_error").text("");
  });

  $(document).on("click", ".add_new_ticket_note", function (e) {
    showSpin("ticket-note-form-spinner", "submit-ticket-note");
    if ($(".ticket_note").val() == "") {
      $(".ticket_note_error")
        .removeClass("displayNone")
        .text($("#note_field_required").val());
      hideSpin("ticket-note-form-spinner", "submit-ticket-note");
      return false;
    } else {
      let form_data = {
        ticket_note: $(".ticket_note").val(),
        ticket_id: $(".get_this_ticket_id").val(),
      };
      $.ajax({
        url: app_url + "/add-ticket-note",
        type: "POST",
        data: form_data,
        success: function (data) {
          if (data.status == 1) {
            hideSpin("ticket-note-form-spinner", "submit-ticket-note");
            $("#append_new_added_ticket_note").empty();
            $("#append_new_added_ticket_note").append(data.notes);
            $(".ticket_note").val("");
            $(".ticket_note_error").text("");
            //modal close
            closeModal("add_ticket_note");
            toastr.success(data.msg);
          } else if (data.status == 0) {
            hideSpin("ticket-note-form-spinner", "submit-ticket-note");
            $(".ticket_note").val("");
            $(".ticket_note_error").text(data.msg);
          }
        },
      });
    }
  });
  //Ticket Note List Modal
  $(document).on("click", ".open_ticket_note_list_modal", function (e) {
    openModal("ticket_note_list");
  });
  $(document).on("click", ".close_ticket_note_list_modal", function (e) {
    closeModal("ticket_note_list");
  });
  $(document).on("click", ".close_ticket_cc_modal", function (e) {
    closeModal("add_ticket_cc");
  });

  $(document).on("click", ".open_ticket_cc_modal", function (e) {
    openModal("add_ticket_cc");
  });

  $(document).on("click", ".add_new_ticket_cc", function (e) {
    if ($(".ticket_cc").val() !== "") {
      let cc_mail = $(".ticket_cc").val().split(",").reverse();
      let rv = true;
      $.each(cc_mail, function (index, val) {
        if (!ValidateEmail(val)) {
          $(".ticket_cc_error").text("The Email " + val + " is invalid");
          rv = false;
        }
      });
      if (!rv) {
        return false;
      }
    }
    if ($(".get_this_ticket_id").val() == "") {
      alert("Ticket field is required.");
      return false;
    } else {
      let form_data = {
        cc_email: $(".ticket_cc").val(),
        ticket_id: $(".get_this_ticket_id").val(),
      };
      $.ajax({
        url: app_url + "/add-ticket-cc",
        type: "POST",
        data: form_data,
        success: function (data) {
          if (data.status == true) {
            $(".ticket_cc_list").empty().text(data.ticket_cc);
            $(".ticket_cc").val(data.ticket_cc);
            $(".ticket_cc_error").text("");
            closeModal("add_ticket_cc");
            toastr.success($("#save_message").val());
          }
        },
      });
    }
  });

  function ValidateEmail(email) {
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email.match(mailformat)) {
      return true;
    } else {
      return false;
    }
  }
  //Canned Message search Modal open/close
  $(document).on("click", ".open_canned_modal", function (e) {
    openModal("canned_modal");
    let update_textarea_id = $(this).data("update_textarea_id");
    if (update_textarea_id) {
      $(".update_textarea_id_c").val(update_textarea_id);
    } else {
      $(".update_textarea_id_c").val("");
    }
  });
  $(document).on("click", ".close_canned_modal", function (e) {
    closeModal("canned_modal");
  });
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
  //searched canned msg in a list (js search)
  $(document).on("keyup", ".canned_msg_search", function (e) {
    let string = $(this).val().toLowerCase();
    makeMatchingBold(string, "matched_canned_msg");
    $(".matched_canned_msg").each(function (i, obj) {
      let canned_msg = $(this).html().toLowerCase();
      if (canned_msg.includes(string)) {
        $(this).css("display", "flex");
      } else {
        $(this).css("display", "none");
      }
    });
  });
  //search article
  $(document).on("keyup", ".article_search", function (e) {
    let title = $(this).val();
    let category = $("#category_id").val();
    $.ajax({
      type: "POST",
      url: app_url + "/get-article-searched-data",
      data: {
        title: title,
        category: category_id,
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
    let update_textarea_id_a = $(".update_textarea_id_a").val();
    if (update_textarea_id_a) {
      CKEDITOR.instances[update_textarea_id_a].insertHtml(
        " " + title_link + " "
      );
    } else {
      CKEDITOR.instances["ticket_comment"].insertHtml(" " + title_link + " ");
    }
    closeModal("article_modal");
  });
  //insert canned msg
  $(document).on("click", ".matched_canned_msg", function (e) {
    let title = $(this).attr("data-text");
    let update_textarea_id_c = $(".update_textarea_id_c").val();
    if (update_textarea_id_c) {
      CKEDITOR.instances[update_textarea_id_c].insertHtml(" " + title + " ");
    } else {
      CKEDITOR.instances["ticket_comment"].insertHtml(" " + title + " ");
    }
    closeModal("canned_modal");
  });

  //Assign Modal open/close
  $(document).on("click", ".open_assign_modal", function (e) {
    openModal("assign_modal");
  });
  $(document).on("click", ".close_assign_modal", function (e) {
    $(".assign_to_id_error").text("");
    closeModal("assign_modal");
  });
  $(document).on("click", ".set_new_ticket_assignee", function (e) {
    $(".set_new_ticket_assignee").prop("disabled", true);
    $(".assign-spin").removeClass("d-none");
    let priority_text =
      $(".priority_val").val() == 1
        ? "High"
        : $(".priority_val").val() == 2
        ? "Medium"
        : "Low";

    let form_data = {
      assign_to_val: $(".assign_to_val").val(),
      priority_val: $(".priority_val").val(),
      ticket_id: $(".get_this_ticket_id").val(),
    };
    $.ajax({
      url: app_url + "/set-ticket-assign-priority",
      type: "POST",
      data: form_data,
      success: function (data) {
        if (data.status == 1) {
          $(".assign_to_id_error").text("");
          $(".show_priority").text(priority_text);
          $(".show_agents_names_this_ticket").html(
            data.get_agents_names_this_ticket
          );
          // //modal close
          closeModal("assign_modal");
          $(".set_new_ticket_assignee").prop("disabled", false);
          $(".assign-spin").addClass("d-none");
          toastr.success(data.msg);
        } else if (data.status == 0) {
          $(".assign_to_id_error").text(data.msg);
          $(".assign-spin").addClass("d-none");
          $(".set_new_ticket_assignee").prop("disabled", false);
        }
      },
    });
  });
  $(document).on("click", ".ticket_status_set_close_reopen", function () {
    let ticket_status = $(this).data("ticket_status");
    let ticket_id = $(".get_this_ticket_id").val();
    let status = "";
    let message = "";
    if (ticket_status == 2) {
      status = "close";
      message = $("#sure_to_close").val();
    } else if (ticket_status == 3) {
      status = "reopen";
      message = $("#sure_to_reopen").val();
    }
    Swal.fire({
      icon: "warning",
      title: $("#are_you_sure").val(),
      text: message,
      confirmButtonColor: "#36405E",
      cancelButtonText: $("#cancel_text").val(),
      cancelButtonColor: "#d33",
      confirmButtonText: $("#ok").val(),
      showCancelButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href =
          app_url + "/ticket-close-reopen/" + ticket_id + "/" + ticket_status;
      }
    });
  });
  //Ticket Status Archived
  $(document).on("click", ".ticket_status_set_archived", function () {
    let ticket_id = $(".get_this_ticket_id_encrypt").val();
    Swal.fire({
      icon: "warning",
      title: $("#are_you_sure").val(),
      text: $("#sure_to_archive").val(),
      confirmButtonColor: "#36405E",
      cancelButtonText: $("#cancel_text").val(),
      cancelButtonColor: "#d33",
      confirmButtonText: $("#ok").val(),
      showCancelButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = app_url + "/ticket-archived/" + ticket_id;
      }
    });
  });

  //Keyboard Shortcut modal
  $(document).on("click", ".open_keyboard_shortcut_modal", function (e) {
    openModal("keyboard_shortcut");
  });
  $(document).on("click", ".close_keyboard_shortcut_modal", function (e) {
    closeModal("keyboard_shortcut");
  });

  //Start Comment Update
  $(document).on("click", ".comment_edit_update_btn", function (e) {
    $(this).hide();
    let r_comment_id = $(this).data("r_comment_id");
    $(".update_comment_text_area_div" + r_comment_id).removeClass("d-none");
  });
  $(document).on("click", ".comment_edit_update_cancel_btn", function (e) {
    let r_comment_id = $(this).data("r_comment_id");
    $(".update_comment_text_area_div" + r_comment_id).addClass("d-none");
    $(".r_edit_btn" + r_comment_id).show();
  });
  //Append ck editor on each update_comment_box
  $(".ticket_comment_update").each(function () {
    let this_id = $(this).attr("id");
    CKEDITOR.replace(this_id, {
      toolbar: [
        [
          "Bold",
          "Italic",
          "Strike",
          "JustifyLeft",
          "JustifyCenter",
          "JustifyRight",
          "Link",
          "Unlink",
          "-",
          "Font",
          "FontSize",
          "NumberedList",
          "BulletedList",
          "Outdent",
          "Indent",
        ],
      ],
      height: 150,
      mentions: [
        {
          feed: dataFeed,
          itemTemplate:
            '<li data-id="{id}">' +
            '<strong class="email">{email}</strong>' +
            '<span class="fullname"> {fullname} </span>' +
            "</li>",
          outputTemplate:
            '<a href="mailto:{email}">@{fullname}</a><span>&nbsp;</span>',
          minChars: 0,
        },
      ],
      removeButtons: "PasteFromWord",
    });
  });
  //End Comment Update

  //keyboard shortcut
  $(document).on("keydown", function (e) {
    if (e.ctrlKey && e.altKey && e.keyCode == 82) {
      e.preventDefault();
      //open replay form
      $(".replay_btn").click();
    }
    if (e.ctrlKey && e.altKey && e.keyCode == 77) {
      e.preventDefault();
      //Open Canned Message Modal
      $(".open_canned_modal").click();
    }
    if (e.ctrlKey && e.altKey && e.keyCode == 65) {
      //Open Article Modal
      e.preventDefault();
      $(".open_article_modal").click();
    }
    if (e.ctrlKey && e.altKey && e.keyCode == 67) {
      e.preventDefault();
      //Close Ticket
      $(".ticket_status_set_close_reopen").click();
    }
  });

  $("#article_modal").on("shown.bs.modal", function () {
    $(".article_search").focus();
  });

  $("#canned_modal").on("shown.bs.modal", function () {
    $("#canned_input").focus();
  });

  $(document).on("click", "#ds_add_file", function () {
    $("#doc_table").removeClass("displayNone");
    let file_div = `<tr>
            <td style="width: 55%">
                <input type="text" name="file_title[]" class="form-control" maxlength="100" placeholder="File Title" required>
            </td>
            <td style="width: 40%">
                <input type="file" name="files[]" accept =".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip,.avi,.mp4" class="form-control" required>
            </td>
            <td style="width: 5%">
                <span class="text-right ds_remove_file" id="">
                <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon>
            </span>
            </td>
        </tr>`;

    $("#doc_table").find("tbody").append(file_div);
  });

  $(document).on("click", ".ds_edit_add_file", function () {
    let comment_id = $(this).attr("data-id");
    $("#edit_doc_table_" + comment_id).removeClass("displayNone");
    let file_div = `<tr>
            <td style="width: 55%">
                <input type="text" name="file_title[]" class="form-control" maxlength="100" placeholder="File Title" required>
            </td>
            <td style="width: 40%">
                <input type="file" name="files[]" accept =".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip,.avi,.mp4,.php" class="form-control" required>
            </td>
            <td style="width: 5%">
                <button type="button" class="btn btn-md btn-danger text-right ds_remove_file " id="">
                <i class="fa fa-trash"></i>
            </button>
            </td>
        </tr>`;

    $("#edit_doc_table_" + comment_id)
      .find("tbody")
      .append(file_div);
  });

  $(document).on("click", ".ds_remove_file", function () {
    let event = this;
    $(event).parent().parent().remove();
  });

  $(document).on("click", "#close_ticket", function () {
    let checkbox = $(this);
    let reply_text = $("#reply_text").val();
    let user_role_id = $("#user_role_id").val();
    let text = " " + reply_text;
    let spinTag =
      "<i class='fa fa-spinner fa-spin me-2 reply-post-spin d-none'></i>";
    let buttonName = "";
    if (checkbox.is(":checked") && user_role_id == 3) {
      let reply_and_close = $("#reply_and_close").val();
      text = " " + reply_and_close;
      buttonName = spinTag + text;
      $("#post-reply").addClass("post_reply_btn");
      $("#post-reply").attr("type", "button");
    } else {
      text = " " + reply_text;
      buttonName = spinTag + text;
      $("#post-reply").removeClass("post_reply_btn");
      $("#post-reply").attr("type", "submit");
    }
    $("#post-reply").html(buttonName);
  });

  $(document).on("click", ".post_reply_btn", function () {
    openModal("helpful_modal");
  });

  $(document).on("click", ".ticket_comment_helpful", function () {
    let id = $(this).attr("data-id");
    let inputField =
      '<input type="hidden" name="is_helpful" value="' + id + '">';
    $("#ticket_post_reply_form").append(inputField);
    closeModal("helpful_modal");
    $("#post-reply").attr("type", "submit");
    $("#post-reply").click();
  });

  $(document).on("click", ".no_button", function () {
    closeModal("helpful_modal");
    $("#post-reply").attr("type", "submit");
    $("#post-reply").click();
  });

  $(document).on("submit", "#ticket_post_reply_form", function () {
    let please_wait = $("#please_wait").val();
    let text = " " + please_wait;
    let spinTag =
      "<i class='fa fa-spinner fa-spin me-2 reply-post-spin d-none'></i>";
    let buttonName = spinTag + text;
    let content_length = CKEDITOR.instances["ticket_comment"]
      .getData()
      .replace(/<[^>]*>/gi, "").length;
    if (content_length == 0) {
      $("#cke_ticket_comment").css("border", "1px solid red");
      $(".content-invalid").show();
      return false;
    } else {
      $("#post-reply").prop("disabled", true).html(buttonName);
      $(".reply-post-spin").removeClass("d-none");
      return true;
    }
  });

  $(document).on("submit", "#comment-update-form", function () {
    let please_wait = $("#please_wait").val();
    let text = " " + please_wait;
    let spinTag =
      "<i class='fa fa-spinner fa-spin me-2 reply-post-spin d-none'></i>";
    let buttonName = spinTag + text;
    $(".comment_btn_update").prop("disabled", true).html(buttonName);
    $(".reply-post-spin").removeClass("d-none");
  });

  $(document).on("click", "#paid_support", function () {
    let current_status = $("#is_paid_support").val();
    if ($("#paid_support").prop("checked") === true) {
      $("#is_paid").val("Yes");
      $("#amount").val($("#current_amount").val());
      $("#payment-form").removeClass("displayNone");
      $("#send-payment-request").text($("#send_payment_request").val());
    } else {
      $("#is_paid").val("No");
      $("#amount").val(0);
      if (current_status == "No") {
        $("#payment-form").addClass("displayNone");
      } else {
        $("#send-payment-request").text($("#update").val());
      }
    }
  });

  $(document).on("submit", "#payment-request-form", function () {
    showSpin("paid-support-spinner", "send-payment-request");
  });

  $("#en_p_code").on("click", function (e) {
    selectText("en_p_code");
  });

  function selectText(containerid) {
    if (document.selection) {
      let range = document.body.createTextRange();
      range.moveToElementText(document.getElementById(containerid));
      range.select();
    } else if (window.getSelection) {
      let range = document.createRange();
      range.selectNode(document.getElementById(containerid));
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);
    }
  }
})(jQuery);
