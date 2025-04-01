"use strict";

let header = document.getElementById("header");
let navbarToggler = document.getElementById("navbarToggler");
let base_url = $('input[name="app-url"]').attr("data-app_url");
if (header) {
  let prevScrollPosition = window.pageYOffset;

  function stickyHeader() {
    if (window.pageYOffset > 38) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
  }

  window.addEventListener("load", stickyHeader);
  window.addEventListener("scroll", stickyHeader);

  navbarToggler.addEventListener("click", function () {
    header.classList.toggle("mobile-menu-opened");
  });
}

function mobileDropdownMenu() {
  let sbdropdown = document.querySelectorAll(".dropdown-list").length;

  if (sbdropdown > 0) {
    let navUrl = document.querySelectorAll(".navbar-nav li ul");
    let navUrlLen = navUrl.length;

    for (let i = 0; i < navUrlLen; i++) {
      navUrl[i].insertAdjacentHTML(
        "beforebegin",
        '<div class="dropdown-toggler"><i class="bi bi-chevron-down"></i></div>'
      );
    }

    let ddtroggler = document.querySelectorAll(".dropdown-toggler");
    let ddtrogglerlen = ddtroggler.length;

    for (let i = 0; i < ddtrogglerlen; i++) {
      ddtroggler[i].addEventListener("click", function () {
        let ddNext = ddtroggler[i].nextElementSibling;
        slideToggle(ddNext, 300);
      });
    }
  }
}

window.addEventListener("load", mobileDropdownMenu);

let anchor = document.querySelectorAll('a[href="#"]');
let anchorLength = anchor.length;

if (anchorLength > 0) {
  for (let i = 0; i < anchorLength; i++) {
    anchor[i].addEventListener("click", function (e) {
      e.preventDefault();
    });
  }
}
const keyTextCard = document.querySelectorAll(".top-hero-card");
// :: Search Results

const searchInput = document.getElementById("searchInputModal");
const searchResults = document.getElementById("searchResults");
const crossIcon = document.getElementById("crossIcon");
const searchIcon = document.getElementById("search-icon");

if (searchResults) {
  searchInput.addEventListener("input", function () {
    const inputValue = searchInput.value.trim();

    if (inputValue.length >= 1) {
      searchResults.style.display = "block";
      crossIcon.style.display = "block";
      searchIcon.style.display = "none";
    } else {
      searchResults.style.display = "none";
      crossIcon.style.display = "none";
      searchIcon.style.display = "flex";
    }
  });
}

$(document).on("focus", "#searchInputModal", function () {
  $('html, body').animate({
      scrollTop: $(".search_area_unique").offset().top - 90
  }, 500)
})


$(document).on("click", "#crossIcon", function () {
  $(searchInput).val("");
  $(searchResults).css("display", "none");
  $(this).css("display", "none");
  $(".search-icon").css("display", "flex");
  $(".search-area").removeClass("search-area-active");
  $(".hero-area").removeClass("extra_class_for_overlay");
  $(".overlay").css("display", "none");
  $(".hero-area").css("z-index", "10");
  $(".popular-search-list").removeClass("extra_class_for_bg_change");
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
});

const kbSearchInput = document.getElementById("kbSearchInput");
const kbSearchResults = document.getElementById("kbSearchResults");

if (kbSearchResults) {
  kbSearchInput.addEventListener("input", function () {
    const inputValue = kbSearchInput.value.trim();

    if (inputValue.length >= 3) {
      kbSearchResults.style.display = "block";
    } else {
      kbSearchResults.style.display = "none";
    }
  });
}

// :: About Card

const heroCard = document.querySelectorAll(".top-hero-card");

if (heroCard.length > 0) {
  heroCard.forEach((item) => {
    item.addEventListener("mouseover", () => {
      heroCard.forEach((s) => {
        s.classList.remove("active");
      });
      item.classList.add("active");
    });
  });
}

const aboutCard = document.querySelectorAll(".about-card");

