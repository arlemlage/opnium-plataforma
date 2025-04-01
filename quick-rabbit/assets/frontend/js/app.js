$(function () {
  "use strict";
  let base_url = $('input[name="app-url"]').attr("data-app_url");

  let active_page = $("#active_page").val();
  if (
    active_page != undefined &&
    active_page !== "Blogs" &&
    active_page !== "Home"
  ) {
    setTimeout(function () {
      $("html, body").animate(
        {
          scrollTop: $("#focused-div").offset().top,
        },
        100
      );
    }, 100);
  } else if (active_page == undefined) {
    if($("#focused-div").length > 0){
      setTimeout(function () {
        $("html, body").animate(
          {
            scrollTop: $("#focused-comment").offset().top,
          },
          100
        );
      }, 100);
    }
  }

  $(".pagination")
    .find(".page-link")
    .first()
    .text("")
    .addClass("bi bi-arrow-left");
  $(".pagination")
    .find(".page-link")
    .last()
    .text("")
    .addClass("bi bi-arrow-right");

  if (active_page != undefined && active_page == "Home") {
    $(".first-row").trigger("click");
  }

  function loader() {
    $("#searchResults").empty();
    let html = `<nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button class="nav-link"
                                                    id="search1-tab" data-bs-toggle="tab" data-bs-target="#search1"
                                                    type="button" role="tab" aria-controls="search1"
                                                    aria-selected="true">Article</button>

                                                <button class="nav-link"
                                                    id="search2-tab" data-bs-toggle="tab" data-bs-target="#search2"
                                                    type="button" role="tab" aria-controls="search2"
                                                    aria-selected="false">Faq</button>

                                                <button class="nav-link"
                                                    id="search3-tab" data-bs-toggle="tab" data-bs-target="#search3"
                                                    type="button" role="tab" aria-controls="search3"
                                                    aria-selected="false">Blog</button>

                                                <button class="nav-link"
                                                    id="search4-tab" data-bs-toggle="tab" data-bs-target="#search4"
                                                    type="button" role="tab" aria-controls="search4"
                                                    aria-selected="false">Page</button>
                                                <button class="nav-link" id="search5-tab" data-bs-toggle="tab"
                                                    data-bs-target="#search5" type="button" role="tab"
                                                    aria-controls="search5" aria-selected="false">AI</button>
                                            </div>
                                        </nav>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 text-center">
                                                <h4 class="card-title">System is looking for solutions in Knowledgebase, Blogs, AI, and other places</h4>
                                                <div class="lds-facebook loader-img">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>`;

    $("#searchResults").html(html);
  }
  let typingTimer;
  let doneTypingInterval = 1000;
  $(document).on("keyup", ".search-key", function () {
    loader();
    let product_id = $(".product_category_id").val();
    let query = $(".search-key").val();
    console.log(product_id);
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function () {
      displaySearchResult(query, product_id);
    }, doneTypingInterval);
  });

  $(document).on();

  $(document).on("change", ".product_category_id", function () {
    let product_id = $(".product_category_id").val();
    console.log(product_id);
    let query = $(".search-key").val();
    displaySearchResult(query, product_id);
  });

  $(document).on("change", ".product_category_id_modal", function () {
    let product_id = $(".product_category_id_modal").val();
    let query = $(".search-key").val();
    displaySearchResult(query, product_id);
  });

  function displaySearchResult(query, product_id) {
    if (query.length > 1) {
      $(".search_suggest").show();
      $.ajax({
        method: "GET",
        url: base_url + "/api/search-result",
        data: {
          query: query,
          product_id: product_id,
          lan: $("#session_lan").val(),
        },
        success: function (response) {
          if (response.length > 0) {
            $("#searchResults").css("display", "block");
            $("#searchResults").html(response);
            makeMatchingBold(query, "search-result-title-content");
          } else {
            $("#searchResults").css("display", "none");
          }
        },
      });
    } else {
      $("#searchResults").css("display", "none");
    }
  }

  $(document).on("keyup", "#kbSearchInput", function () {
    let query = $("#kbSearchInput").val();
    if (!query.trim() == "" && query != "") {
      displayProduct(query);
    } else {
      $("#kbSearchResults").css("display", "none");
    }
  });

  function displayProduct(query) {
    if (query.length > 0) {
      $.ajax({
        method: "GET",
        url: base_url + "/api/search-product",
        data: {
          query: query,
        },
        success: function (response) {
          if (response.length > 0) {
            $("#kbSearchResults").css("display", "block").html(response);
            makeMatchingBold(query, "search-result-title");
          } else {
            $("#kbSearchResults").css("display", "none");
          }
        },
      });
    } else {
      $("#kbSearchResults").css("display", "none");
    }
  }

  function makeid(length) {
    let result = "";
    const characters = "0123456789";
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
  }

  let device_key = localStorage.getItem("user_ip");
  if (!device_key) {
    let unique_id = makeid(10);
    if (checkBrowserId(unique_id)) {
      unique_id = makeid(10);
    }
    localStorage.setItem("user_ip", makeid(10));
  }

  function checkBrowserId(unique_id) {
    let status = false;
    $.ajax({
      url: base_url + "/api/check-browser-id/" + unique_id,
      method: "GET",
      async: false,
      success: function (response) {
        status = response;
      },
    });
    return status;
  }
  let userIp = localStorage.getItem("user_ip");
  setCookie("user_ip", userIp, 9000);

  function setCookie(name, value, days) {
    let expires = "";
    if (days) {
      let date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  let cookie_agreement = localStorage.getItem("cookie_agreement");
  if (cookie_agreement != null) {
    $(".cookies-area").addClass("d-none");
  }

  $(document).on("click", ".cookie-agreement", function () {
    let agreement_value = $(this).attr("data-text");
    localStorage.setItem("cookie_agreement", agreement_value);
    $(".cookies-area").addClass("d-none");
  });

  $(document).on("click", "#close-chat-", function () {
    Swal.fire({
      title: "Are you sure?",
      text: "You want to close this chat",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, close it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $("#guest-close-chat-form_" + userIp).submit();
      }
    });
  });

  $(document).on("submit", "#common-form", function () {
    $("#make-disabled").prop("disabled", true);
  });

  function sanitizeInput(input) {
    return input
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

});
