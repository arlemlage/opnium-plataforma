(function($){
    "use strict";

    $('#add_button').on('click', function () {
        $("#custom_field").append(
          `<tr class="custom_field_row">
                    <td>
                          <select name="custom_field_type[]" class="form-control custom_field_type has-validation" required>
                            <option value="1">Text</option>
                            <option value="2">Textarea</option>
                            <option value="3">Select</option>
                        </select>
                        <div class="invalid-feedback">
                            The Field Type field is required.
                        </div>
                    </td>
                    <td>
                        <input type="text" name="custom_field_label[]" value="" class="form-control has-validation" placeholder="Field Label" required />
                        <div class="invalid-feedback">
                            The Field Label field is required.
                        </div>
                    </td>
                    <td>
                        <input type="text" name="custom_field_option[]" value="" placeholder="Option one, Option two" class="form-control custom_field_option hidden"/>
                        <div class="invalid-feedback">
                            The Option field is required.
                        </div>
                    </td>
                    <td>
                        <label class="switch_ticketly pl-5">
                            <input type="checkbox" class="custom_field_required_change" value="off" name="custom_field_required[]">
                            <span class="slider round"></span>
                            <input type="hidden" class="custom_field_required_change_val" value="off" name="custom_field_required_val[]">
                        </label>
                    </td>
                    <td class="text-center align-middle"><a href="javascript:void(0)" class="remove_btn" ><iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon></a></td>
            </tr>`
        );
    });
    $(document).on('click', '.remove_btn', function () {
        $(this).parent().parent().remove();
    });

    $(document).on('change', '.custom_field_type', function (){
        let val = $(this).val();
        if (val==3){
            let custom_field_option = $(this).parent().parent().find('.custom_field_option').val();
            if (custom_field_option != ''){
                $(this).parent().parent().find('.custom_field_option').val('');
            }
            $(this).parent().parent().find('.custom_field_option').show();
            $(this).parent().parent().find('.custom_field_option').addClass('has-validation');
            $(this).parent().parent().find('.custom_field_option').attr('required', true);
        }else {
            $(this).parent().parent().find('.custom_field_option').hide();
            $(this).parent().parent().find('.custom_field_option').removeClass('has-validation');
            $(this).parent().parent().find('.custom_field_option').attr('required', false);
        }
    });

    $(document).on('change', '.custom_field_required_change', function (){
        let val = $(this).val();
        if (val=='off'){
            $(this).parent().parent().parent().find('.custom_field_required_change_val').val('on');
            $(this).val('on')
        }else {
            $(this).parent().parent().parent().find('.custom_field_required_change_val').val('off');
            $(this).val('off')
        }
    });

    $(document).on('change', '.enable_auto_res', function (){
        if ($(this).prop('checked')==true){
            $('.enable_auto_res_text').show();
        }else {
            $('.enable_auto_res_text').hide();
        }
    });

})(jQuery);
