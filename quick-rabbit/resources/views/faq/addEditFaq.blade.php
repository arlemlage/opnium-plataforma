@extends('layouts.app')
@push('css')
@endpush

@section('content')
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
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ isset($obj) && $obj? __('index.edit_faq'):__('index.add_faq') }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.faq'), 'secondSection' => isset($obj)? __('index.edit_faq') : __('index.add_faq')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => isset($obj) && $obj?'PATCH':'POST', 'files'=>true,'route' => ['faq.update', (isset($obj->id) && $obj->id)?encrypt_decrypt($obj->id, 'encrypt'):''],'id' => 'common-form']) !!}
            @csrf
            <div>
                <div class="row">

                    <div class="col-sm-12 mb-2 col-md-8">
                        <div class="form-group">
                            <label>@lang('index.question') {!! starSign() !!}</label>
                            {!! Form::text('question', old('question')??null, ['class' => 'form-control','placeholder'=>__('index.question')]) !!}
                        </div>
                        @if ($errors->has('question'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('question') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.product_category')</label>
                            {!! Form::select('product_category_id', $product_category, isset($obj->product_category_id)? $obj->product_category_id:null, ['class'=>'form-control select2','placeholder'=>__('index.select')]) !!}
                        </div>
                    </div>
                    <?php
                    $selected_tag_ids = isset($obj->tag_ids)? $obj->tag_ids:null;
                    ?>
                    <input type="hidden" id="selected_tag_ids" value="{{ $selected_tag_ids }}">

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group custom_table">
                            <label>@lang('index.tag')</label>
                            <div class="table-responsive">
                            <table>
                                <tr>
                                    <td>
                                        {!! Form::select('tag_ids[]', $tag, isset($obj->tag_ids)? explode(',', $obj->tag_ids):null, ['class'=>'form-control select2 width_100_p tags', 'id'=>'tags','data-placeholder'=>__('index.select_tags'),'multiple']) !!}
                                    </td>
                                    <td class="w_1">
                                        <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_modal_tag"><iconify-icon icon="ph:plus-fill" width="22"></iconify-icon></button>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.status') {!! starSign() !!}</label>
                            {!! Form::select('status',['1'=>__('index.active'), '2'=> __('index.in_active')], isset($obj->status)? $obj->status:null, ['class'=>'form-control select2', 'id' => 'status']) !!}
                        </div>
                        @if ($errors->has('status'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('status') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label>@lang('index.answer') {!! starSign() !!}</label>
                            {!! Form::textarea('answer', old('answer')??null, ['class' => 'form-control','id' => 'answer','placeholder'=>__('index.answer')]) !!}
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
                        <button type="submit" name="submit" class="btn bg-blue-btn w-100" id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('faq.index') }}">
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
                                    <span class="error_alert text-danger displayNone" role="alert" id="title-error">
                                        @lang('index.title_required')
                                    </span>
                                </div>

                                <div class="col-sm-12 mb-2 col-md-12">
                                    <div class="form-group">
                                        <label>@lang('index.description')</label>
                                        <textarea name="description" id="tiny_tag" class="form-control" placeholder="@lang('index.description')" maxlength="1000">{{ isset($obj->description)? $obj->description:null }}</textarea>
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

@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
<script src="{{ asset('frequent_changing/js/faq.js?var=2.2') }}"></script>
@endpush
