@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ $title ?? 'Add Category'  }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.blog_categories'), 'secondSection' => $title])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($data) && $data?$data:'', ['method' => isset($data) && $data?'PATCH':'POST', 'files'=>true,'route' => ['blog-categories.update', (isset($data->id) && $data->id)?encrypt_decrypt($data->id, 'encrypt'):''],'id' => 'common-form']) !!}
            @csrf
            <div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 cl-12">
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
                    <div class="col-lg-6 col-md-6 cl-12">
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
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100" id="submit-btn"><span class="me-2 spinner d-none"><iconify-icon icon="la:spinner" width="22"></iconify-icon></span>@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('blog-categories.index') }}">
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
