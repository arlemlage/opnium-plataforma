<div class="row">
@foreach($custom_field_label as $key=>$label)
    @if($custom_field_type[$key] == 1)
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
            <div class="form-group">
                <label>{{ $label }} {!! (isset($custom_field_required[$key]) && $custom_field_required[$key]=='on')? starSign():'' !!}</label>
                {!! Form::text('custom_field_data[]', !empty($custom_field_data)?$custom_field_data[$key]:null, ['class' => 'form-control '.(($custom_field_required[$key]=='on')? 'has-validation custom_field_required':''),'placeholder'=>$label , (($custom_field_required[$key]=='on')? 'required':'')]) !!}
                <div class="invalid-feedback">
                    @lang('index.the') {{$label}} @lang('index.field') @lang('index.is') @lang('index.required').
                </div>
            </div>
        </div>
    @elseif($custom_field_type[$key] == 2)
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
            <div class="form-group">
                <label>{{ $label }} {!! (isset($custom_field_required[$key]) && $custom_field_required[$key]=='on')? starSign():'' !!}</label>
                {!! Form::textarea('custom_field_data[]', !empty($custom_field_data)?$custom_field_data[$key]:null, ['class' => 'form-control '.(($custom_field_required[$key]=='on')? 'has-validation custom_field_required':''),'placeholder'=>$label , (($custom_field_required[$key]=='on')? 'required':'')]) !!}
                <div class="invalid-feedback">
                    @lang('index.the') {{$label}} @lang('index.field') @lang('index.is') @lang('index.required').
                </div>
            </div>
        </div>
    @elseif($custom_field_type[$key] == 3)
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
            <div class="form-group">
                <label>{{ $label }} {!! (isset($custom_field_required[$key]) && $custom_field_required[$key]=='on')? starSign():'' !!}</label>
                {!! Form::select('custom_field_data[]', explode(',', $custom_field_option[$key]), !empty($custom_field_data)?$custom_field_data[$key]:null, ['class'=>'form-control select2 '.(($custom_field_required[$key]=='on')? 'has-validation custom_field_required':''),'placeholder'=>__('index.select') , (($custom_field_required[$key]=='on')? 'required':'')]) !!}
                <div class="invalid-feedback">
                    @lang('index.the') {{$label}} @lang('index.field') @lang('index.is') @lang('index.required').
                </div>
            </div>
        </div>
    @endif
@endforeach
</div>
