@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <div class="alert-wrapper">
        @if(appMode() == "demo")
        <div class="alert alert-warning alert-dismissible fade show">
            <div class="alert-body">
                <p><iconify-icon icon="bi:exclamation-triangle-fill" width="22"></iconify-icon>{{ __('index.demo_restriction_msg') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        {{ alertMessage() }}
    </div>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    @lang('index.mail_settings')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.mail_settings')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
           <form action="{{ url('update-mail-setting') }}" method="POST" enctype="multipart/form-data" id="common-form">
           	@csrf
            @method('PUT')
            <div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.type') {!! starSign() !!}</label>
                            <select name="mail_driver" class="form-control select2 mail_driver" id="mail_driver">
                                <option {{ ($mail_setting_info['mail_driver']=='smtp')? 'selected':'' }} value="smtp">@lang('index.SMTP')</option>
                                <option {{ ($mail_setting_info['mail_driver']!='smtp')? 'selected':'' }} value="null">@lang('index.SMTP')</option>
                            </select>
                        </div>
                        @error('mail_driver')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.host_address') {!! starSign() !!}</label>
                            <input type="text" name="mail_host" class="form-control" value="{{ $mail_setting_info['mail_host'] ?? '' }}" placeholder="@lang('index.host_address')">
                        </div>
                        @error('mail_host')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.port_address') {!! starSign() !!}</label>
                            <input type="number" name="mail_port" placeholder="@lang('index.port_address')" class="form-control" value="{{ $mail_setting_info['mail_port'] ?? '' }}">
                        </div>
                        @error('mail_port')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.encryption') {!! starSign() !!}</label>
                            <input type="text" name="mail_encryption" placeholder="@lang('index.encryption')" class="form-control" value="{{ $mail_setting_info['mail_encryption'] ?? '' }}">
                        </div>
                        @error('mail_encryption')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.username') {!! starSign() !!}</label>
                            <input type="email" name="mail_username" class="form-control" placeholder="@lang('index.username')" value="{{ $mail_setting_info['mail_username'] ?? '' }}">
                        </div>
                        @error('mail_username')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.password') {!! starSign() !!}</label>
                            <input type="text" name="mail_password" class="form-control" placeholder="@lang('index.password')" value="{{ $mail_setting_info['mail_password'] ?? '' }}">
                        </div>
                        @error('mail_password')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>
                    

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group custom_table">
                            <label>
                                @lang('index.from') {!! starSign() !!}
                            </label>
                            <table class="">
                                <tr>
                                    <td>
                                        <input type="email" name="mail_from" class="form-control" placeholder="@lang('index.from')" value="{{ $mail_setting_info['mail_from'] ?? '' }}">
                                    </td>
                                    <td class="w_1">
                                        <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-1 open_modal_mail_from">
                                            <iconify-icon icon="material-symbols:info" width="22"></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                            </table>


                        </div>
                        @error('mail_from')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group custom_table">
                            <label>@lang('index.mail_fromname') {!! starSign() !!}</label>
                            <table class="">
                                <tr>
                                    <td>
                                        <input type="text" name="mail_fromname" class="form-control" placeholder="@lang('index.mail_fromname')" value="{{ $mail_setting_info['from_name'] ?? '' }}">
                                    </td>
                                    <td class="w_1">
                                        <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-1 open_modal_from_name">
                                            <iconify-icon icon="material-symbols:info" width="22"></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        @error('mail_fromname')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label>@lang('index.api_key') {!! starSign() !!}</label>
                            <input type="text" name="api_key" class="form-control" placeholder="@lang('index.api_key')" value="{{ $mail_setting_info['api_key'] ?? ''}}">
                        </div>
                        @error('api_key')
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100" id="submit-btn">
                                        {!! commonSpinner() !!}@lang('index.update')
                                    </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('dashboard') }}">
                            @lang('index.back')
                        </a>
                    </div>
                </div>
            </div>
           </form>
        </div>
    </div>
    <div class="modal fade" id="mail_from">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('index.from')</h4>
                    <button type="button" class="btn-close close_modal_mail_from" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('assets/images/mail_from.png') }}" alt="" class="w-100">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="from_name">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('index.from')</h4>
                    <button type="button" class="btn-close close_modal_from_name" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('assets/images/from_name.png') }}" alt="" class="w-100">
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@push('js')
<script src="{{ asset('frequent_changing/js/mail_setting.js?var=2.2') }}"></script>
@endpush
