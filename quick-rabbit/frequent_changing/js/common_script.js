(function ($) {
  "use strict";
  //App Url
  let app_url = $('input[name="app-url"]').attr("data-app_url");
  let auth_id = localStorage.getItem("auth_id");

  //multi select select2 initialize
  $(".select_multiple").select2({
    multiple: true,
    placeholder: "Select",
    allowClear: true,
  });
  $(".select_multiple").val("placeholder").trigger("change");

  $(document).on("click", ".close_common_image_modal", function (e) {
    closeModal("commonImage");
  });

  $(document).on("click", ".open_common_image_modal", function (e) {
    openModal("commonImage");
  });

  let tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  let forms = document.querySelectorAll(".needs-validation");
  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });

  $(document).on("click", ".notification_bell_icon_", function () {
    $(".loader_notification_div").show();
    $("#all_notifications_show_div").html("");
    loadNotification(1);
  });

  let counter = 2;
  $(".load-more-notification").on("click", function (e) {
    e.preventDefault();
    $(".loader_notification_div").show();
    $("#all_notifications_show_div").hide();
    let totalNotification = $("#notification-bell-count").text();
    let totalPage = Math.ceil(totalNotification / 10);
    let nextPage = counter; 
    counter += 1;
    if(nextPage > totalPage-1){
      counter = 1;
    }
    loadNotification(nextPage);
  });

  let isLoading = false;

  $(document).on("click", "#flexSwitchCheckChecked", function () {
    let checkBoxValue = 1;
    if ($(this).prop("checked") == true) {
      checkBoxValue = 1;
    } else {
      checkBoxValue = 0;
    }
    loadNotification(1, checkBoxValue);
  });

  function loadNotification(page, label = 1) {
    if ($("#flexSwitchCheckChecked").prop("checked") == true) {
      label = 1;
    } else {
      label = 0;
    }
    $.ajax({
      url: app_url + "/get-all-unread-notification",
      method: "GET",
      data: { page: page, label: label },
      success: function (response) {
        $(".loader_notification_div").hide();
        // Process the data
        let data = response.data;
        let div_data = "";
        $("#all_notifications_show_div").empty();
        if (data.length > 0) {
          $("#all_notifications_show_div").show();
          $(data).each(function (index, value) {
            div_data += `<div class="overflow-y-auto px-2" id="notification-id-${value.id}">
                                            <div class="relative ${value.bg_color} w-full rounded-md border-2 border-gray-100 box_notification d-flex align-items-center">
                                                <div class="d-flex">
                                                <div class="icon">
                                                    <iconify-icon icon="ic:baseline-email" width="16"></iconify-icon>
                                                </div>
                                                <div class="pl-3">
                                                    <a href="javascript:void(0)" class="single-notification" data-link="${value.details_link}" data-id="${value.id}">
                                                        <p class="text-gray-600 text-sm leading-tight font-bold">
                                                            ${value.message}
                                                        </p>                                                        
                                                    </a>
                                                </div>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions w-10">
                                                    <a href="javascript:void(0)" class="dropdown-notifications-archive remove-single-notification" data-id="${value.id}"
                                                      >
                                                      <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_731_2388)">
<path d="M14.5 7.5C14.5 9.35652 13.7625 11.137 12.4497 12.4497C11.137 13.7625 9.35652 14.5 7.5 14.5C5.64348 14.5 3.86301 13.7625 2.55025 12.4497C1.2375 11.137 0.5 9.35652 0.5 7.5C0.5 5.64348 1.2375 3.86301 2.55025 2.55025C3.86301 1.2375 5.64348 0.5 7.5 0.5C9.35652 0.5 11.137 1.2375 12.4497 2.55025C13.7625 3.86301 14.5 5.64348 14.5 7.5ZM5.18475 4.56525C5.1026 4.4831 4.99118 4.43695 4.875 4.43695C4.75882 4.43695 4.6474 4.4831 4.56525 4.56525C4.4831 4.6474 4.43695 4.75882 4.43695 4.875C4.43695 4.99118 4.4831 5.1026 4.56525 5.18475L6.88138 7.5L4.56525 9.81525C4.52457 9.85593 4.49231 9.90422 4.47029 9.95736C4.44828 10.0105 4.43695 10.0675 4.43695 10.125C4.43695 10.1825 4.44828 10.2395 4.47029 10.2926C4.49231 10.3458 4.52457 10.3941 4.56525 10.4347C4.6474 10.5169 4.75882 10.5631 4.875 10.5631C4.93253 10.5631 4.98949 10.5517 5.04264 10.5297C5.09578 10.5077 5.14407 10.4754 5.18475 10.4347L7.5 8.11862L9.81525 10.4347C9.85593 10.4754 9.90422 10.5077 9.95736 10.5297C10.0105 10.5517 10.0675 10.5631 10.125 10.5631C10.1825 10.5631 10.2395 10.5517 10.2926 10.5297C10.3458 10.5077 10.3941 10.4754 10.4347 10.4347C10.4754 10.3941 10.5077 10.3458 10.5297 10.2926C10.5517 10.2395 10.5631 10.1825 10.5631 10.125C10.5631 10.0675 10.5517 10.0105 10.5297 9.95736C10.5077 9.90422 10.4754 9.85593 10.4347 9.81525L8.11862 7.5L10.4347 5.18475C10.4754 5.14407 10.5077 5.09578 10.5297 5.04264C10.5517 4.98949 10.5631 4.93253 10.5631 4.875C10.5631 4.81747 10.5517 4.76051 10.5297 4.70736C10.5077 4.65422 10.4754 4.60593 10.4347 4.56525C10.3941 4.52457 10.3458 4.49231 10.2926 4.47029C10.2395 4.44828 10.1825 4.43695 10.125 4.43695C10.0675 4.43695 10.0105 4.44828 9.95736 4.47029C9.90422 4.49231 9.85593 4.52457 9.81525 4.56525L7.5 6.88138L5.18475 4.56525Z" fill="#EF4A00"/>
</g>
<defs>
<clipPath id="clip0_731_2388">
<rect width="14" height="14" fill="white" transform="translate(0.5 0.5)"/>
</clipPath>
</defs>
</svg>

                                                      </a>
                                                </div>
                                                
                                            </div>                                            
                                        </div>`;
          });
          $("#all_notifications_show_div").append(div_data);
        } else {
          if (page == 1 && $(".remove-single-notification").length == 0) {
            let message = $("#no_data_found").val();

            div_data = `<li class="list-group-item list-group-item-action dropdown-notifications-item notification_element>
                            <div class="d-flex">
                              <span class="alert alert-danger">${message}</span>
                            </div>
                          </li>`;
            $("#all_notifications_show_div").html(div_data);
            $(".dropdown-menu-footer").addClass("d-none");
          }
          $("#all_notifications_show_div").show();
        }
      },
      error: function (xhr, status, error) {},
    });
  }

  // Flag to prevent multiple simultaneous requests
  $("#all_notifications_show_div").on("scroll", function (e) {
    e.preventDefault();
    let element = $(this);
    let scrollTop = element.scrollTop();
    let scrollHeight = element.prop("scrollHeight");
    let clientHeight = element.prop("clientHeight");
    if (scrollTop + clientHeight >= scrollHeight - 1 && !isLoading) {
      isLoading = true;
      let totalNotification = $("#notification-bell-count").text();
      let totalPage = Math.ceil(totalNotification / 10);
      let nextPage = counter;
      counter += 1;
      if (nextPage > totalPage - 1) {
        counter = 1;
      }
      if (isLoading) {
        $(".loader_notification_div").show();
        $("#all_notifications_show_div").hide();
        loadNotification(nextPage);
      }
      isLoading = false;
    }
  });

  $(document).on("click", ".remove-single-notification", function () {
    let id = $(this).attr("data-id");
    $.ajax({
      url: app_url + "/delete-notification/" + id,
      method: "DELETE",
      success: function (response) {
        if (response.status) {
          $("#notification-id-" + id).remove();
          let notification_div = $(".user-notification_" + auth_id);
          if (notification_div.text() > 0) {
            notification_div.text(response.unread_count);
          }
          toastr.success($("#delete_message").val());
        }
      },
    });
  });

  $(document).on("click", ".single-notification", function () {
    let link = $(this).attr("data-link");
    let id = $(this).attr("data-id");
    $.ajax({
      url: app_url + "/mark-as-read/" + id,
      method: "GET",
      success: function (response) {
        if (response.status) {
          if (link) {
            location.href = link;
          }
        }
      },
    });
    return;
  });

  $(document).on("click", ".mark-all-as-read", function () {
    $.ajax({
      url: app_url + "/mark-as-read-all",
      method: "GET",
      success: function (response) {
        if (response.status) {
          $(".notification_element").removeClass("bg-unseen");
          $(".user-notification_" + auth_id).text(0);
          toastr.success($("#update_message").val());
        }
      },
    });
  });

  $(document).on("click", ".delete-all-notification", function () {
    Swal.fire({
      title: $("#are_you_sure").val(),
      text: $("#confirm_delete_all_notification").val(),
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: $("#yes_delete_it").val(),
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: app_url + "/delete-all-notification",
          method: "DELETE",
          success: function (response) {
            if (response.status) {
              $("#all_notifications_show_div").empty();
              toastr.success($("#delete_message").val());
              $(".notification_element").removeClass("bg-unseen");
              $(".user-notification_" + auth_id).text(0);
            }
          },
        });
      }
    });
  });

  $(".set_collapse").on("click", function () {
    let status = $(this).attr("data-status");
    let status_tmp = "";
    if (status === "Yes") {
      $(this).attr("data-status", "No");
      status_tmp = "No";
    } else {
      $(this).attr("data-status", "Yes");
      status_tmp = "Yes";
    }
    axios.get(app_url + "/set-collapse?status=" + status_tmp);
  });

  // Set active menu
  let url_segment = $("#segment-fetcher").attr("data-id");
  let current_url = window.location.href;

  $(".child-menu").each(function (index, value) {
    let segment_1 = value.href.split("/");
    let full_url = value.href;
    if (current_url == full_url) {
      $(this).parent().addClass("activated");
    }
    if (segment_1.includes(url_segment)) {
      let element = value.closest(".parent-menu");
      let classList = element.className;
      if (classList.indexOf("treeview") !== -1) {
        element.className = "parent-menu active treeview fetch-active";
      } else {
        element.className = "parent-menu active fetch-active";
      }
    }
  });

  $("#menu-search").keyup(function (event) {
    if (event.keyCode === 13) {
      $(".parent-menu")
        .removeClass("d-none active menu-open")
        .find(".fa")
        .removeClass("color-white");
      $(".fetch-active")
        .addClass("active menu-open")
        .find(".fa")
        .addClass("color-white");
    }
  });

  $("#menu-search").on("search", function () {
    $(".parent-menu")
      .removeClass("d-none active menu-open")
      .find(".fa")
      .removeClass("color-white");
    $(".fetch-active")
      .addClass("active menu-open")
      .find(".fa")
      .addClass("color-white");
  });

  $(document).on("keyup", "#menu-search", function () {
    let str_search = $("#menu-search").val();
    if (str_search.length > 3) {
      $(".parent-menu").each(function (i, obj) {
        let status_exist = false;
        $(this)
          .find(".match_bold")
          .each(function (i, obj) {
            let child_menu = $(this).text().toLowerCase();
            if (child_menu.includes(str_search.toLowerCase())) {
              status_exist = true;
            }
          });

        if (status_exist) {
          $(".parent-menu").addClass("d-none");
          $(this)
            .addClass("active menu-open")
            .removeClass("d-none")
            .find(".fa")
            .addClass("color-white");
          matchingBold(str_search);
        } else {
          $(".parent-menu").remove("d-none");
          $(this).removeClass("active menu-open");
          $(this).find(".fa").removeClass("color-white");
        }
      });
    } else {
      $(".parent-menu")
        .removeClass("d-none active menu-open")
        .find(".fa")
        .removeClass("color-white");
      $(".fetch-active")
        .addClass("active menu-open")
        .find(".fa")
        .addClass("color-white");
      $(".match_bold").each(function () {
        let text = $(this).text();
        $(this).text(text);
      });
      //set old view menu
      $(".child-menu").each(function (index, value) {
        let segment_1 = value.href.split("/");
        if (segment_1.includes(url_segment)) {
          let element = value.closest(".parent-menu");
          let classList = element.className;
          if (classList.indexOf("treeview") !== -1) {
            element.className = "parent-menu active treeview fetch-active";
          } else {
            element.className = "parent-menu active fetch-active";
          }
          $(".parent-menu.active").find(".fa").addClass("color-white");
          return false;
        }
      });
    }
  });

  function matchingBold(target_string) {
    $(".match_bold").each(function () {
      let text = $(this).text();
      // Replace the search term with the same term wrapped in a bold tag
      let highlightedText = text.replace(
        new RegExp(target_string, "gi"),
        "<b>$&</b>"
      );
      $(this).html(highlightedText);
    });
  }

  $(document).on("submit", "#common-form", function () {
    showSpin("spinner", "submit-btn");
  });

  $(document).on("click", ".readMore", function () {
    openModal("readmore_modal");
    let desc = $(this).attr("data-desc");
    $("#readmore_desc").html(desc);
  });

  $(document).on("click", ".close_readmore_modal", function () {
    closeModal("readmore_modal");
  });

  $(document).on("select2:open", function (e) {
    document
      .querySelector(`[aria-controls="select2-${e.target.id}-results"]`)
      .focus();
  });
})(jQuery);
