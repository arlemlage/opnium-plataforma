$(function () {
  ("use strict");
  let base_url = $('input[name="app-url"]').attr("data-app_url");

  $(function () {
    let product_slug = $(".documentation-active").attr("data-slug");
    displayAllGroupButton(product_slug);
  });

  $(document).on("click", ".product-category-list", function () {
    let product_id = $(this).attr("data-id");
    let product_slug = $(this).attr("data-slug");
    let active_product = $(".documentation-active");
    let current_div_id = active_product.attr("data-id");
    $("#slider_product_" + current_div_id).removeClass("documentation-active");
    $("#slider_product_" + product_id).addClass("documentation-active");
    displayAllGroupButton(product_slug);
  });

  function displayAllGroupButton(product_slug) {
    let link = base_url + "/article/" + product_slug;
    $("#all-group-button").attr("href", link);
  }

  function displayArticleGroup(product_id) {
    let lan = $("#session_lan").val();
    $.ajax({
      method: "GET",
      url:
        base_url +
        "/api/get-product-wise-article-group/" +
        product_id +
        "/" +
        lan,
      success: function (response) {
        $(".slider-for").html(response);
      },
    });
  }

  $(document).on("click", ".accordion-button", function () {
    $(".accordion-item").removeClass("collapse-accordion-item");
    $(".accordion-collapse").removeClass("show");
    $(".accordion-button").addClass("collapsed");
    if ($(this).attr("aria-expanded") == "true") {
      var collapseId = $(this).attr("aria-controls");
      $(".accordion-item")
        .filter(function () {
          return $(this).find(".accordion-collapse").attr("id") === collapseId;
        })
        .addClass("collapse-accordion-item");
      $(this).removeClass("collapsed");
    } else {
      var collapseId = $(this).attr("aria-controls");
      $(".accordion-item")
        .filter(function () {
          return $(this).find(".accordion-collapse").attr("id") === collapseId;
        })
        .removeClass("collapse-accordion-item");
    }
  });

  var owl = $(".owl-carousel");
  owl.owlCarousel({
    items: 1,
    autoplay: true,
  });
  $(".customNextBtn").click(function () {
    owl.trigger("next.owl.carousel");
  });
  $(".customPrevBtn").click(function () {
    owl.trigger("prev.owl.carousel");
  });

  /**
   * Video Link Click
   */

  $(document).on("click", ".video_title", function (e) {
    let link = $(this).data('link');
    let image = $(this).data('img');
    $("li").removeClass("active_item");
    $(this).closest("li").addClass("active_item");
    image = base_url + "/uploads/article_videos/" + image;
    link = base_url + "/uploads/article_videos/" + link;
    $(".video_image").attr("src", image);
    $(".video-popup").attr("href", link);
  });

});

$(document).ready(function ($) {
  $(".video-popup").magnificPopup({
    type: "iframe",
    mainClass: "mfp-fade",
    removalDelay: 160,
    preloader: true,
    fixedContentPos: false,
  });
});