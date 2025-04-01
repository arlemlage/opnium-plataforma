"use strict";
$(function () {
  let base_url = $('input[name="app-url"]').attr("data-app_url");
  let resultView = $(".result-view");
  let searchBox = $(".product-search-box");
  let selectOption = $(".select-option");
  let bodyElement = $("body");

  const displayAllGroupButton = (product_slug) => {
    let link = base_url + "/article/" + product_slug;
    $(".all-group-link").attr("href", link);
  };

  // TODO: Open Search Box
  searchBox.on("click", ".result-view label", function () {
    searchBox.find(".search-dropdown").slideToggle(300);
  });

  // TODO: Open search box when it has result
  searchBox.on("click", ".has-result .inner-wrapper", function () {
    searchBox.find(".search-dropdown").slideDown(300);
  });

  // TODO: Search Product
  $("#search-product").on("keyup", function (e) {
    let filter, ul, li, a, i, txtValue;
    filter = e.target.value.toLowerCase();
    ul = $(".product-list");
    li = ul.find("li");
    for (i = 0; i < li.length; i++) {
      a = li[i];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toLowerCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  });

  $(".center").on("swipe", function (event, slick, currentSlide) {
    let product_id = $(document).find(`.slick-current a`).attr('data-id');
    let active_product = $(document).find(".documentation-active");
    let current_div_id = active_product.attr("data-id");
    showHideSection(current_div_id, product_id);
  });

  $(".center").on("afterChange", function (event, slick, currentSlide) {
    let product_id = $(document).find(`.slick-current a`).attr("data-id");
    let active_product = $(document).find(".documentation-active");
    let current_div_id = active_product.attr("data-id");
    showHideSection(current_div_id, product_id);
  });

  function showHideSection(current_div_id, product_id) {
    $("#single_product_" + current_div_id).removeClass("documentation-active");
    $("#single_product_" + current_div_id).addClass("documentation-inactive");

    $("#single_product_" + product_id).removeClass("documentation-inactive");
    $("#single_product_" + product_id).addClass("documentation-active");

    $("#no_article_sec_" + current_div_id).removeClass("documentation-active");
    $("#no_article_sec_" + current_div_id).addClass("documentation-inactive");

    $("#no_article_sec_" + product_id).removeClass("documentation-inactive");
    $("#no_article_sec_" + product_id).addClass("documentation-active");
  }



  // TODO: Showing result on result box
  $(".product-list").on("click", "li", function (e) {
    let title = $(this).attr("data-title");
    let description = $(this).attr("data-description");
    let thumb = $(this).attr("data-thumb");

    resultView.find(".has-result .inner-wrapper").remove(); // TODO: remove If exits any content

    if (selectOption.find("i").hasClass("bi-caret-up-fill")) {
      selectOption
        .find("i")
        .removeClass("bi-caret-up-fill")
        .addClass("bi-caret-down-fill");
    }

    let dataHtml = `
            <div class="inner-wrapper">
                <div class="wrap">
                <img src="${thumb}" alt="product">
                <div>
                    <h3 class="title">${title}</h3>
                    <p class="description">${description}</p>
                </div>
                </div>
                <button class="clear-result" type="button">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        `;

    resultView.find(".select-option").fadeOut(0);
    resultView.find(".has-result").append(dataHtml);
    resultView.find(".has-result").fadeIn(0);
    searchBox.find(".search-dropdown").slideUp(300);

    let product_id = $(this).attr("data-id");
    let product_slug = $(this).attr("data-slug");
    let active_product = $(document).find(".documentation-active");
    let current_div_id = active_product.attr("data-id");

    $("#single_product_" + current_div_id).removeClass("documentation-active");
    $("#single_product_" + current_div_id).addClass("documentation-inactive");

    $("#single_product_" + product_id).removeClass("documentation-inactive");
    $("#single_product_" + product_id).addClass("documentation-active");

    $("#no_article_sec_" + current_div_id).removeClass("documentation-active");
    $("#no_article_sec_" + current_div_id).addClass("documentation-inactive");

    $("#no_article_sec_" + product_id).removeClass("documentation-inactive");
    $("#no_article_sec_" + product_id).addClass("documentation-active");

    displayAllGroupButton(product_slug);
  });

  // TODO: Display Active Article Link
  (function () {
    let product_slug = $(document)
      .find(".documentation-active")
      .attr("data-slug");
    console.log({ product_slug, base_url });
    displayAllGroupButton(product_slug);
  })();
  // TODO: Set active article link on see all button

  // TODO: Clear result box
  $(".has-result").on("click", ".clear-result", function () {
    resultView.find(".has-result").fadeOut(0);
    resultView.find(".select-option").fadeIn(0);
    searchBox.find(".search-dropdown").slideUp(300);

    if (selectOption.find("i").hasClass("bi-caret-down-fill")) {
      selectOption
        .find("i")
        .removeClass("bi-caret-down-fill")
        .addClass("bi-caret-up-fill");
    } else {
      selectOption
        .find("i")
        .removeClass("bi-caret-up-fill")
        .addClass("bi-caret-down-fill");
    }
  });

  // TODO: Hide Product Dropdown Menu When Click On Outside of menu
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".product-search-box").length) {
      searchBox.find(".search-dropdown").slideUp(300);

      if (selectOption.find("i").hasClass("bi-caret-up-fill")) {
        selectOption
          .find("i")
          .removeClass("bi-caret-up-fill")
          .addClass("bi-caret-down-fill");
      }
    }
  });

  /**
   *  TODO: Show and Hide Article Reply Form
   * */


  $(".reply-btn").on("click", function () {
    $(this).parent().parent().parent().find(".reply-form").slideToggle();
  });

  AOS.init();

  // Menu Click and Active class add
  $(document).on("click", "#home_url", function (e) {
    e.preventDefault();
    $(".set_active").removeClass("active");
    $(this).addClass("active");
    var targetSection = $($(this).attr("href"));
    $("html, body").animate(
      {
        scrollTop: targetSection.offset().top,
      },
      1000
    );
  });

  /**
   * Click Menu Knowldge article
   */
  $(document).on("click", "#menu_knowledge-article", function (e) {
    e.preventDefault();
    $(".set_active").removeClass("active");
    $(this).addClass("active");
    var targetSection = $($(this).attr("href"));
    $("html, body").animate(
      {
        scrollTop: targetSection.offset().top,
      },
      1000
    );
  });
  /**
   * Click Menu FAQ
   */
  $(document).on("click", "#menu_faq", function (e) {
    e.preventDefault();
    $(".set_active").removeClass("active");
    $(this).addClass("active");
    var targetSection = $($(this).attr("href"));
    $("html, body").animate(
      {
        scrollTop: targetSection.offset().top,
      },
      1000
    );
  });
  /**
   * Click Menu Blog
   */
  $(document).on("click", "#menu_blog", function (e) {
    e.preventDefault();
    $(".set_active").removeClass("active");
    $(this).addClass("active");
    var targetSection = $($(this).attr("href"));
    $("html, body").animate(
      {
        scrollTop: targetSection.offset().top,
      },
      1000
    );
  });

  // Contact Page form
  $(document).on("focus", ".contact_name", function () {
    $(".required_symbol_name").css("opacity", "0");
  });
  $(document).on("blur", ".contact_name", function () {
    let value = $(this).val();
    if (value.length > 0) {
      $(".required_symbol_name").css("opacity", "0");
    } else {
      $(".required_symbol_name").css("opacity", "1");
    }
  });
  $(document).on("focus", ".contact_email", function () {
    $(".required_symbol_email").css("opacity", "0");
  });
  $(document).on("blur", ".contact_email", function () {
    let value = $(this).val();
    if (value.length > 0) {
      $(".required_symbol_email").css("opacity", "0");
    } else {
      $(".required_symbol_email").css("opacity", "1");
    }
  });
  $(document).on("focus", ".contact_subject", function () {
    $(".required_symbol_subject").css("opacity", "0");
  });
  $(document).on("blur", ".contact_subject", function () {
    let value = $(this).val();
    if (value.length > 0) {
      $(".required_symbol_subject").css("opacity", "0");
    } else {
      $(".required_symbol_subject").css("opacity", "1");
    }
  });

  $(".owl-carousel").owlCarousel({
        items: 1,
        loop: false,
        mouseDrag: false,
        touchDrag: false,
        pullDrag: false,
        rewind: true,
        autoplay: true,
        margin: 0,
        nav: false,
        smartSpeed: 1000,
        autoplayHoverPause:true
    });
  
});
