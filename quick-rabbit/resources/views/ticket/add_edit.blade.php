@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/addEditTicket.css') }}">
@endpush
@section('content')
    <input type="hidden" value="" id="active_title" class="active_title">
    <input type="hidden" value="0" id="check_spinner">
    <input type="hidden" value="0" id="is_ignore_submit_status">
    <input type="hidden" value="0" id="submit_text">
    <input type="hidden" value="{{ authUserRole() }}" id="user_type">

    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <div class="alert-wrapper d-none ajax_data_alert_show_hide">
            <div class="alert alert-success alert-dismissible fade show">
                <div class="alert-body">
                    <p><iconify-icon icon="{{ Session::get('sign') ?? 'material-symbols:check' }}"
                            width="22"></iconify-icon><span class="ajax_data_alert"></span></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header  mt-2">
                        {{ isset($obj) ? __('index.edit_ticket') : __('index.add_ticket') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.ticket'),
                    'secondSection' => isset($obj) ? __('index.edit_ticket') : __('index.add_ticket'),
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
                    'route' => ['ticket.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'id' => 'ticket-add-edit',
                    'class' => '',
                    'novalidate',
                ]) !!}

                <input type="hidden" class="isset_obj" value="{{ isset($obj) && $obj ? $obj : '' }}">

                <input type="hidden" id="auth_user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                <input type="hidden" name="is_ai_enable" id="is_ai_enable" value={{ aiInfo()['type'] == "Yes" ? true : false }}>
                <div class="row">
                    <div class="col-lg-8 col-md-6 col-12 mb-3">
                        <div class="form-group suggest_data parent_search_div">
                            <label>@lang('index.title') {!! starSign() !!}</label>
                            {!! Form::text('title', null, [
                                'class' => 'form-control required_checker ticket_title category_title_',
                                'placeholder' => __('index.title'),
                                'placeholder' => __('index.title'),
                                'required',
                                'maxlength' => 255,
                            ]) !!}
                            <ul class="results search_suggest only-search pt-2 pl_0 search_div displayNone">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 text-center">
                                        <h2 class="card-title">{{ __('index.check_search_result') }}</h2>
                                        <div class="lds-facebook loader-img">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p class="card-text display-none-not-required ai_reply_success"></p>
                                    </div>
                                </div>
                            </ul>
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
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        @if (appTheme() == 'multiple')
                            <div class="form-group">
                                <label>@lang('index.product_category') {!! starSign() !!}</label>
                                <select name="product_category_id" id="product_category_id"
                                    class="form-control select2 product_category_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($product_category as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product_category_id') == $product->id ? 'selected' : '' }}
                                            data-verification="{{ $product->verification ?? 0 }}"
                                            data-custom-field="{{ $product->has_custom_field }}">{{ $product->title }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    @lang('index.product_category_required')
                                </div>
                            </div>
                            @if ($errors->has('product_category_id'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('product_category_id') }}
                                </span>
                            @endif
                        @else
                            <input type="hidden" name="product_category_id" id="product_category_id"
                                value="{{ $product_category[0]->id }}">
                            <div class="form-group">
                                <label>@lang('index.department') {!! starSign() !!}</label>
                                <select name="department_id" id="department_id" class="form-control select2 department_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}
                                            data-verification="{{ $product_category[0]->verification ?? 0 }}"
                                            data-custom-field="{{ $product_category[0]->has_custom_field }}">
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    @lang('index.product_category_required')
                                </div>
                            </div>
                            @if ($errors->has('department_id'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('department_id') }}
                                </span>
                            @endif
                        @endif

                    </div>

                    <span id="custom-field"></span>
                    <!--hidden related field for product_category-->
                    <div
                        class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3 envato_verify_field {{ !empty($product_verification_info) && $product_verification_info->verification == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <label>@lang('index.envato_u_name') {!! starSign() !!}</label>
                            {!! Form::text('envato_u_name', null, [
                                'class' => 'form-control required_checker envato_u_name',
                                'id' => 'envato_u_name',
                                'placeholder' => __('index.envato_u_name'),
                                !empty($product_verification_info) && $product_verification_info->verification == 1 ? '' : '',
                            ]) !!}
                            <div class="invalid-feedback">
                                @lang('index.envato_u_name_required')
                            </div>
                        </div>
                        @if ($errors->has('envato_u_name'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('envato_u_name') }}
                            </span>
                        @endif
                    </div>
                    <div
                        class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3 envato_verify_field {{ !empty($product_verification_info) && $product_verification_info->verification == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <label>@lang('index.envato_p_code') {!! starSign() !!}</label>
                            {!! Form::text('envato_p_code', null, [
                                'class' => 'form-control required_checker envato_p_code',
                                'id' => 'envato_p_code',
                                'placeholder' => __('index.envato_p_code'),
                                !empty($product_verification_info) && $product_verification_info->verification == 1 ? '' : '',
                            ]) !!}
                            <div class="invalid-feedback">
                                @lang('index.envato_p_code_required')
                            </div>
                        </div>
                        @if ($errors->has('envato_p_code'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('envato_p_code') }}
                            </span>
                        @endif
                    </div>
                    <!--end hidden related field for product_category-->
                    @if (authUserRole() != 3)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
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
                    @else
                        <input type="hidden" name="customer_id" value="{{ authUserId() }}">
                    @endif
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <label>@lang('index.priority') {!! starSign() !!}</label>
                            {!! Form::select(
                                'priority',
                                ['1' => __('index.high'), '2' => __('index.medium'), '3' => __('index.low')],
                                isset($obj->priority) ? $obj->priority : null,
                                ['class' => 'form-control select2', 'id' => 'priority'],
                            ) !!}
                        </div>
                        @if ($errors->has('priority'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('priority') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>@lang('index.ticket_details') {!! starSign() !!}</label>
                            <textarea id="ticket_content" name="ticket_content" required>{{ isset($obj->ticket_content) ? $obj->ticket_content : old('ticket_content') }}</textarea>
                            <div class="invalid-feedback content-invalid">
                                @lang('index.content_field_required')
                            </div>
                        </div>
                        @if ($errors->has('ticket_content'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('ticket_content') }}
                            </span>
                        @endif
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 mt-2">
                        <label>@lang('index.attachment')</label>
                        <div class="table-responsive">
                            <span class="alert alert-warning word-break">
                                @lang('index.attachment_instruction')
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table displayNone w-100 attachment_table" id="doc_table">
                                <thead>
                                    <tr>
                                        <th class="text-left">@lang('index.file_title') {!! starSign() !!}</th>
                                        <th>@lang('index.file') {!! starSign() !!}</th>
                                        <th>@lang('index.action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="row my-2">
                            <div class="form-group">
                                <button type="button" id="ds_add_file" class="btn bg-blue-btn attachment_btn">                                    
                                    @lang('index.attachment')
                                    @include('common_view.attachment')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-11">
                    <div class="col-sm-12 col-md-3 mb-3">
                        <button type="submit" name="submit" class="btn bg-blue-btn w-100" id="submit-ticket">
                            <span class="me-2 ticket-add-edit-spin d-none"><iconify-icon icon="la:spinner"
                                    width="18"></iconify-icon></span>
                            @lang('index.submit')
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <a class="btn custom_header_btn w-100" href="{{ route('ticket.index') }}">
                            @lang('index.back')
                        </a>
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
                                        <div class="col-sm-12 mb-3 col-md-6">
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

                                        <div class="col-sm-12 mb-3 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.last_name') {!! starSign() !!}</label>
                                                {!! Form::text('last_name', null, ['class' => 'form-control last_name', 'placeholder' => __('index.last_name')]) !!}
                                            </div>
                                            <span class="error_alert text-danger ajax_data_field_alert error_l_name"
                                                role="alert"></span>
                                        </div>

                                        <div class="col-sm-12 mb-3 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.email') {!! starSign() !!}</label>
                                                {!! Form::text('email', null, ['class' => 'form-control email', 'placeholder' => __('index.email')]) !!}
                                            </div>
                                            <span class="error_alert text-danger ajax_data_field_alert error_email"
                                                role="alert"></span>
                                        </div>

                                        <div class="col-sm-12 mb-3 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.mobile')</label>
                                                {!! Form::text('mobile', null, ['class' => 'form-control mobile', 'placeholder' => __('index.mobile')]) !!}
                                            </div>
                                            <span class="error_alert text-danger ajax_data_field_alert error_mobile"
                                                role="alert"></span>
                                        </div>

                                        <div class="col-sm-12 mb-3 col-md-6">
                                            <div class="form-group">
                                                <label>@lang('index.status') {!! starSign() !!}</label>
                                                {!! Form::select('status', ['1' => 'Active', '2' => 'Inactive'], null, [
                                                    'class' => 'form-control select2 status',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-3 mb-3">
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
    <script src="{{ asset('assets/ck-editor/ckeditor.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/ticket_add_edit.js') }}"></script>
@endpush
