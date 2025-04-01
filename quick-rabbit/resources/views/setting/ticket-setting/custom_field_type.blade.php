<tr class="custom_field_row" >
    <td>
        {!! Form::select("custom_field_type[]", ['1'=>'Text', '2'=>'Textarea', '3'=>'Select',], null, ['class'=>'form-control custom_field_type']) !!}
        @error('custom_field_type')
            <div class="callout callout-danger my-2">
                <span class="error_paragraph text-danger">
                    {{ $message }}
                </span>
            </div>
        @enderror
    </td>
    <td>
        {!! Form::text("custom_field_label[]", null, ['class' => 'form-control', 'placeholder'=> __('index.custom_field_label')]) !!}
        @error('custom_field_label')
            <div class="callout callout-danger my-2">
                <span class="error_paragraph text-danger">
                    {{ $message }}
                </span>
            </div>
        @enderror
    </td>
    <td>{!! Form::text("custom_field_option[]", null, ['class' => 'form-control custom_field_option hidden']) !!}</td>
    <td>
        <label class="switch_ticketly pl-5">
            <input type="checkbox" class="custom_field_required_change" value="off" name="{{ "custom_field_required[]" }}">
            <span class="slider round"></span>
            <input type="hidden" class="custom_field_required_change_val" value="off" name="{{ "custom_field_required_val[]" }}">
        </label>
    </td>
    <td class="text-center align-middle"><a href="javascript:void(0)" class="remove_btn" ><iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon></a></td>
</tr>