if (aboutCard.length > 0) {
  aboutCard.forEach((item) => {
    item.addEventListener("mouseover", () => {
      aboutCard.forEach((s) => {
        s.classList.remove("active");
      });
      item.classList.add("active");
    });
  });
}

// :: Nice Select

let heroSelect = document.getElementById("heroSelect");

if (heroSelect) {
  NiceSelect.bind(heroSelect, {
    searchable: false,
  });
}

let chatSelect = document.getElementById("chatSelect");

if (chatSelect) {
  NiceSelect.bind(chatSelect, {
    searchable: true,
  });
}

let forumSelect = document.getElementById("forumSelect");

if (forumSelect) {
  NiceSelect.bind(forumSelect, {
    searchable: false,
  });
}

let forgetPassSelect = document.getElementById("forgetPassSelect");

if (forgetPassSelect) {
  NiceSelect.bind(forgetPassSelect, {
    searchable: false,
  });
}

// :: ChatBox

const chatboxTrigger = document.getElementById("chatboxTrigger");
const chatboxBody = document.getElementById("chatboxBody");

if (chatboxTrigger) {
  chatboxTrigger.addEventListener("click", function () {
    let userIp = localStorage.getItem("user_ip");
    $(".message-box").attr("id", "message-box_" + userIp);
    $(".set-chat-box").attr("id", "gust-chat-message_" + userIp);
    $(".guest-user-name").attr("id", "guest-user-name_" + userIp);
    $(".guest-user-email").attr("id", "guest-user-email_" + userIp);
    $(".chat-box-product").attr("id", "category-box_" + userIp);
    $(".selected-product-category").attr("id", "selected-product_" + userIp);
    $(".selected-guest-name").attr("id", "selected-guest-name_" + userIp);
    $(".selected-guest-email").attr("id", "selected-guest-email_" + userIp);
    $(".invalid-email-error").attr("id", "invalid-email-error_" + userIp);
    $(".chat-box-product").addClass("category-box-" + userIp);
    $(".chat-close-btn").addClass("chat-close-btn-" + userIp);
    $(".guest-close-chat-form").attr("id", "guest-close-chat-form_" + userIp);
    $(".customer-send-message").attr("id", "customer-send-message_" + userIp);
    $(".agent-name").attr("id", "agent-name_" + userIp);
    $(".guest-product").attr("id", "guest-product_" + userIp);

    this.classList.toggle("active");
    chatboxBody.classList.toggle("active");

    $("#gust-chat-message_" + userIp).scrollTop(
      $("#gust-chat-message_" + userIp)[0].scrollHeight
    );
  });
}

// :: Counter Up

let counterlen = document.querySelectorAll(".counter").length;
console.log(counterlen);
if (counterlen > 0) {
  let counterUp = window.counterUp.default;

  let callback = (entries) => {
    entries.forEach((entry) => {
      let counterElement = entry.target;
      if (
        entry.isIntersecting &&
        !counterElement.classList.contains("is-visible")
      ) {
        counterUp(counterElement, {
          duration: 2000,
          delay: 20,
        });
        counterElement.classList.add("is-visible");
      }
    });
  };

  let IO = new IntersectionObserver(callback, {
    threshold: 1,
  });

  let counterUpClass = document.querySelectorAll(".counter");
  let counterUpClasslen = counterUpClass.length;

  for (let i = 0; i < counterUpClasslen; i++) {
    IO.observe(counterUpClass[i]);
  }
}

// :: Scroll to Top

let scrollButton = document.getElementById("scrollToTopButton");
let topdistance = 600;

if (scrollButton) {
  window.addEventListener("scroll", function () {
    if (
      document.body.scrollTop > topdistance ||
      document.documentElement.scrollTop > topdistance
    ) {
      scrollButton.classList.add("scrolltop-show");
      scrollButton.classList.remove("scrolltop-hide");
    } else {
      scrollButton.classList.add("scrolltop-hide");
      scrollButton.classList.remove("scrolltop-show");
    }
  });

  scrollButton.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: "smooth",
    });
  });
}

// :: Masonry Gallery

let masonryWrapper = document.querySelectorAll(".masonary-wrapper");

