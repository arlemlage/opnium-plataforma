@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/chat-setting.css') }}">
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
                    @lang('index.chat_setting')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.chat_setting')])
        </div>
        <div class="row justify-content-start">
            <div class="col-12 justify-content-start">
                <p> @lang('index.please_click') <a href="{{ route('chat-sequence-setting') }}" class="ds_anchor color-red font-w-500"> @lang('index.here')</a>  @lang('index.chat_sequence_msg')</p>
            </div>
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($data) && $data?$data:'', ['method' => 'POST', 'enctype'=>'multipart/form-data', 'url' => ['update-chat-setting']]) !!}
            @csrf
            @method('PUT')
            <div>
                <div class="row">
                    <div>
                        <p class="py-2">
                        <span class=" me-4">{{ __('index.chat_widget_show') }}</span>
                        <label class="switch_ticketly">
                            <input type="checkbox" name="chat_widget_show" {{ (isset($data) && $data->chat_widget_show=='on')? 'checked':''}}>
                            <span class="slider round"></span>
                        </label>
                        </p>
                    </div>
                    <p class="">{{ __('index.chat_schedule') }}</p>
                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <div class="d-flex gap-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="1" value="Monday" name="chat_schedule_days[]" {{ (isset($data->chat_schedule_days) && in_array('Monday', json_decode($data->chat_schedule_days)))? 'checked':'' }}>
                                    <label class="form-check-label" for="1">@lang('index.monday')</label>
                                </div>
    
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="2" value="Tuesday" name="chat_schedule_days[]" {{ (isset($data->chat_schedule_days) && in_array('Tuesday', json_decode($data->chat_schedule_days)))? 'checked':'' }}>
                                    <label class="form-check-label" for="2">@lang('index.tuesday')</label>
                                </div>
    
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="3" value="Wednesday" name="chat_schedule_days[]" {{ (isset($data->chat_schedule_days) && in_array('Wednesday', json_decode($data->chat_schedule_days)))? 'checked':'' }}>
                                    <label class="form-check-label" for="3">@lang('index.wednesday')</label>
                                </div>
    
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="4" value="Thursday" name="chat_schedule_days[]" {{ (isset($data->chat_schedule_days) && in_array('Thursday', json_decode($data->chat_schedule_days)))? 'checked':'' }}>
                                    <label class="form-check-label" for="4">@lang('index.thursday')</label>
                                </div>
    
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="5" value="Friday" name="chat_schedule_days[]" {{ (isset($data->chat_schedule_days) && in_array('Friday', json_decode($data->chat_schedule_days)))? 'checked':'' }}>
                                    <label class="form-check-label" for="5">@lang('index.friday')</label>
                                </div>
    
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="6" value="Saturday" name="chat_schedule_days[]" {{ (isset($data->chat_schedule_days) && in_array('Saturday', json_decode($data->chat_schedule_days)))? 'checked':'' }}>
                                    <label class="form-check-label" for="6">@lang('index.saturday')</label>
                                </div>
    
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="7" value="Sunday" name="chat_schedule_days[]" {{ (isset($data->chat_schedule_days) && in_array('Sunday', json_decode($data->chat_schedule_days)))? 'checked':'' }}>
                                    <label class="form-check-label" for="7">@lang('index.sunday')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>{{ __('index.start_time') }}</label>
                                <input type="text" name="start_time" value="{{ (!empty($data->start_time)? date('H:i', strtotime($data->start_time)):'') }}" class="form-control customTimepicker" autocomplete="off" readonly="" placeholder="@lang('index.start_time')">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>{{ __('index.end_time') }}</label>
                                <input type="text" name="end_time" value="{{ !empty($data->end_time)? date('H:i', strtotime($data->end_time)):'' }}" class="form-control customTimepicker" autocomplete="off" readonly="" placeholder="@lang('index.end_time')">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <p class="py-2 mt-2">
                        <span class=" me-4">{{ __('index.auto_reply_out_of_schedule_time') }}</span>
                        <label class="switch_ticketly">
                            <input type="checkbox" id="auto_reply_out_of_schedule" name="auto_reply_out_of_schedule" {{ (isset($data) && $data->auto_reply_out_of_schedule=='on')? 'checked':''}}>
                            <span class="slider round"></span>
                        </label>
                        </p>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2 {{ isset($data) && $data->auto_reply_out_of_schedule === 'on' || old('auto_reply_out_of_schedule') === 'on' ? '' : 'displayNone' }}" id="body_div">
                        <div class="form-group">
                            <label>@lang('index.out_of_schedule_time_message') {!! starSign() !!} </label> 
                            <textarea name="out_of_schedule_time_message" id="out_of_schedule_time_message" cols="30" rows="10" class="form-control" placeholder="@lang('index.out_of_schedule_time_message')">{{ $data->out_of_schedule_time_message ?? old('out_of_schedule_time_message') ?? '' }}</textarea>
                        </div>
                        @error('out_of_schedule_time_message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p class="d-flex justify-content-between">
                            <span class="d-flex">@lang('index.setting')
                            
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.chat_setting_note')">
                                        <iconify-icon icon="ri:question-fill" width="22"></iconify-icon> 
                                </span>
                                
                            </span>
                        
                            <small class="text-bold">@lang('index.check_documentation_setting')</small>
                        </p>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.channel_name')</label>
                            <input type="text" name="channel_name" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['channel_name'] :  pusherInfo()['channel_name'] }}" placeholder="@lang('index.channel_name')">
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
                            <input type="text" name="app_id" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_id'] :  pusherInfo()['app_id'] }}" placeholder="@lang('index.app_id')">
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
                            <input type="text" name="app_key" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_key'] :  pusherInfo()['app_key'] }}" placeholder="@lang('index.app_key')">
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
                            <input type="text" name="app_secret" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_secret'] :  pusherInfo()['app_secret'] }}" placeholder="@lang('index.app_secret')<">
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
                            <input type="text" name="app_cluster" class="form-control" value="{{ appMode() == "demo" ? demoPusher()['app_cluster'] :  pusherInfo()['app_cluster'] }}" placeholder="@lang('index.app_cluster')">
                        </div>
                        @error('app_cluster')
                            <span class="error_alert text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100">@lang('index.submit')</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/chat-setting.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/timepicker_custom.js') }}"></script>
@endpush
