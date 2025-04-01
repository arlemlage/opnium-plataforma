(function ($) {
  "use strict";

  let app_url = $('input[name="app-url"]').attr("data-app_url");

  let config = {
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
      ],
    ],
  };
  CKEDITOR.addCss(
    ".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}"
  );
  CKEDITOR.config.allowedContent = true;
  CKEDITOR.replace("ticket_content", config);

  function fetchCustomField(product_category_id, department = null) {
    $("#custom-field").empty();
    $.ajax({
      url: app_url + "/api/fetch-custom-field/" + product_category_id,
      type: "GET",
      data: {
        department: department,
      },
      success: function (response) {
        $("#custom-field").html(response);
      },
    });
  }

  //Add Customer Modal/insert new customer
  $(document).on("click", ".open_modal_customer", function (e) {
    openModal("add_customer");
  });
  $(document).on("click", ".close_modal_customer", function (e) {
    closeModal("add_customer");
  });
  function checkValidEmail(email) {
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  $(document).on("click", ".add_new_customer", function () {
    $(".error_f_name").text("");
    $(".error_l_name").text("");
    $(".error_email").text("");

    if ($(".first_name").val() == "") {
      $(".error_f_name").text($("#first_name_required").val());
      return false;
    }
    if ($(".first_name").val().length > 191) {
      $(".error_f_name").text($("#first_name_max_191").val());
      return false;
    } else if ($(".last_name").val() == "") {
      $(".error_l_name").text($("#first_name_required").val());
      return false;
    } else if ($(".last_name").val().length > 191) {
      $(".error_l_name").text($("#last_name_max_191").val());
      return false;
    } else if ($(".email").val() == "") {
      $(".error_email").text($("#email_required").val());
      return false;
    } else if ($(".email").val().length > 50) {
      $(".error_email").text($("#email_max_50").val());
      return false;
    } else if (!checkValidEmail($(".email").val())) {
      $(".error_email").text($("#invalid_email").val());
      return false;
    } else {
      let form_data = {
        first_name: $(".first_name").val(),
        last_name: $(".last_name").val(),
        email: $(".email").val(),
        mobile: $(".mobile").val(),
        status: $(".status").val(),
      };

      showSpin("ticket-add-customer-form-spinner", "add_new_customer");
      $.ajax({
        url: app_url + "/customer",
        type: "POST",
        data: form_data,
        success: function (data) {
          if (data.status == 1) {
            $(".first_name").val("");
            $(".last_name").val("");
            $(".email").val("");
            $(".mobile").val("");
            $(".ajax_data_alert").empty();
            $(".ajax_data_field_alert").empty();
            $(".ajax_data_alert_show_hide").removeClass("d-none");
            $(".ajax_data_alert").text(data.msg);
            $("#append_c_option_by_ajax").empty();
            $.each(data.all_customer_options, function (index, val) {
              $("#append_c_option_by_ajax").append(val);
            });
            hideSpin("ticket-add-customer-form-spinner", "add_new_customer");
            //modal close
            closeModal("add_customer");
          } else if (data.status == 0) {
            $(".ajax_data_field_alert").empty();
            $(".error_f_name").text(data.first_name);
            $(".error_l_name").text(data.last_name);
            $(".error_email").text(data.email);
            $(".error_mobile").text(data.mobile);
            hideSpin("ticket-add-customer-form-spinner", "add_new_customer");
          }
        },
      });
    }
  });

  $("body").on("click", ".click_on_upload", function (e) {
    setTimeout(function () {
      let active_title = $(".active_title").val();
      $(".set_title").each(function () {
        let this_title = $(this).val();
        if (this_title == "") {
          $(this).val(active_title);
        }
      });
      $(".set_title_txt").each(function () {
        let this_title = $(this).text();
        if (this_title == "") {
          $(this).text(active_title);
        }
      });
    }, 300);
  });

  $(document).on("click", "#ds_add_file", function () {
    $("#doc_table").removeClass("displayNone");
    let file_div = `<tr>
            <td style="width: 55%">
                <input type="text" name="file_title[]" maxlength="100" class="form-control check_file_title" placeholder="File Title" required>
            </td>
            <td style="width: 40%">
                <input type="file" name="files[]" accept =".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip,.avi,.mp4" class="form-control check_file_title file_checker_global" data-this_file_size_limit="5" required>
            </td>
            <td style="width: 5%">
                <span class="text-right ds_remove_file" id="">
                <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon>
            </span>
            </td>
        </tr>`;

    $("#doc_table").find("tbody").append(file_div);
  });

  $(document).on("click", ".ds_remove_file", function () {
    let event = this;
    $(event).parent().parent().remove();
  });

  function check_all_required(this_action) {
    let status = true;
    let focus = 1;
    let user_type = Number($("#user_type").val());
    let ticket_title = $(".ticket_title").val();
    let product_category_id = $("#product_category_id").val();
    let append_c_option_by_ajax = $("#append_c_option_by_ajax").val();
    let content_length = CKEDITOR.instances["ticket_content"]
      .getData()
      .replace(/<[^>]*>/gi, "").length;
    let selectedOption = this_action.find("option:selected");
    let customAttribute = selectedOption.data("verification");

    //hide error message before checking required
    $(".ticket_title").parent().find(".invalid-feedback").hide();
    $("#product_category_id").parent().find(".invalid-feedback").hide();
    $("#append_c_option_by_ajax").parent().find(".invalid-feedback").hide();
    $(".content-invalid").hide();
    $("#envato_u_name").parent().find(".invalid-feedback").hide();
    $("#envato_p_code").parent().find(".invalid-feedback").hide();

    //remove every border of required fields
    $(".required_checker").removeClass("border_red");
    $("#cke_ticket_content").removeClass("border_red");
    $(".check_file_title").removeClass("border_red");

    if (ticket_title == "") {
      $(".ticket_title").parent().find(".invalid-feedback").show();
      $(".ticket_title").addClass("border_red");
      $(".ticket_title").focus();
      status = false;
    } else if (product_category_id == "") {
      let open_dropdown = $("#product_category_id").data("select2");
      open_dropdown.open();
      $("#product_category_id").parent().find(".invalid-feedback").show();
      status = false;
    } else if (customAttribute == 1) {
      let envato_u_name = $("#envato_u_name").val();
      let envato_p_code = $("#envato_p_code").val();
      let check_envato_status = false;
      if (envato_u_name == "") {
        check_envato_status = true;
        $("#envato_u_name").parent().find(".invalid-feedback").show();
        $("#envato_u_name").addClass("border_red");
        $("#envato_u_name").focus();
      } else if (envato_p_code == "") {
        check_envato_status = true;
        $("#envato_p_code").parent().find(".invalid-feedback").show();
        $("#envato_p_code").addClass("border_red");
        $("#envato_p_code").focus();
      }
      if (check_envato_status == true) {
        status = false;
      }
    }
    if (status == true) {
      $(".custom_field_required").removeClass("border_red");
      $(".custom_field_required").each(function (index, tr) {
        let this_value = $(this).val();
        if (this_value == "") {
          status = false;
          if (focus == 1) {
            $(this).addClass("border_red");
            $(this).focus();
            focus++;
          }
        }
      });
    }
    if (user_type != 3 && append_c_option_by_ajax == "" && status == true) {
      let open_dropdown_customer = $("#append_c_option_by_ajax").data(
        "select2"
      );
      open_dropdown_customer.open();
      $("#append_c_option_by_ajax").parent().find(".invalid-feedback").show();
      status = false;
    }
    if (content_length == 0 && status == true) {
      $("#cke_ticket_content").addClass("border_red");
      $(".content-invalid").show();
      status = false;
    }
    if ($(".check_file_title").length && status == true) {
      focus = 1;
      $(".check_file_title").each(function (index, tr) {
        let this_value = $(this).val();
        if (this_value == "") {
          status = false;
          $(this).addClass("border_red");
        }
      });
    }
    return status;
  }
  $(document).on("submit", "#ticket-add-edit", function (e) {
    $(".search_div").addClass("d-none");
    let is_ignore_submit_status = $("#is_ignore_submit_status").val();
    if (is_ignore_submit_status == 1) {
      return true;
    } else {
      if (check_all_required($(this))) {
        showSpinTicektAdd("ticket-add-edit-spin", "submit-ticket");
        let selectedOption = $(this).find("option:selected");
        let customAttribute = selectedOption.data("verification");
        if (customAttribute == 1) {
          e.preventDefault();
          envatoVerification();
        } else {
          showSpinTicektAdd("ticket-add-edit-spin", "submit-ticket");
          $("#is_ignore_submit_status").val(1);
          $("#submit-ticket").click();
        }
      } else {
        return false;
      }
    }
  });

  function envatoVerification() {
    let username = $("#envato_u_name").val();
    let purchase_code = $("#envato_p_code").val();
    let product_category_id = $("#product_category_id").val();
    let form_data = {
      product_category_id: product_category_id,
      username: username,
      purchase_code: purchase_code,
    };
    $.ajax({
      url: app_url + "/api/envato-validation",
      type: "GET",
      data: form_data,
      dataType: "json",
      success: function (data) {
        if (!data.status) {
          Swal.fire({
            icon: "warning",
            title: data.message,
            confirmButtonColor: "#7367F0",
            confirmButtonText: "Ok",
            allowOutsideClick: false,
          });
          hideSpinTicektAdd("ticket-add-edit-spin", "submit-ticket");
        } else {
          $("#is_ignore_submit_status").val(1);
          $("#submit-ticket").click();
        }
      },
    });
  }

  // Loader Function
  function loader() {
    $(".results").empty();
    let html = `<div class="row">
                  <div class="col-md-12 col-xs-12 text-center">
                      <h4 class="card-title">System is looking for solutions in Knowledgebase, Blogs, AI, and other places</h4>
                      <div class="lds-facebook loader-img">
                          <div></div>
                          <div></div>
                          <div></div>
                      </div>
                  </div>
              </div>`;

    $(".results").html(html);
  }

  let typingTimer;
  let doneTypingInterval = 3000;
  $(document).on("keyup", ".category_title_", function () {
    loader();
    let is_ai_enable = $("#is_ai_enable").val();
    if (is_ai_enable) {
      $(".results").removeClass("displayNone");
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function () {
        fetchSearchResult();
      }, doneTypingInterval);
    }
  });

  $(document).on("focus", "#ticket_content", function (){
    $(".results").addClass("displayNone");
  })

  $(document).on("change", ".product_category_id", function () {
    let title = $(".category_title_").val();
    let selectedOption = $(this).find("option:selected");
    let customAttribute = selectedOption.data("verification");
    let hasCustomField = selectedOption.data("custom-field");

    if (title.length > 0) {
      fetchSearchResult();
    }
    if (customAttribute == 1) {
      $(".envato_verify_field").removeClass("d-none");
      $(".envato_u_name").attr("required", true);
      $(".envato_p_code").attr("required", true);
    } else {
      $(".envato_verify_field").addClass("d-none");
      $(".envato_u_name").attr("required", false);
      $(".envato_p_code").attr("required", false);
      $(".envato_u_name").val("");
      $(".envato_p_code").val("");
    }
    if (hasCustomField == 1) {
      fetchCustomField($(".product_category_id").val());
    } else {
      $("#custom-field").html("");
    }
  });

  $(document).on("change", ".department_id", function () {
    let title = $(".category_title_").val();
    let selectedOption = $(this).find("option:selected");
    let customAttribute = selectedOption.data("verification");
    let hasCustomField = selectedOption.data("custom-field");
    let department_id = $(this).val();
    if (title.length > 0) {
      fetchSearchResult();
    }
    if (customAttribute == 1) {
      $(".envato_verify_field").removeClass("d-none");
      $(".envato_u_name").attr("required", true);
      $(".envato_p_code").attr("required", true);
    } else {
      $(".envato_verify_field").addClass("d-none");
      $(".envato_u_name").attr("required", false);
      $(".envato_p_code").attr("required", false);
      $(".envato_u_name").val("");
      $(".envato_p_code").val("");
    }
    if (hasCustomField == 1) {
      fetchCustomField($("#product_category_id").val(), department_id);
    } else {
      $("#custom-field").html("");
    }
  });

  function fetchSearchResult() {
    let is_ai_enable = $("#is_ai_enable").val();
    let search_title = $.trim($(".category_title_").val());
    if (is_ai_enable) {
      if (search_title.length > 0) {
        let product_id = $(".product_category_id").val();
        let form_data = {
          query: search_title,
          product_id: product_id,
        };
        let url = app_url + "/autocomplete-data";
        $.ajax({
          url: url,
          type: "GET",
          data: form_data,
          success: function (data) {
            if (data.length > 0) {
              if (data) {
                $(".results").html(data);
                $(".results").removeClass("displayNone");
                makeMatchingBold(search_title, "search_title_result");
              } else {
                $(".results").addClass("displayNone");
              }
            } else {
              $(".results").addClass("displayNone");
            }
          },
        });
      } else {
        $(".results").addClass("displayNone");
      }
    }
  }

  $(document).on("click", ".search-close", function () {
    $(".search_suggest").addClass("displayNone");
  });
})(jQuery);