if (masonryWrapper.length > 0) {
  masonryWrapper.forEach(function (container) {
    imagesLoaded(masonryWrapper, function () {
      new Isotope(container, {
        itemSelector: ".col-12",
        percentPosition: true,
        masonry: {
          columnWidth: ".col-12",
        },
      });
    });
  });
}

// :: Tooltip

let tooltips = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
let tooltipList = tooltips.map(function (tooltipss) {
  return new bootstrap.Tooltip(tooltipss);
});

// :: Toast

let toasts = [].slice.call(document.querySelectorAll(".toast"));
let toastList = toasts.map(function (toastss) {
  return new bootstrap.Toast(toastss);
});
toastList.forEach((toast) => toast.show());

// :: Popover

let popovers = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="popover"]')
);
let popoverList = popovers.map(function (popoverss) {
  return new bootstrap.Popover(popoverss);
});

// :: WOW
const WowContainer = document.querySelectorAll(".wow");

if (WowContainer.length > 0) {
  new WOW().init();
}

// custom Cursor

if ($(".custom-cursor").length) {
  var cursor = document.querySelector(".custom-cursor__cursor");

  var cursorinner = document.querySelector(".custom-cursor__cursor-two");

  var a = document.querySelectorAll("a");

  document.addEventListener("mousemove", function (e) {
    var x = e.clientX;

    var y = e.clientY;

    cursor.style.transform = `translate3d(calc(${e.clientX}px - 50%), calc(${e.clientY}px - 50%), 0)`;
  });

  document.addEventListener("mousemove", function (e) {
    var x = e.clientX;

    var y = e.clientY;

    cursorinner.style.left = x + "px";

    cursorinner.style.top = y + "px";
  });

  document.addEventListener("mousedown", function () {
    cursor.classList.add("click");

    cursorinner.classList.add("custom-cursor__innerhover");
  });

  document.addEventListener("mouseup", function () {
    cursor.classList.remove("click");

    cursorinner.classList.remove("custom-cursor__innerhover");
  });

  a.forEach((item) => {
    item.addEventListener("mouseover", () => {
      cursor.classList.add("custom-cursor__hover");
    });

    item.addEventListener("mouseleave", () => {
      cursor.classList.remove("custom-cursor__hover");
    });
  });
}

// :: Preloader

let preloader = document.getElementById("preloader");

if (preloader) {
  window.addEventListener("load", function () {
    let fadeOut = setInterval(function () {
      if (!preloader.style.opacity) {
        preloader.style.opacity = 1;
      }
      if (preloader.style.opacity > 0) {
        preloader.style.opacity -= 0.1;
      } else {
        clearInterval(fadeOut);
        preloader.remove();
      }
    }, 50);
  });
}
$(".support_policy").find("strong").parent().addClass("bottom_margin_3");

$(document).on("change", ".is-empty", function () {
  $(".chat-box-footer").removeClass("custom-select-item");
});

let select2Instance = null;
$(document).on("focus", "#searchInputHeroArea", function () {
  $("#searchBoxModal").modal("show");  
  $("#searchInputModal").focus();
  let product_id = $(".product_category_id").val();
  let categorySelect = document.getElementById("categorySelect");
  if (categorySelect) {
    select2Instance =  NiceSelect.bind(categorySelect, {
      searchable: false,
    });

    select2Instance.update(product_id);
  }
});

$(document).on("click", ".modal_close_icon", function () {
  $("#searchBoxModal").modal("hide");  
  select2Instance.destroy();
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
  $(searchInput).val("");
  $(searchResults).css("display", "none");
  $("#crossIcon").css("display", "none");
  $(".search-icon").css("display", "flex");
})

$(document).on("blur", "#searchInput", function () {
  $(".article-breadcrumb-wrapper").css("z-index", "10");
});

$(window).scroll(function () {
  if ($(this).scrollTop() > 0) {
    $(".article-breadcrumb-wrapper").css("z-index", "10");
  }
});

$(document).on("click", "#navbarToggler", function () {
  $("#navbarContent").toggleClass("displayContent");
});

