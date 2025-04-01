@extends('layouts.app')
@push('css')
@endpush
@section('content')
    <input type="hidden" value="" id="active_title" class="active_title">

    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ $title ?? __('index.recurring_payment') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.recurring_payment'),
                    'secondSection' => $title ?? __('index.recurring_payment'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($data) && $data ? $data : '', [
                    'method' => isset($data) && $data ? 'PATCH' : 'POST',
                    'files' => true,
                    'route' => [
                        'recurring-payments.update',
                        isset($data->id) && $data->id ? encrypt_decrypt($data->id, 'encrypt') : '',
                    ],
                    'id' => 'common-form',
                    'class' => 'needs-validation',
                    'novalidate',
                ]) !!}
                <input type="hidden" class="isset_obj" value="{{ isset($data) && $data ? $data : '' }}">
                <input type="hidden" id="auth_user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="form-group suggest_data">
                            <label>@lang('index.title') {!! starSign() !!}</label>
                            {!! Form::text('title', null, [
                                'class' => 'form-control category_title_',
                                'placeholder' => __('index.title'),
                                'required',
                            ]) !!}
                            <ul class="results search_suggest pt-2 pl_0 displayNone"></ul>
                            <div class="invalid-feedback">
                                @lang('index.title_field_required')
                            </div>
                        </div>
                        @if ($errors->has('title'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="form-group suggest_data">
                            <label>@lang('index.start_date') {!! starSign() !!}</label>
                            {!! Form::text('start_date', null, [
                                'class' => 'form-control customDatepicker',
                                'placeholder' => __('index.start_date'),
                                'autocomplete' => 'off',
                                'readonly',
                                'required',
                            ]) !!}
                            <ul class="results search_suggest pt-2 pl_0 displayNone"></ul>
                            <div class="invalid-feedback">
                                @lang('index.start_date_field_required')
                            </div>
                        </div>
                        @if ($errors->has('start_date'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('start_date') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="form-group suggest_data">
                            <label>@lang('index.end_date') {!! starSign() !!}</label>
                            {!! Form::text('end_date', null, [
                                'class' => 'form-control customDatepicker',
                                'placeholder' => __('index.end_date'),
                                'required',
                                'autocomplete' => 'off',
                                'readonly',
                            ]) !!}
                            <ul class="results search_suggest pt-2 pl_0 displayNone"></ul>
                            <div class="invalid-feedback">
                                @lang('index.end_date_field_required')
                            </div>
                        </div>
                        @if ($errors->has('end_date'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('end_date') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
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
                                                        {{ isset($obj->customer_id) && $obj->customer_id == $key ? 'selected' : '' }}>
                                                        {{ $value->full_name }}
                                                        {{ $value->email != null ? '(' . $value->email . ')' : null }}
                                                    </option>
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

                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="form-group">
                            <label>@lang('index.product_category') </label>
                            {!! Form::select(
                                'product_cat_ids[]',
                                $product_category,
                                isset($data->product_cat_ids) ? explode(',', $data->product_cat_ids) : null,
                                ['class' => 'form-control select2', 'id' => 'product_cat_ids', 'data-placeholder' => __('index.select_product_category'), 'multiple'],
                            ) !!}
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="form-group suggest_data">
                            <label>@lang('index.amount') {!! starSign() !!}</label>
                            {!! Form::number('amount', null, ['class' => 'form-control', 'placeholder' => __('index.amount'), 'required']) !!}
                            <ul class="results search_suggest pt-2 pl_0 displayNone"></ul>
                            <div class="invalid-feedback">
                                @lang('index.amount_field_required')
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="form-group suggest_data">
                            <label>@lang('index.payment_period_in_days') {!! starSign() !!}</label>
                            {!! Form::number('payment_period_in_days', null, [
                                'class' => 'form-control',
                                'placeholder' => __('index.payment_period_in_days'),
                                'required',
                            ]) !!}
                            <ul class="results search_suggest pt-2 pl_0 displayNone"></ul>
                            <div class="invalid-feedback">
                                @lang('index.payment_period_in_days_field_required')
                            </div>
                            @if ($errors->has('payment_period_in_days'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('payment_period_in_days') }}
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label>@lang('index.description')</label>
                            <textarea id="description" name="description" class="form-control has-validation" placeholder="@lang('index.description')">{{ isset($data->description) ? $data->description : old('description') }}</textarea>
                            <div class="invalid-feedback">
                                @lang('index.description_field_required')
                            </div>
                        </div>
                        @if ($errors->has('description'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" class="btn bg-blue-btn w-100" id="submit-btn">
                            {!! commonSpinner() !!}
                            @lang('index.submit')
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('recurring-payments.index') }}">
                            @lang('index.back')
                        </a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </section>

    <!-- Add Customer Modal-->
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
                                            <label>@lang('index.status') {!! starSign() !!}</label>
                                            {!! Form::select('status', ['1' => 'Active', '2' => 'Inactive'], null, [
                                                'class' => 'form-control select2 status',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-3 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 add_new_customer"
                                            id="submit-customer">
                                            <span class="me-2 customer-spinner d-none"><iconify-icon icon="la:spinner"
                                                    width="18"></iconify-icon></span>

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
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/recurring_payment.js?var=2.2') }}"></script>
@endpush
