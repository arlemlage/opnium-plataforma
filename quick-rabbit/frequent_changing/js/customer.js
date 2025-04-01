(function($){
    "use strict";
    $(document).on('click', '.add_new_note', function(e) {
        $("#noteTable")
          .find("tbody")
          .append(
            `<tr class="bg-white mt-5">
            <td>
                <textarea name="note[]" class="form-control" rows="30" placeholder="Note" maxlength="1000" required></textarea>
            </td>
            <td class="align-bottom ">
                <span class="ml-5 remove_btn">
                    <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon>
                </span>
            </td>
        </tr>`
          );
    });

    $(document).on('click', '.remove_btn', function (){
        $(this).parent().parent().remove()
    });
})(jQuery);