function isValidEmail(email) {
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(email);
}

/**
 * Register Buttom Disabled
 */

$(".r_fname, .r_lname, .r_email, .r_pass, .r_cpass").on("keyup", function () {
  let email = $(".r_email").val();
  let fname = $(".r_fname").val();
  let lname = $(".r_lname").val();
  let password = $(".r_pass").val();
  let cpassword = $(".r_cpass").val();

  // Check if all fields are filled
  if (
    email !== "" &&
    fname !== "" &&
    password !== "" &&
    lname !== "" &&
    cpassword !== ""
  ) {
    if (isValidEmail(email)) {
      $("#register_btn").prop("disabled", false);
    } else {
      $("#register_btn").prop("disabled", true);
    }
  } else {
    $("#register_btn").prop("disabled", true);
  }
});

/**
 * Password Show
 */

$(document).on("click", ".password-icon", function () {
  let passwordField = $(this)
    .closest(".form-group")
    .find(".password-field-for-js");
  let passwordFieldType = passwordField.attr("type");
  if (passwordFieldType == "password") {
    passwordField.attr("type", "text");
    $(this).attr("src", base_url + "/assets/frontend/img/core-img/hide.png");
  } else {
    passwordField.attr("type", "password");
    $(this).attr(
      "src",
      base_url + "/assets/frontend/img/core-img/password.svg"
    );
  }
});

/**
 * Forgot Password Form
 */

$('input[type="email"]').on("keyup", function () {
  let email = $(this).val();
  // Check if all fields are filled
  if (email !== "") {
    if (isValidEmail(email)) {
      $(".submit_btn").prop("disabled", false);
    } else {
      $(".submit_btn").prop("disabled", true);
    }
  } else {
    $(".submit_btn").prop("disabled", true);
  }
});

$(".f_pass, .f_cpass").on("keyup", function () {
  let password = $(".f_pass").val();
  let cpassword = $(".f_cpass").val();

  // Check if all fields are filled
  if (password !== "" && cpassword !== "") {
    if (password == cpassword) {
      $(".submit_button").prop("disabled", false);
    } else {
      $(".submit_button").prop("disabled", true);
    }
  } else {
    $(".submit_button").prop("disabled", true);
  }
});

//Mobile Menu

$(document).on("click", ".dropdown-list-a", function () {
  $(".dropdown-body").slideToggle(300);
  $(this).toggleClass("active");
});
$(document).on("mouseenter", ".copy_btn", function () {
  $(this).tooltip({
    title: "Copy Link!",
    placement: "top",
  });
});
// Click Copy Button Copy Data
$(document).on("click", ".copy_btn", function () {
  let dataLink = $(this).attr("data-link");
  let tempInput = $("<input>");
  $("body").append(tempInput);
  tempInput.val(dataLink).select();
  document.execCommand("copy");
  tempInput.remove();
  $(this).tooltip("dispose");
  $(this).tooltip({
    title: "Copied!",
    placement: "top",
  });
  $(this).tooltip("show");
});

$(document).on("mouseleave", ".copy_btn", function () {
  $(this).tooltip("dispose");
});

//Fontsize increase

$(document).on("click", ".increase-font", function () {
  let currentSizeP = parseInt(
    $("#for_print_pdf_title").css("font-size")
  );
  let newSizeP = currentSizeP + 2;
  $("#for_print_pdf_title").css("font-size", newSizeP + "px");

  /**Details Page */

  $(
    ".for_print_pdf_content *"
  ).each(function () {
    let currentFontSize = parseFloat($(this).css("font-size"));
    let newFontSize = currentFontSize + 1;
    $(this).css("font-size", newFontSize + "px");
  });
});

// Default
$(document).on("click", ".default-font", function () {
  $(".article_list_for h2").css("font-size", "24px");
  $("#for_print_pdf_title").css("font-size", "38px");
  $(".article-details-wrapper-page .article-details h2").css(
    "font-size",
    "48px"
  );

  $(
    ".for_print_pdf_content *"
  ).each(function () {
    let newFontSize = 18;
    $(this).css("font-size", newFontSize + "px");
  });
});

