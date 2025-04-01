@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css?var=2.2') }}">
@endpush

@section('content')
<input type="hidden" id="page-at" value="{{ Request::segment(1) }}">
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ isset($obj)? __('index.edit_blog'):__('index.add_blog') }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.blog'), 'secondSection' => isset($obj)? __('index.edit_blog') : __('index.add_blog')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => isset($obj) && $obj?'PATCH':'POST', 'files'=>true,'route' => ['blog.update', (isset($obj->id) && $obj->id)?encrypt_decrypt($obj->id, 'encrypt'):''],'id' => 'common-form']) !!}
            @csrf
            <div>
                <div class="row">

                    <div class="col-lg-8 col-md-6">
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

                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="form-group">
                            <label>@lang('index.category') {!! starSign() !!}</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="">@lang('index.select')</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ isset($obj) && $obj->category_id == $category->id || old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('category_id'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('category_id') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="form-group custom_table">
                            <label>@lang('index.image') (Types: jpeg,jpg,png, max. size:5mb)</label>
                            <table class="w-100">
                                <tr>
                                    <td>
                                        <input tabindex="1" type="file" name="image" accept=".jpeg,.png,.jpg" class="form-control file_checker_global" data-this_file_size_limit="5" value="" id="blog_image">
                                        <input type="hidden" id="image_url" name="image_url" value="">
                                    </td>
                                    <td class="w_1">
                                        @if(isset($obj->image) && file_exists($obj->image))
                                            <button type="button" id="image_block" class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_modal_image">
                                                <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                            </button>
                                        @endif
                                        <button type="button" id="preview_block" class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_preview_image displayNone">
                                            <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if(Session::has('image_error'))
                            <span class="text-danger">{{ Session::get('image_error') }}</span>
                        @endif
                    </div>
                    @php
                        $selected_tag_ids = isset($obj->tag_ids)? $obj->tag_ids:null;
                    @endphp
                    <input type="hidden" id="selected_tag_ids" value="{{ $selected_tag_ids }}">
                    <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                        <div class="form-group custom_table">
                            <label>@lang('index.tags')</label>
                            <div class="table-responsive">
                            <table>
                                <tr>
                                    <td class="ds_w_99_p">
                                        {!! Form::select('tag_ids[]', $tag, isset($obj->tag_ids)? explode(',', $obj->tag_ids):null, ['class'=>'form-control select2 width_100_p tags', 'id'=>'tags', 'data-placeholder'=>__('index.select_tags'), 'multiple']) !!}
                                    </td>
                                    <td class="ds_w_1_p">
                                        <button type="button" class="btn btn-md pull-right fit-content btn-success-edited  ms-2 open_modal_tag"><iconify-icon icon="ph:plus-fill" width="22"></iconify-icon></button>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-2">
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
                </div>
                <div class="row">
                    <input type="hidden" name="hidden_video_url" id="hidden_video_url" value="">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                            <label class="mt-2 mb-0">@lang('index.blog_details') {!! starSign() !!}</label>
                            <button type="button" class="btn btn-success-edited pull-right btn-xs open_media_modal"  id="" data="iconViewer">
                                @lang('index.insert_media')
                            </button>
                            </div>
                            <textarea id="blog_content" name="blog_content">{{ old('blog_content') ?? $obj->blog_content ?? '' }}</textarea>
                        </div>
                        @if ($errors->has('blog_content'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('blog_content') }}
                            </span>
                        @endif
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" class="btn bg-blue-btn w-100" id="submit-btn">
                            {!! commonSpinner() !!}
                            @lang('index.submit')
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('blog.index') }}">
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
                <h4 class="modal-title" id="myModalLabel">
                {{ __('index.add_tag') }}</h4>
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
                                        <textarea name="description" id="tiny_tag" class="form-control" placeholder="@lang('index.description')" maxlength="1000"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-2 mb-2">
                                    <button type="button" class="btn bg-blue-btn btn-md add_new_tag" id="submit-tag">
                                        <span class="me-2 tag-spinner d-none"><iconify-icon icon="la:spinner" width="22"></iconify-icon></span>
                                        @lang('index.submit')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal-->
<div class="modal fade" id="image">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('index.image')</h4>
                <button type="button" class="btn-close close_modal_image" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body text-center pb-3">
                <img src="{{ (isset($obj->image) && file_exists($obj->image))? asset($obj->image) :'' }}" alt="" class="img-responsive w-100" height="450" id="image-view">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="crop_image">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('index.image')</h4>
                <button type="button" class="btn-close close_modal_crop" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body text-center">
                <div class="img-container">
                    <img class="img-fluid displayNone"/>
                </div>
                <br>
                <button id="crop_result" class="btn btn-sm bg-blue-btn">@lang('index.crop')</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="preview_image">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('index.image')</h4>
                <button type="button" class="btn-close close_preview_image" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body text-center pb-3">
                <img src="" alt="" class="img-responsive w-100"  id="crop-preview">
            </div>
        </div>
    </div>
</div>



@include('helper.media_modal')
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/crop/cropper.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/blog.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/media_management.js?var=2.2') }}"></script>
@endpush
