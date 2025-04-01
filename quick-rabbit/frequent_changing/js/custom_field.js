(function($){
    "use strict";

    $('#add_button').on('click', function () {
        let field_type_required = $('#custom_field_type_required').val();
        let label_field_required = $('#label_field_required').val();
        let option_required = $('#option_required').val();
        $("#custom_field").append(
          `<tr class="custom_field_row">
                    <td>
                          <select name="custom_field_type[]" class="form-control custom_field_type has-validation" required>
                            <option value="1">Text</option>
                            <option value="2">Textarea</option>
                            <option value="3">Select</option>
                        </select>
                        <div class="invalid-feedback">
                            ${field_type_required}
                        </div>
                    </td>
                    <td>
                        <input type="text" name="custom_field_label[]" value="" class="form-control has-validation" placeholder="Field Label" required />
                        <div class="invalid-feedback">
                            ${label_field_required}
                        </div>
                    </td>
                    <td>
                        <input type="text" name="custom_field_option[]" value="" placeholder="Option one, Option two" class="form-control custom_field_option hidden"/>
                        <div class="invalid-feedback">
                            ${option_required}
                        </div>
                    </td>
                    <td>
                        <label class="switch_ticketly pl-5 mt-2">
                            <input type="checkbox" class="custom_field_required_change" value="off" name="custom_field_required[]">
                            <span class="slider round"></span>
                            <input type="hidden" class="custom_field_required_change_val" value="off" name="custom_field_required_val[]">
                        </label>
                    </td>
                    <td class="text-center align-middle"><a href="javascript:void(0)" class="remove_btn" ><iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon></a></td>
            </tr>`
        );
    });

    $(document).ready(function() {
        setCustomFieldRequired();
    });

    $(document).on('change','.custom_field_required_change',function() {
        setCustomFieldRequired();
    });

    function setCustomFieldRequired() {
        $('.custom_field_required_change').each(function(index) {
            let checkbox = $(this);
            let data_key = checkbox.attr('data-key');
            let data_val = '';
            if( checkbox.is(':checked')) {
                data_val = 'on';
                checkbox.attr('value','on');
            } else {
                data_val = 'off';
                checkbox.attr('value','off');
            }
            $('#required_val_'+data_key).val(data_val);
        });
        
    }

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
    
    $(document).on('click', '.remove_btn', function () {
        $(this).parent().parent().remove();
    });

    $(document).on('submit','#custom-field-add-edit',function() {
        showSpin('spinner','field-submit');
        let product_id = $('#product_category_id').val();
        if(! product_id) {
            let op1 = $('#product_category_id').data("select2");
            op1.open();
            hideSpin('spinner','field-submit');
            return false;
        } else {
            if(!$(".custom_field_row").length){
                hideSpin('spinner','field-submit');
                let please_add_at_least_1_field = $("#please_add_at_least_1_field").val();
                Swal.fire({
                    icon: 'warning',
                    title: please_add_at_least_1_field,
                    confirmButtonColor: '#36405E',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok',
                });
                return false;
            }else{
                return true;
            }
        }
        
        
    });
   

})(jQuery);
