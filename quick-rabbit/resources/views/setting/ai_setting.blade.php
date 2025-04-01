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
                        @lang('index.ai_setting')
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.ai_setting')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                {!! Form::model(isset($data) && $data?$data:'', ['method' => 'POST', 'enctype'=>'multipart/form-data','id' => 'common-form', 'url' => ['update-ai-setting']]) !!}
                @csrf
                @method('PUT')
                <div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.active') {!! starSign() !!}</label>
                                <select name="type" class="form-control select2 type ai_setting_type" id="type">
                                    <option {{ (isset($data->type) && $data->type=='Yes')? 'selected':'' }} value="Yes">@lang('index.yes')</option>
                                    <option {{ (isset($data->type) && $data->type=='No')? 'selected':'' }} value="No">@lang('index.no')</option>
                                </select>
                            </div>
                            @error('type')
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2 input_show_hide {{ $data->type=='No' ? 'd-none' : '' }}">
                            <div class="form-group mb-2">
                                <label>@lang('index.api_key') {!! starSign() !!}</label>
                                {!! Form::text('api_key', (appMode() == "demo" ? demoAi()['api_key'] : null), ['class' => 'form-control','placeholder'=>__('index.api_key')]) !!}
                            </div>
                            @if ($errors->has('api_key'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('api_key') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2 input_show_hide {{ $data->type=='No' ? 'd-none' : '' }}">
                            <div class="form-group mb-2">
                                <label>@lang('index.organization_key') {!! starSign() !!}</label>
                                {!! Form::text('organization_key', (appMode() == "demo" ? demoAi()['organization_key'] : null), ['class' => 'form-control','placeholder'=>__('index.organization_key')]) !!}
                            </div>
                            @if ($errors->has('organization_key'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('organization_key') }}
                                </span>
                            @endif
                        </div>
                        
                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100" id="submit-btn">
                                        {!! commonSpinner() !!}@lang ('index.submit')
                                    </button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('dashboard') }}">
                                @lang('index.back')
                            </a>
                        </div>
                        <small class="pull-right">@lang('index.check_documentation_setting')</small>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/ai_setting.js?var=2.2') }}"></script>
@endpush
