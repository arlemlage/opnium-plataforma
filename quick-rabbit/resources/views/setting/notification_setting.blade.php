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
                    @lang('index.notification_setting')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.notification_setting')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => 'POST', 'enctype'=>'multipart/form-data','id' => 'common-form', 'url' => ['update-notification-setting']]) !!}
            @csrf
            @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <p class="py-2">
                            <span class="fw-bold me-4">{{ __('index.enable_notifications') }}</span>
                            <label class="switch_ticketly">
                                <input type="checkbox" name="disable_notifications" class="disable_notifications" value="1" {{ activeAllNotification() ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </p>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table text-nowrap notification_table" id="notification_table">
                                <thead>
                                <tr>
                                    <th class="ir_w_1">@lang('index.sn')</th>
                                    <th class="ir_w_12">@lang('index.event')</th>
                                    <th class="ir_w_7 text-center">@lang('index.web_push') (@lang('index.software_notification'))</th>
                                    <th class="ir_w_7 text-center">@lang('index.mail') (@lang('index.email_notification'))</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($obj as $value)
                                    <input type="hidden" name="template_ids[]" value="{{!empty($value->id)? $value->id:'' }}">
                                    <tr>
                                        <td class="">{{ $loop->index + 1 }}</td>
                                        <td>{{ $value->event ?? "" }}</td>
                                        <td>
                                            <div class="text-center">
                                                <input class="form-check-input enable web_push_n" type="checkbox" value="{{ ($value->web_push_notification == 'on') ? 'on':'off' }}" {{($value->web_push_notification=='on')? 'checked':''}}>
                                                <input type="hidden" class="form-check-input enable web_push_n_val" name="web_push_notification[]" value="{{ ($value->web_push_notification == 'on') ? 'on':'off' }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <input class="form-check-input enable mail_n" type="checkbox" value="{{ ($value->mail_notification=='on')? 'on':'off' }}" {{($value->mail_notification=='on')? 'checked':''}}>
                                                <input type="hidden" class="form-check-input enable mail_n_val" name="mail_notification[]" value="{{ ($value->mail_notification=='on')? 'on':'off' }}">
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>


                    <div class="row mt-2">
                            <div class="col-md-12 my-2 d-flex justify-content-between">
                                <span class="d-flex">
                                    <span class="fw-bold me-4">@lang('index.setting')</span>
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.notification_setting_note')">
                                        <iconify-icon icon="ri:question-fill" width="22"></iconify-icon> 
                                    </span>
                                </span>
                                
                            
                                <small class="text-bold">@lang('index.check_documentation_setting')</small>
                            </div>


                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.channel_name')</label>
                                <input type="text" name="channel_name" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['channel_name'] : pusherInfo()['channel_name'] }}" placeholder="@lang('index.channel_name')">
                            </div>
                            @error('channel_name')
                                <span class="error_alert text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.app_id')</label>
                                <input type="text" name="pusher_app_id" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_id'] : pusherInfo()['app_id'] }}" placeholder="@lang('index.app_id')">
                            </div>
                            @error('app_id')
                                <span class="error_alert text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.app_key')</label>
                                <input type="text" name="app_key" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_key'] : pusherInfo()['app_key'] }}" placeholder="@lang('index.app_key')">
                            </div>
                            @error('app_key')
                                <span class="error_alert text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.app_secret')</label>
                                <input type="text" name="app_secret" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_secret'] : pusherInfo()['app_secret'] }}" placeholder="@lang('index.app_secret')<">
                            </div>
                            @error('app_secret')
                                <span class="error_alert text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.app_cluster')</label>
                                <input type="text" name="app_cluster" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_cluster'] : pusherInfo()['app_cluster'] }}" placeholder="@lang('index.app_cluster')">
                            </div>
                            @error('app_cluster')
                                <span class="error_alert text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="row my-2">
                        <div class="col-md-12">
                            <span class="fw-bold me-4">@lang('index.enable_browser_notification')</span>
                            
                            <small class="pull-right text-bold">@lang('index.check_documentation_setting')</small>

                            <label class="switch_ticketly">
                                <input type="checkbox" name="browser_notification" class="browser_notification" value="1" {{ siteSetting()->browser_notification == "Yes" || old('browser_notification') == "1" ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row firebase-info-div {{ siteSetting()->browser_notification == "Yes" || old('browser_notification') == '1' ? '' : 'display-none' }}">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.api_key') {!! starSign() !!}</label>
                                        <input type="text" name="api_key" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['api_key'] : firebaseInfo()['api_key'] }}" placeholder="@lang('index.api_key')">
                                    </div>
                                    @error('api_key')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.auth_domain') {!! starSign() !!}</label>
                                        <input type="text" name="auth_domain" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['auth_domain'] : firebaseInfo()['auth_domain'] }}" placeholder="@lang('index.auth_domain')">
                                    </div>
                                    @error('auth_domain')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.project_id') {!! starSign() !!}</label>
                                        <input type="text" name="project_id" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['project_id'] : firebaseInfo()['project_id'] }}" placeholder="@lang('index.project_id')">
                                    </div>
                                    @error('project_id')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.database_url') {!! starSign() !!}</label>
                                        <input type="text" name="database_url" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['database_url'] : firebaseInfo()['database_url'] }}" placeholder="@lang('index.database_url')">
                                    </div>
                                    @error('database_url')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.storage_bucket') {!! starSign() !!}</label>
                                        <input type="text" name="storage_bucket" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['storage_bucket'] : firebaseInfo()['storage_bucket'] }}" placeholder="@lang('index.storage_bucket')">
                                    </div>
                                    @error('storage_bucket')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.messaging_sender_id') {!! starSign() !!}</label>
                                        <input type="text" name="messaging_sender_id" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['messaging_sender_id'] : firebaseInfo()['messaging_sender_id'] }}" placeholder="@lang('index.messaging_sender_id')">
                                    </div>
                                    @error('messaging_sender_id')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.app_id') {!! starSign() !!}</label>
                                        <input type="text" name="app_id" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['app_id'] : firebaseInfo()['app_id'] }}" placeholder="@lang('index.app_id')">
                                    </div>
                                    @error('app_id')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                    <div class="form-group">
                                        <label>@lang('index.measurement_id') {!! starSign() !!}</label>
                                        <input type="text" name="measurement_id" class="form-control" value="{{ appMode() == "demo" ? demoFirebase()['measurement_id'] : firebaseInfo()['measurement_id'] }}" placeholder="@lang('index.measurement_id')">
                                    </div>
                                    @error('measurement_id')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2 col-md-12">
                                    <div class="form-group">
                                        <label>@lang('index.server_key') {!! starSign() !!}</label>
                                        <textarea type="text" name="server_key" class="form-control h-60" placeholder="@lang('index.server_key')">{{ appMode() == "demo" ? demoFirebase()['server_key'] : firebaseInfo()['server_key'] }}</textarea>
                                    </div>
                                    @error('server_key')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-2 col-md-12">
                                    <div class="form-group">
                                        <label>@lang('index.key_pair') {!! starSign() !!}</label>
                                        <textarea type="text" name="key_pair" class="form-control h-60" placeholder="@lang('index.key_pair')">{{ appMode() == "demo" ? demoFirebase()['key_pair'] : firebaseInfo()['key_pair'] }}</textarea>
                                    </div>
                                    @error('key_pair')
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                             </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100" id="submit-btn">
                                        {!! commonSpinner() !!}@lang ('index.submit')
                                    </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div> 
</section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/notification-setting.js?var=2.2') }}"></script>
@endpush