//Fontsize decrease

$(document).on("click", ".decrease-font", function () {
  let currentSizeP = parseInt(
    $("#for_print_pdf_title").css("font-size")
  );
  let newSizeP = currentSizeP - 2;
  $("#for_print_pdf_title").css("font-size", newSizeP + "px");

  /**Details Page */

  $(
    ".for_print_pdf_content *"
  ).each(function () {
    let currentFontSize = parseFloat($(this).css("font-size"));
    let newFontSize = currentFontSize - 1;
    $(this).css("font-size", newFontSize + "px");
  });
});

$(document).on("click", ".mobile-menu", function () {
  $(".top-header").addClass("zindex0");
});

$(document).on("click", ".btn-close", function () {
  $(".top-header").removeClass("zindex0");
});

/**Article Page */
// Pdf Export
$(document).on("click", ".pdf_btn", function (e) {
  let article_id = $("#article-id").val();
  let blog_id = $("#blog_id").val();
  $.ajax({
    url: base_url + "/pdf-download",
    method: "POST",
    data: {
        article_id: article_id,
        blog_id: blog_id,
    },
    success: function (response) {
        let pdf_link = response.pdf_link;
        //download using a pdf link
        window.open(pdf_link, "_blank");        
    },
  })
});

// Print Content
$(document).on("click", ".print_btn", function (e) {
  let title = $("#for_print_pdf_title").text();
  let content = $("#for_print_pdf_content").html();
  let bodyTitle = $("#for_print_title").val();

  let printWindow = window.open(
    "",
    "_blank",
    "location=no,width=900,height=700,left=250"
  );
  printWindow.document.write(
    `<html><head><title>${title}</title></head><body>
    <h3>${bodyTitle}</h3>
    ${content}
    </body></html>`
  );
  printWindow.document.close();
  // Print the new window
  printWindow.print();
  setTimeout(() => {
    printWindow.close();
  }, 2000);
});
// Vote yes
$(document).on("click", "#vote-yes", function () {
  let article_id = $("#article-id").val();
  let is_login = $("#is_login").val();
  if (is_login == 0) {
    showNotify("warning", "Warning!", `Please Login First!<a href="${base_url}/customer/login">Click here to Login</a>`);
  } else {
    $.ajax({
      url: base_url + "/vote-yes/" + article_id,
      method: "GET",
      success: function (response) {
        $(".vote-yes-count").text(response);
        $(".vote-no").prop("disabled", true);
        $(".vote-yes").prop("disabled", true);
        showNotify("success", "Success!", 'Thank you for your feedback!');
      },
    });
  }
});
// Vote no
$(document).on("click", "#vote-no", function () {
  let article_id = $("#article-id").val();
  let is_login = $("#is_login").val();
  if (is_login == 0) {
    showNotify("warning", "Warning!", `Please Login First!<a href="${base_url}/customer/login">Click here to Login</a>`);
  } else {
    $.ajax({
      url: base_url + "/vote-no/" + article_id,
      method: "GET",
      success: function (response) {
        $(".vote-no-count").text(response);
        $(".vote-no").prop("disabled", true);
        $(".vote-yes").prop("disabled", true);
        showNotify("success", "Success!", 'Thank you for your feedback!');
      },
    });
  }
});

$("#chatboxTrigger").on("click", function () {
  if ($(".offcanvas-backdrop").length > 0) {
    $(".offcanvas-backdrop").remove();
  }else{
    $("body").append("<div class='offcanvas-backdrop fade show'></div>");
  }
  
});

// $("#chatboxTrigger .close").on("click", function () {
//   $(".offcanvas-backdrop").remove();
// });


