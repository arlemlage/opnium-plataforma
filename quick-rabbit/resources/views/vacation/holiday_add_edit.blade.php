@extends('layouts.app')
@section('title','Edit Profile')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/vacation.css?var=2.2') }}">
@endpush

@section('content')
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ $title ?? __('index.day') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.holidays'), 'secondSection' => $title])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                <form action="{{ $route }}" method="POST" id="common-form">
                    @isset($data)
                        @method('PUT')
                    @endisset
                    @csrf
                <div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.day') {!! starSign() !!}</label>
                                <select name="day" id="day" class="form-control select2" >
                                    <option value="">@lang('index.select_day')</option>
                                    @foreach($days as $day)
                                        <option value="{{ $day }}" {{ isset($data) && $data->day == $day || old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('day')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.start_time') {!! starSign() !!}</label>
                                <input type="text" name="start_time" id="start_time" class="form-control customTimepicker" value="{{ $data->start_time ?? old('start_time') ?? "" }}" placeholder="@lang('index.end_time')" autocomplete="off">
                            </div>
                            @error('start_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.end_time') {!! starSign() !!}</label>
                                <input type="text" name="end_time" id="end_time" class="form-control customTimepicker" value="{{ $data->end_time ?? old('end_time') ?? "" }}" placeholder="@lang('index.end_time')" autocomplete="off">
                            </div>
                            @error('end_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <input type="checkbox" class="form-check-input" name="auto_response" id="auto_response" {{ isset($data) && $data->auto_response == 'on' || old('auto_response') == 'on' ? 'checked' : '' }}>
                            <label for="auto_response">@lang('index.holiday_auto_response')</label>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2 {{ isset($data) && $data->auto_response == 'on' || old('auto_response') == 'on' ? '' : 'displayNone' }}" id="subject_div">
                                <div class="form-group">
                                    <label>@lang('index.mail_subject') {!! starSign() !!}</label>
                                    <input type="text" class="form-control" placeholder="@lang('index.mail_subject')" name="mail_subject" value="{{ $data->mail_subject ?? old('mail_subject') ?? '' }}">
                                </div>
                                @error('mail_subject')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2 {{ isset($data) && $data->auto_response == 'on' || old('auto_response') == 'on' ? '' : 'displayNone' }}" id="body_div">
                                <div class="form-group">
                                    <label>@lang('index.mail_body'){!! starSign() !!}</label> 
                                    <textarea name="mail_body" id="mail_body" cols="30" rows="10" class="form-control" placeholder="@lang('index.mail_body')">{!! old('mail_body') ?? isset($data->mail_body) ? nl2br($data->mail_body) : '' ?? '' !!}</textarea>
                                </div>
                                @error('mail_body')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100" id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn bg-blue-btn w-100" href="{{ url('holiday-setting') }}">
                                @lang ('index.back')
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
    <script src="{{ asset('frequent_changing/js/holiday_setting.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/timepicker_custom.js?var=2.2') }}"></script>
@endpush
