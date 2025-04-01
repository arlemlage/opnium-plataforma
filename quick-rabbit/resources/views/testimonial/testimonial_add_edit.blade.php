@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ isset($data) ? __('index.edit_testimonial') : __('index.add_testimonial') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.notice'),
                    'secondSection' => isset($obj) ? __('index.edit_testimonial') : __('index.add_testimonial'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'files' => true,
                    'route' => [
                        isset($obj) && $obj ? 'testimonial.update' : 'testimonial.store',
                        isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : '',
                    ],
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        @if (authUserRole() != 3)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-group custom_table">
                                <label>@lang('index.customer_phone') {!! starSign() !!}</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <div class="form-group">
                                                <select name="customer_id" id="append_c_option_by_ajax"
                                                    class="form-control select2 append_c_option_by_ajax">
                                                    <option value="">@lang('index.select')</option>
                                                    @foreach ($customers as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ isset($obj->user_id) && $obj->user_id == $value->id ? 'selected' : '' }}>
                                                            {{ $value->full_name }} {{ $value->email != null ? '('.$value->email.')' : null }}</option>
                                                    @endforeach
                                                </select>

                                                <div class="invalid-feedback font-14 ">
                                                    @lang('index.customer_id_required')
                                                </div>
                                            </div>

                                        </td>
                                        <td class="ds_w_99_1 d-flex">
                                            <button type="button"
                                                class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_modal_customer add_file"><iconify-icon
                                                    icon="ph:plus-fill" width="22"></iconify-icon></button>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                                @if ($errors->has('customer_id'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('customer_id') }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <input type="hidden" name="customer_id" value="{{ authUserId() }}">
                        @endif
                        <div class="col-lg-4 col-md-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.rating') {!! starSign() !!}</label>
                                {!! Form::text('rating', isset($obj) ? $obj->rating : null, ['class' => 'form-control', 'placeholder' => __('index.rating')]) !!}
                            </div>
                            @if ($errors->has('rating'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('rating') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-lg-12 col-md-12 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.review') {!! starSign() !!}</label>
                                {!! Form::textarea('review', isset($obj) ? $obj->review : null, ['class' => 'form-control', 'placeholder' => __('index.review')]) !!}
                            </div>
                            @if ($errors->has('review'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('review') }}
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">
                                {!! commonSpinner() !!}
                                @lang('index.submit')
                            </button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('testimonial.index') }}">
                                @lang('index.back')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </section>

    <!-- Add Customer Modal-->
    @if (authUserRole() != 3)
        <div class="modal fade" id="add_customer">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">{{ __('index.add_customer') }}</h4>
                        <button type="button" class="btn-close close_modal_customer" data-bs-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="box-wrapper">
                            <!-- general form elements -->
                            <div class="table-box">
                                <div>
                                    <div class="row">
                                        <div class="col-sm-12 mb-2 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.first_name') {!! starSign() !!}</label>
                                                {!! Form::text('first_name', null, [
                                                    'class' => 'form-control first_name',
                                                    'placeholder' => __('index.first_name'),
                                                ]) !!}
                                            </div>
                                            <span class="error_alert text-danger ajax_data_field_alert error_f_name"
                                                role="alert"></span>
                                        </div>

                                        <div class="col-sm-12 mb-2 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.last_name') {!! starSign() !!}</label>
                                                {!! Form::text('last_name', null, ['class' => 'form-control last_name', 'placeholder' => __('index.last_name')]) !!}
                                            </div>
                                            <span class="error_alert text-danger ajax_data_field_alert error_l_name"
                                                role="alert"></span>
                                        </div>

                                        <div class="col-sm-12 mb-2 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.email') {!! starSign() !!}</label>
                                                {!! Form::text('email', null, ['class' => 'form-control email', 'placeholder' => __('index.email')]) !!}
                                            </div>
                                            <span class="error_alert text-danger ajax_data_field_alert error_email"
                                                role="alert"></span>
                                        </div>

                                        <div class="col-sm-12 mb-2 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.mobile')</label>
                                                {!! Form::text('mobile', null, ['class' => 'form-control mobile', 'placeholder' => __('index.mobile')]) !!}
                                            </div>
                                            <span class="error_alert text-danger ajax_data_field_alert error_mobile"
                                                role="alert"></span>
                                        </div>

                                        <div class="col-sm-12 mb-2 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.status') {!! starSign() !!}</label>
                                                {!! Form::select('status', ['1' => 'Active', '2' => 'Inactive'], null, [
                                                    'class' => 'form-control select2 status',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-3 mb-2">
                                            <button type="button" id="add_new_customer"
                                                class="btn bg-blue-btn w-100 add_new_customer">
                                                <span class="me-2 ticket-add-customer-form-spinner d-none"><iconify-icon
                                                        icon="la:spinner" width="22"></iconify-icon></span>

                                                @lang('index.submit')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@push('js')
<script src="{{ asset('frequent_changing/js/testimonial.js?var=2.2') }}"></script>
@endpush
