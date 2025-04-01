@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ isset($data)? __('index.edit_notice'):__('index.add_notice') }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.notice'), 'secondSection' => isset($obj)? __('index.edit_notice') : __('index.add_notice')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($data) && $data?$data:'', ['method' => isset($data) && $data?'PATCH':'POST', 'files'=>true,'route' => ['notices.update', (isset($data->id) && $data->id)?encrypt_decrypt($data->id, 'encrypt'):''],'id' => 'common-form']) !!}
            @csrf
            <div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.title') {!! starSign() !!}</label>
                            {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>__('index.title')]) !!}
                        </div>
                        @if ($errors->has('title'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>
                     <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.start_date') {!! starSign() !!}</label>
                            {!! Form::text('start_date', null, ['autocomplete' => 'off','class' => 'form-control customDatepicker','placeholder'=>__('index.start_date')]) !!}
                        </div>
                        @if ($errors->has('start_date'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('start_date') }}
                            </span>
                        @endif
                    </div>
                     <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.end_date') {!! starSign() !!}</label>
                            {!! Form::text('end_date', null, ['autocomplete' => 'off','class' => 'form-control customDatepicker','placeholder'=>__('index.end_date')]) !!}
                        </div>
                        @if ($errors->has('end_date'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('end_date') }}
                            </span>
                        @endif
                    </div>
                     <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.notice') {!! starSign() !!}</label>
                            {!! Form::textarea('notice', null, ['class' => 'form-control','placeholder'=>__('index.notice')]) !!}
                        </div>
                        @if ($errors->has('notice'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('notice') }}
                            </span>
                        @endif
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100" id="submit-btn">
                            {!! commonSpinner() !!}
                            @lang('index.submit')
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('notices.index') }}">
                            @lang('index.back')
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
@endpush
