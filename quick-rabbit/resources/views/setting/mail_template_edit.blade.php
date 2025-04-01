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
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    {{ $mail_template_info->event ?? "" }}
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.mail_settings')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
           <form action="{{ url('mail-template-update/'.encrypt_decrypt($id, 'encrypt')) }}" id="common-form" method="POST" enctype="multipart/form-data">
           	@csrf
            @method('PUT')
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label>@lang('index.parameter')</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_ticket_subject" data-value="[ticket_subject]"> @lang('index.ticket_subject')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_ticket_no" data-value="[ticket_no]"> @lang('index.ticket_no')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_priority" data-value="[priority]"> @lang('index.priority')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_ticket_description" data-value="[ticket_description]"> @lang('index.ticket_description')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_product_name" data-value="[product_name]"> @lang('index.product_name')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_site_name" data-value="[site_name]"> @lang('index.site_name')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_agent_name" data-value="[agent_name]"> @lang('index.agent_name')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_customer_name" data-value="[customer_name]"> @lang('index.customer_name')</button>
                                <button data-bs-toggle="tooltip" data-bs-placement="top" title="Admin/Agent/Customer" type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_user_type" data-value="[user_type]"> @lang('index.user_type')</button>
                                <button data-bs-toggle="tooltip" data-bs-placement="top" title="Like: {{ currentDate(). ' at '.currentTime() }}" type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_date_time" data-value="[date_time]"> @lang('index.date_time')</button>
                                <button type="button" class="btn btn-sm btn-success-edited mb-2 parameter p_reply" data-value="[reply]"> @lang('index.reply')</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="has_customer_mail_body" value="{{ $mail_template_info->need_customer == true ? 'yes' : 'no' }}">
                    @if($mail_template_info->need_customer == true)
                         <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('index.customer_mail_subject')</label>
                                <input type="text" id="customer_mail_subject" name="customer_mail_subject" class="form-control" value="{{ $mail_template_info->customer_mail_subject }}" placeholder="@lang('index.customer_mail_subject')">
                            </div>
                            @if ($errors->has('customer_mail_subject'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('subject') }}
                                </span>
                            @endif
                        </div>
                    @endif
                    <input type="hidden" id="has_admin_agent_mail_body" value="{{ $mail_template_info->need_admin_agent == true ? 'yes' : 'no' }}">
                    @if($mail_template_info->need_admin_agent == true)
                     <div class="col-md-12 mt-1">
                        <div class="form-group">
                            <label>@lang('index.admin_agent_mail_subject')</label>
                            <input type="text" id="admin_agent_mail_subject" name="admin_agent_mail_subject" class="form-control" value="{{ $mail_template_info->admin_agent_mail_subject }}" placeholder="@lang('index.admin_agent_mail_subject')">
                        </div>
                        @if ($errors->has('admin_agent_mail_subject'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('subject') }}
                            </span>
                        @endif
                    </div>
                    @endif
                    @if($mail_template_info->need_customer == true)
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-12 mt-2">
                                <div class="form-group">
                                    <label>@lang('index.customer_mail_body') </label>
                                    <textarea id="customer_mail_body" name="customer_mail_body">{{ $mail_template_info->customer_mail_body }}</textarea>
                                </div>
                                @if ($errors->has('customer_mail_body'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('customer_mail_body') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($mail_template_info->need_admin_agent == true)
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.admin_agent_mail_body') </label>
                                <textarea id="admin_agent_mail_body" name="admin_agent_mail_body">{{ $mail_template_info->admin_agent_mail_body }}</textarea>
                            </div>
                            @if ($errors->has('admin_agent_mail_body'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('customer_mail_body') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100" id="submit-btn">
                                        {!! commonSpinner() !!}@lang ('index.update')
                                    </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ url('mail-templates') }}">
                            @lang('index.back')
                        </a>
                    </div>
                </div>
            </div>
           </form>
        </div>

    </div>
</section>
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/mail-template.js?var=2.2') }}"></script>
@endpush
