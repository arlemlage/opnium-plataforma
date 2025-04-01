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
                    @lang('index.gdpr_setting')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.gdpr_setting')])
        </div>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            {!! Form::model(isset($data) && $data?$data:'', ['method' => 'POST', 'url' => ['update-gdpr-setting'],'id' => 'gdpr-setting-form']) !!}
            @csrf
            @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <p class="py-2">
                            <span class="">@lang('index.enable_gdpr')</span>
                            <label class="switch_ticketly ml-10">
                                <input type="checkbox" name="enable_gdpr" id="enable_gdpr" {{ (isset($data) && $data->enable_gdpr=='on')? 'checked':''}}>
                                <span class="slider round"></span>
                            </label>
                        </p>

                        <div class="gdpr-setting {{ $data->enable_gdpr == 'off' ? 'displayNone' : '' }}" >
                            <p class="py-2">
                                <span class="">@lang('index.view_cookie')</span>
                                <label class="switch_ticketly ml-10">
                                    <input type="checkbox" name="view_cookie_notification_bar" {{ (isset($data) && $data->view_cookie_notification_bar=='on')? 'checked':''}}>
                                    <span class="slider round"></span>
                                </label>
                            </p>
                           <div class="form-group">
                            <label for="">@lang('index.cookie_message_title')</label>
                            <input type="text" name="cookie_message_title" class="form-control" value="{{ old('cookie_message_title') ?? $data->cookie_message_title ?? '' }}" placeholder="@lang('index.cookie_message_title')">
                            @error('cookie_message_title')
                                <span class="error_alert text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                           </div>
                            <div class="form-group mt-2">
                                <label>@lang('index.cookie_message')</label>
                                <textarea name="cookie_message" id="cookie_message" cols="30" rows="10">{!! $data->cookie_message ?? '' !!}</textarea>
                                @error('cookie_message')
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <br>
                            <p class="py-2 ">
                                <span class="">@lang('index.policy_message_on_reg_form')</span>
                                <label class="switch_ticketly ml-10">
                                    <input type="checkbox" name="policy_message_on_reg_form" {{ (isset($data) && $data->policy_message_on_reg_form=='on')? 'checked':''}}>
                                    <span class="slider round"></span>
                                </label>
                            </p>

                        </div>

                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100">@lang('index.submit')</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>

    </div>
</section>
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/gdpr-setting.js?var=2.2') }}"></script>
@endpush
