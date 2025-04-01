$(function(e){
    "use strict";
    let app_url = $('input[name="app-url"]').attr('data-app_url');
    $(document).on("mouseover", ".btn-envato", function (e) {
        $(this).find('img').attr('src', app_url+'/frequent_changing/images/envato-2.png');
    });
    $(document).on("mouseleave", ".btn-envato", function (e) {
        $(this).find('img').attr('src', app_url+'/frequent_changing/images/envato-1.png');
    });

});