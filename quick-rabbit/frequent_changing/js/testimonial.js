(function ($) {
  "use strict";

  let app_url = $('input[name="app-url"]').attr("data-app_url");


  //Add Customer Modal/insert new customer
  $(document).on("click", ".open_modal_customer", function (e) {
    openModal("add_customer");
  });
  $(document).on("click", ".close_modal_customer", function (e) {
    closeModal("add_customer");
  });
  
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
})(jQuery);