$(document).ready(function () {
  $(".center").slick({
    dots: true,
    infinite: true,
    centerMode: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
});

$(document).on("change", "#light_dark_mode", function () {
  if ($(this).is(":checked")) {
    $("body").addClass("dark-mode");
  } else {
    $("body").removeClass("dark-mode");
  }
});

$(document).on("submit", ".subscribe_form", function (e) {
  e.preventDefault();
  let email = $(".email_subscribe").val();
  console.log(email);
  let error = false;
  if (email == '') {
    error = true;
    showNotify("error", "Error", "Please enter your email address");
  }

  if (email != '' && !validateEmail(email)) {
    error = true;
    showNotify("error", "Error", "Please enter a valid email address");
  }

  if (!error) {
    $.ajax({
      url: base_url + "/subscribe_store",
      method: "POST",
      data: {
        email: email
      },
      success: function (response) {
        if (response.status == "success") {
          showNotify("success", "Success", response.message);
          $("#email_subscribe").val("");
        } else {
          showNotify("error", "Error", response.message);
        }
      }
    });
  }
});

$(document).on("submit", ".offcanvas-body-form", function (e) {
  e.preventDefault();
  let email = $(".email_subscribe_off_canvas").val();
  console.log(email);
  let error = false;
  if (email == '') {
    error = true;
    showNotify("error", "Error", "Please enter your email address");
  }

  if (email != '' && !validateEmail(email)) {
    error = true;
    showNotify("error", "Error", "Please enter a valid email address");
  }

  if (!error) {
    $.ajax({
      url: base_url + "/subscribe_store",
      method: "POST",
      data: {
        email: email
      },
      success: function (response) {
        if (response.status == "success") {
          showNotify("success", "Success", response.message);
          $("#email_subscribe").val("");
        } else {
          showNotify("error", "Error", response.message);
        }
      }
    });
  }
});

function validateEmail(email) {
  const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return regex.test(email);
}

$(document).on("click", ".accordion-button", function () {
  let item = $(".accordion-item");
  if (item.hasClass("active")) {
    item.removeClass("active");
  } else {
    item.addClass("active");
  }
});

$("#blog_carousel").owlCarousel({
  loop: true,
  margin: 15,
  dots: true,
  responsive: {
    0: {
      // For smaller screens
      items: 1,
    },
    768: {
      // For medium screens
      items: 2,
    },
    1200: {
      // For screens between 1200px and 1400px
      items: 3,
    },
    1400: {
      // For larger screens
      items: 3,
    },
  },
});

$("#testimonial_carousel").owlCarousel({
  loop: true,
  margin: 25,
  dots: true,
  items: 3,
  responsive: {
    0: {
      // For smaller screens
      items: 1,
    },
    950: {
      // For medium screens
      items: 2,
    },
    1200: {
      // For screens between 1200px and 1400px
      items: 2,
    },
    1400: {
      // For larger screens
      items: 3,
    },
  },
});

var owl = $(".owl-carousel");
$(".customNextBtn").click(function () {
  owl.trigger("next.owl.carousel");
});
$(".customPrevBtn").click(function () {
  owl.trigger("prev.owl.carousel");
});


$("#knowledge_base_carousal").owlCarousel({
  loop: true,
  margin: 25,
  dots: true,
  items: 3,
  responsive: {
    0: {
      // For smaller screens
      items: 1,
    },
    950: {
      // For medium screens
      items: 2,
    },
    1200: {
      // For screens between 1200px and 1400px
      items: 3,
    },
    1400: {
      // For larger screens
      items: 3,
    },
  },
});

function showNotify(status, title, text) {
  new Notify ({
    status: status,
    title: title,
    text: text,
    effect: 'fade',
    speed: 300,
    customClass: '',
    customIcon: '',
    showIcon: true,
    showCloseButton: true,
    autoclose: true,
    autotimeout: 3000,
    notificationsGap: null,
    notificationsPadding: null,
    type: 'outline',
    position: 'right bottom',
    customWrapper: '',
  })
}

$(document).on("click", ".service_read_more", function () {
  let title = $(this).attr("data-title");
  let content = $(this).attr("data-content");
  $("#serviceModal .modal-title").text(title);
  $("#serviceModal .modal-body").html(content);
})

let banner_text = $(".banner_text").text();
let result = banner_text.replace(/::(.*?)::/g, '<span>$1</span>');
console.log(result);
$(".banner_text").html(result);