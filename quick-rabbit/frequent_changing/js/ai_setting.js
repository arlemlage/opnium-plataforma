(function ($) {
  "use strict";

  $(document).on("change", ".ai_setting_type", function () {
    let val = $(this).val();
    console.log(val);
    if (val == "Yes") {
      $(".input_show_hide").removeClass("d-none");
    } else {
      $(".input_show_hide").addClass("d-none");
    }
  });
  
})(jQuery);
