(function($){
    "use strict";
    let app_url = $('input[name="app-url"]').attr('data-app_url');

    $(document).on('click', '.product-category', function(e) {
        $('.product-category').removeClass('active-product');
        $(this).addClass('active-product');
        let product_id = $(this).attr('data-id');
        let type = $(this).attr("data-type");
        getAgents(product_id, type);
    });

    $(document).ready(function () {
       let product_id = $('.first-item').attr('data-id');
       $('.product-category').removeClass('active-product');
        $('.first-item').addClass('active-product');
        let type = $(".first-item").attr("data-type");
        getAgents(product_id, type);
    });
  
    function getAgents(product_id, type) {
        $.ajax({
          url: app_url + "/api/get-product-wise-agents/" + product_id,
          method: "GET",
          data: {
            type: type,
          },
          success: function (response) {
            $("#sequence-form").empty().html(response);
          },
        });
    }

})(jQuery);
