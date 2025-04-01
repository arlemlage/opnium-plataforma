@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ $title ?? __('index.custom_field') }}
                    </h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.ticket'),
                    'secondSection' => $title,
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'route' => ['custom-fields.update', isset($obj->id) && $obj->id ? $obj->id : ''],
                    'id' => 'custom-field-add-edit',
                    'class' => 'needs-validation',
                    'novalidate',
                ]) !!}
                @csrf
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        @if (appTheme() == 'multiple')
                            <div class="form-group">
                                <label for="">@lang('index.product_category'){!! starSign() !!}</label> 
                                <select name="product_category_id" id="product_category_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($product_categories as $product_category)
                                        <option value="{{ $product_category->id }}"
                                            {{ isset($obj) && $obj->product_category_id == $product_category->id ? 'selected' : '' }}>
                                            {{ $product_category->title ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="">@lang('index.department'){!! starSign() !!}</label> 
                                <select name="department_id" id="department_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ isset($obj) && $obj->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="product_category_id"
                                value="{{ $product_category->id }}">
                        @endif

                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label for="">@lang('index.status') {!! starSign() !!}</label>
                            <select name="status" id="status" class="form-control select2" required>
                                <option value="Active" {{ isset($obj) && $obj->status == 'Active' ? 'selected' : '' }}>
                                    @lang('index.active')
                                </option>
                                <option value="Inactive" {{ isset($obj) && $obj->status == 'Inactive' ? 'selected' : '' }}>
                                    @lang('index.in_active')
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-left">{{ __('index.custom_field_type') }}
                                        {!! starSign() !!}</th>
                                    <th scope="col">{{ __('index.custom_field_label') }} {!! starSign() !!}</th>
                                    <th class="d-flex" scope="col">
                                        <span class="me-1">{{ __('index.custom_field_option') }}</span>
                                        <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('index.custom_field_option_tooltip') }}">
                                            <iconify-icon icon="ri:question-fill" width="22"></iconify-icon>
                                        </span>

                                    </th>
                                    <th scope="col">{{ __('index.custom_field_required') }}</th>
                                    <th scope="col" class="text-center">{{ __('index.action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="custom_field">
                                @if (!empty($obj->custom_field_type))
                                    <?php
                                    $custom_field_type = isset($obj->custom_field_type) ? json_decode($obj->custom_field_type) : null;
                                    $custom_field_label = isset($obj->custom_field_label) ? json_decode($obj->custom_field_label) : null;
                                    $custom_field_option = isset($obj->custom_field_option) ? json_decode($obj->custom_field_option) : null;
                                    $custom_field_required = isset($obj->custom_field_required) ? json_decode($obj->custom_field_required) : null;
                                    ?>
                                    @if (count($custom_field_type))
                                        @foreach ($custom_field_type as $key => $val)
                                            <tr class="custom_field_row">
                                                <td>
                                                    {!! Form::select(
                                                        'custom_field_type[]',
                                                        ['1' => 'Text', '2' => 'Textarea', '3' => 'Select'],
                                                        !empty($val) ? $val : null,
                                                        ['class' => 'form-control custom_field_type has-validation', 'required'],
                                                    ) !!}
                                                    <div class="invalid-feedback">
                                                        @lang('index.custom_field_type_required')
                                                    </div>
                                                </td>
                                                <td>
                                                    {!! Form::text('custom_field_label[]', isset($custom_field_label[$key]) ? $custom_field_label[$key] : null, [
                                                        'class' => 'form-control has-validation',
                                                        'placeholder' => __('index.custom_field_label'),
                                                        'required',
                                                    ]) !!}
                                                    <div class="invalid-feedback">
                                                        @lang('index.label_field_required')
                                                    </div>
                                                </td>
                                                <td>
                                                    {!! Form::text('custom_field_option[]', isset($custom_field_option[$key]) ? $custom_field_option[$key] : null, [
                                                        'class' => 'form-control custom_field_option ' . ($val == 3 ? '' : 'hidden'),
                                                    ]) !!}
                                                    <div class="invalid-feedback">
                                                        @lang('index.option_required')
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="switch_ticketly pl-5 mt-2">
                                                        <input type="checkbox" data-key={{ $key }}
                                                            class="custom_field_required_change"
                                                            name="custom_field_required[]"
                                                            {{ isset($custom_field_required[$key]) && $custom_field_required[$key] == 'on' ? 'checked' : '' }}>
                                                        <span class="slider round"></span>

                                                        <input type="hidden" id="required_val_{{ $key }}"
                                                            class="custom_field_required_change_val" value=""
                                                            name="custom_field_required_val[]">
                                                    </label>
                                                </td>
                                                <td class="text-center align-middle"><a href="javascript:void(0)"
                                                        class="remove_btn"><iconify-icon
                                                            icon="solar:trash-bin-minimalistic-bold-duotone"
                                                            width="22"></iconify-icon></a></td>
                                            </tr>
                                        @endforeach
                                    @endif

                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="bd-highlight mt-2">
                        <button type="button" id="add_button"
                            class="btn bg-blue-btn pull-left mb-2 attachment_btn"><iconify-icon icon="ph:plus-fill"
                                width="18"></iconify-icon>@lang('index.add_more')</button>
                    </div>
                </div>

                <div class="row mt-11">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                            id="field-submit">{!! commonSpinner() !!}@lang('index.submit')</button>

                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a href="{{ route('custom-fields.index') }}"
                            class="btn custom_header_btn w-100">@lang('index.back')</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/custom_field.js?var=2.2') }}"></script>
@endpush
