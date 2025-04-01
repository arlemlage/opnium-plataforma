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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ isset($obj)? __('index.edit_vacation'):__('index.add_vacation') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.vacation'), 'secondSection' => isset($obj)? __('index.edit_vacation') : __('index.add_vacation')])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => isset($obj) && $obj?'PATCH':'POST', 'files'=>true,'route' => ['vacations.update', (isset($obj->id) && $obj->id)?encrypt_decrypt($obj->id, 'encrypt'):''],'id' => 'common-form']) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.title') {!! starSign() !!}</label>
                                {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>__('index.title')]) !!}
                            </div>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.start_date') {!! starSign() !!}</label>
                                {!! Form::text('start_date',null, ['class' => 'form-control customDatepicker','placeholder'=>__('index.start_date'), 'autocomplete'=>"off",'readonly']) !!}
                            </div>
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.end_date') {!! starSign() !!}</label>
                                {!! Form::text('end_date',null, ['class' => 'form-control customDatepicker','placeholder'=>__('index.end_date'),'autocomplete'=>"off",'readonly']) !!}
                            </div>
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <input type="checkbox" name="auto_response" class="form-check-input" id="auto_response" {{ isset($obj) && $obj->auto_response == 'on' || old('auto_response') == 'on' ? 'checked' : '' }}>
                            <label for="auto_response">@lang('index.auto_response_on_vaction')</label>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2 {{ isset($obj) && $obj->auto_response == 'on' || old('auto_response') == 'on' ? '' : 'displayNone' }}" id="subject_div">
                                <div class="form-group">
                                    <label>@lang('index.mail_subject') {!! starSign() !!}</label>
                                    {!! Form::text('mail_subject', null, ['class' => 'form-control','placeholder'=>__('index.mail_subject')]) !!}
                                </div>
                                @error('mail_subject')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2 {{ isset($obj) && $obj->auto_response == 'on' || old('auto_response') == 'on' ? '' : 'displayNone' }}" id="body_div">
                                <div class="form-group">
                                    <label>@lang('index.mail_body'){!! starSign() !!}</label> 
                                    <textarea name="mail_body" id="mail_body" cols="30" rows="10" class="form-control" placeholder="@lang('index.mail_body')">{!! old('mail_body') ?? isset($obj->mail_body) ? nl2br($obj->mail_body) : '' ?? '' !!}</textarea>
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
                            <a class="btn custom_header_btn vacation_back_btn w-100" href="{{ route('vacations.index') }}">
                                @lang ('index.back')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/vacation.js?var=2.2') }}"></script>
@endpush
