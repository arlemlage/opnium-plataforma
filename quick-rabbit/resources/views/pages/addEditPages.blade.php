@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css?var=2.2') }}">
@endpush

@section('content')
<input type="hidden" id="page-at" value="{{ Request::segment(1) }}">
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <div class="alert-wrapper d-none ajax_data_alert_show_hide">
        <div class="alert alert-{{ Session::get('type') ?? 'info' }} alert-dismissible fade show">
            <div class="alert-body">
                <p><iconify-icon icon="{{ Session::get('sign') ?? 'material-symbols:check' }}" width="22"></iconify-icon><span class="ajax_data_alert"></span></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ isset($obj)? __('index.edit_page'):__('index.add_page') }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.page'), 'secondSection' => isset($obj)? __('index.edit_page') : __('index.add_page')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => isset($obj) && $obj?'PATCH':'POST', 'files'=>true,'route' => ['pages.update', (isset($obj->id) && $obj->id)?encrypt_decrypt($obj->id, 'encrypt'):''],'id' => 'common-form']) !!}
            @csrf
            <div>
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-12 mb-3">
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
                    @php
                        $selected_tag_ids = isset($obj->tag_ids)? $obj->tag_ids:null;
                    @endphp
                    <input type="hidden" id="selected_tag_ids" value="{{ $selected_tag_ids }}">
                    <div class="col-xl-4 col-md-6 col-12 mb-3">
                        <div class="form-group custom_table">
                            <label>@lang('index.tags')</label>
                            <div class="table-responsive">
                            <table>
                                <tr>
                                    <td class="ds_w_99_p">
                                        {!! Form::select('tag_ids[]', $tag, isset($obj->tag_ids)? explode(',', $obj->tag_ids):null, ['class'=>'form-control select2 width_100_p tags', 'id'=>'tags', 'data-placeholder'=>__('index.select_tags'), 'multiple']) !!}
                                    </td>
                                    <td class="ds_w_1_p">
                                        <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_modal_tag"><iconify-icon icon="ph:plus-fill" width="22"></iconify-icon></button>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 col-12 mb-3">
                        <div class="form-group">
                            <label>@lang('index.status') {!! starSign() !!}</label>
                            {!! Form::select('status',['1'=>__('index.active'), '2'=>__('index.in_active')], isset($obj->status)? $obj->status:null, ['class'=>'form-control select2' , 'id' => 'status']) !!}
                        </div>
                        @if ($errors->has('status'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('status') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label class="mt-2 mb-0">@lang('index.page_details') {!! starSign() !!}</label>
                                <button type="button" class="btn btn-success-edited pull-right btn-xs open_media_modal"   data="iconViewer">
                                    @lang('index.insert_media')
                                </button>
                            </div>
                            <textarea name="page_content" id="page_content" class="form-control tiny">{{ old('page_content') ??  $obj->page_content ?? "" }}</textarea>
                        </div>
                        @if ($errors->has('page_content'))
                            <span class="error_alert text-danger" role="alert">
                        {{ $errors->first('page_content') }}
                    </span>
                        @endif
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" class="btn bg-blue-btn w-100" id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('pages.index') }}">
                            @lang('index.back')
                        </a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>

<!-- Add Tag Modal-->
<div class="modal fade" id="add_tag">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ __('index.add_tag') }}</h4>
                <button type="button" class="btn-close close_modal_tag" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="box-wrapper">
                    <!-- general form elements -->
                    <div class="table-box">
                        <div>
                            <div class="row">
                                <div class="col-sm-12 mb-2 col-md-12">
                                    <div class="form-group">
                                        <label class="float-left">@lang('index.title') {!! starSign() !!}</label>
                                        {!! Form::text('tag_title', null, ['class' => 'form-control', 'id'=>'tag_title', 'placeholder'=>__('index.title')]) !!}
                                    </div>
                                    <span class="error_alert text-danger ajax_data_field_alert displayNone" role="alert">
                                        {{ __('index.title_required') }}
                                    </span>
                                </div>

                                <div class="col-sm-12 mb-2 col-md-12">
                                    <div class="form-group">
                                        <label>@lang('index.description')</label>
                                        <textarea name="description" id="tiny_tag" class="form-control" placeholder="@lang('index.description')"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-2 mb-2">
                                    <button type="button" class="btn bg-blue-btn btn-md add_new_tag" id="submit-tag"><span class="me-2 tag-spinner d-none"><iconify-icon icon="la:spinner" width="22"></iconify-icon></span>@lang('index.submit')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('helper.media_modal')
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/page.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/crop/cropper.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/media_management.js?var=2.2') }}"></script>
@endpush
