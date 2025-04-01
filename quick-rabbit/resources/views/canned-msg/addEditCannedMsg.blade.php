@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper d-none ajax_data_alert_show_hide">
            <div class="alert alert-{{ Session::get('type') ?? 'info' }} alert-dismissible fade show">
                <div class="alert-body">
                    <p><iconify-icon icon="{{ Session::get('sign') ?? 'material-symbols:check' }}"
                            width="22"></iconify-icon><span class="ajax_data_alert"></span></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ isset($obj) ? __('index.edit_canned_msg') : __('index.add_canned_msg') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.canned_msg'),
                    'secondSection' => isset($obj) ? __('index.edit_canned_msg') : __('index.add_canned_msg'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'files' => true,
                    'route' => ['canned-message.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.title') {!! starSign() !!}</label>
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('index.title')]) !!}
                            </div>
                            @if ($errors->has('title'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('title') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label class="d-flex justify-content-between"><span>@lang('index.canned_message_details') {!! starSign() !!}</span>
                                    <button type="button"
                                        class="btn btn-md bg-blue-btn float-right me-1 open_article_modal">
                                        @lang('index.article')</button>
                                </label>
                                <textarea name="canned_msg_content" id="canned_msg_content" class="form-control canned_msg_content" placeholder="@lang('index.canned_message_details')">{{ $obj->canned_msg_content ?? old('canned_msg_content') }}</textarea>
                            </div>
                            @if ($errors->has('canned_msg_content'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('canned_msg_content') }}
                                </span>
                            @endif
                        </div>

                    </div>


                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('canned-message.index') }}">
                                @lang('index.back')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>

    <!-- Article search Modal -->
    <div class="modal fade" id="article_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.article')</h4>
                    <button type="button" class="btn-close close_article_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="col-12 article_msg_search_box">
                    <div class="form-group">
                        {!! Form::text('article_search', null, [
                            'class' => 'form-control article_search',
                            'placeholder' => __('index.search'),
                        ]) !!}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <ul class="article_msg_ul"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/canned_message.js?var=2.2') }}"></script>
@endpush
