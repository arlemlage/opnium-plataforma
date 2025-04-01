@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ isset($obj)? __('index.edit_department'):__('index.add_department') }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.department'), 'secondSection' => isset($obj)? __('index.edit_department') : __('index.add_department')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => isset($obj) && $obj?'PATCH':'POST','route' => ['departments.update', isset($obj->id) && $obj->id?$obj->id:''],'id' => 'common-form']) !!}
            @csrf
            <div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.name') {!! starSign() !!}</label>
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>__('index.name')]) !!}
                        </div>
                        @if ($errors->has('name'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.leader') {!! starSign() !!}</label>
                            {!! Form::text('leader', null, ['class' => 'form-control','placeholder'=>__('index.leader')]) !!}
                        </div>
                        @if ($errors->has('leader'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('leader') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.description')</label>
                            {!! Form::text('description', null, ['class' => 'form-control','placeholder'=>__('index.description')]) !!}
                            @if ($errors->has('description'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100" id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('departments.index') }}">
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
