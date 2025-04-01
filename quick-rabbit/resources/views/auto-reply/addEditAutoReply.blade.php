@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ isset($obj) ? __('index.edit_auto_reply') : __('index.add_auto_reply') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.auto_replay'),
                    'secondSection' => isset($obj) ? __('index.edit_auto_reply') : __('index.add_auto_reply'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['ai_replies.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'class' => 'needs-validation',
                    'novalidate',
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.question') {!! starSign() !!}</label>
                                {!! Form::text('question', null, [
                                    'class' => 'form-control',
                                    'id' => 'question',
                                    'placeholder' => __('index.question'),
                                    'required',
                                ]) !!}
                            </div>
                            @if ($errors->has('question'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('question') }}
                                </span>
                            @endif
                        </div>
                        @if (appTheme() == 'multiple')
                            <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>@lang('index.product_category') {!! starSign() !!}</label>
                                    {!! Form::select('category_id', $product_category, isset($obj->category_id) ? $obj->category_id : null, [
                                        'class' => 'form-control select2',
                                        'id' => 'category_id',
                                        'placeholder' => __('index.select'),
                                    ]) !!}
                                </div>
                                @if ($errors->has('category_id'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('category_id') }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>@lang('index.department') {!! starSign() !!}</label>
                                    {!! Form::select('department_id', $department, isset($obj->department_id) ? $obj->department_id : null, [
                                        'class' => 'form-control select2',
                                        'id' => 'department_id',
                                        'placeholder' => __('index.select'),
                                    ]) !!}
                                </div>
                                @if ($errors->has('department_id'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('department_id') }}
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" name="category_id"
                                value="{{ array_key_first($product_category->toArray()) }}">
                        @endif


                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label>@lang('index.answer')</label>
                                <textarea id="answer" name="answer" class="has-validation">{{ old('answer') ?? ($obj->answer ?? '') }}</textarea>
                            </div>
                            @if ($errors->has('answer'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('answer') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('ai_replies.index') }}">
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
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/auto_reply_add_edit.js?var=2.2') }}"></script>
@endpush
