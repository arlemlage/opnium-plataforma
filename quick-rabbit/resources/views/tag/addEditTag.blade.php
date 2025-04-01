@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ isset($obj)? __('index.edit_tag'):__('index.add_tag') }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.tag'), 'secondSection' => isset($obj)? __('index.edit_tag') : __('index.add_tag')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => isset($obj) && $obj?'PATCH':'POST', 'files'=>true,'route' => ['tag.update', (isset($obj->id) && $obj->id)?encrypt_decrypt($obj->id, 'encrypt'):''],'id' => 'common-form']) !!}
            @csrf
            <div>
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-2">
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
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.description')</label>
                            {!! Form::text('description', null, ['class' => 'form-control','placeholder'=>__('index.description')]) !!}
                        </div>
                        @if ($errors->has('description'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100" id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('tag.index') }}">
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
