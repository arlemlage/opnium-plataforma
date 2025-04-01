@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css?var=2.2') }}">
    @section('content')

        <input type="hidden" id="page-at" value="{{ Request::segment(1) }}">
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
                            {{ isset($obj) ? __('index.edit_article') : __('index.add_article') }}</h3>
                    </div>
                    @include('layouts.breadcrumbs', [
                        'firstSection' => __('index.article'),
                        'secondSection' => isset($obj) ? __('index.edit_article') : __('index.add_article'),
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
                        'route' => ['articles.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                        'id' => 'common-form',
                    ]) !!}
                    @csrf

                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
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
                        @if (appTheme() == 'multiple')
                            <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>@lang('index.product_category') {!! starSign() !!}</label>
                                    {!! Form::select(
                                        'product_category_id',
                                        $product_category,
                                        isset($obj->product_category_id) ? $obj->product_category_id : null,
                                        ['class' => 'form-control select2', 'id' => 'product_category_id', 'placeholder' => __('index.select')],
                                    ) !!}
                                </div>
                                @if ($errors->has('product_category_id'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('product_category_id') }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <input type="hidden" name="product_category_id"
                                value="{{ array_key_first($product_category->toArray()) }}">
                        @endif

                        <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>@lang('index.article_group') {!! starSign() !!}</label>
                                @if (appTheme() == 'multiple')
                                    <select name="article_group_id" class="form-control select2" id="article_group_id">
                                        @if (isset($obj))
                                            <option value="{{ $obj->article_group_id }}" selected>
                                                {{ $obj->getArticleGroup->title ?? '' }}
                                            </option>
                                        @else
                                            <option value="">@lang('index.select')</option>
                                        @endisset
                                </select>
                            @else
                                <select name="article_group_id" class="form-control select2" id="article_group_id">
                                    @if (!empty($article_group))
                                        @foreach ($article_group as $group)
                                            <option value="{{ $group->id }}"
                                                {{ isset($obj) && $obj->article_group_id == $group->id ? 'selected' : '' }}>
                                                {{ $group->title ?? '' }}</option>
                                        @endforeach
                                    @else
                                        <option value="">@lang('index.select')</option>
                                    @endif
                                </select>
                            @endif

                        </div>
                        @if ($errors->has('article_group_id'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('article_group_id') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="d-flex me-2">
                                @lang('index.internal_external')
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="right"
                                    data-bs-title="@lang('index.why_internal_external')">
                                    <iconify-icon icon="ri:question-fill" width="22"></iconify-icon>
                                </span>

                                {!! starSign() !!}
                            </label>
                            <select name="internal_external" id="internal_external" class="form-control select2">
                                <option value="1" {{ isset($obj) && $obj->internal_external == 1 ? 'selected' : '' }}>
                                    @lang('index.external')</option>
                                <option value="2" {{ isset($obj) && $obj->internal_external == 2 ? 'selected' : '' }}>
                                    @lang('index.internal')</option>

                            </select>
                        </div>
                        @if ($errors->has('internal_external'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('internal_external') }}
                            </span>
                        @endif
                    </div>

                    <?php
                    $selected_tag_ids = isset($obj->tag_ids) ? $obj->tag_ids : null;
                    ?>
                    <input type="hidden" id="selected_tag_ids" value="{{ $selected_tag_ids }}">

                    <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                        <div class="form-group custom_table">
                            <label>@lang('index.tags')</label>
                            <div class="table-responsive">
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            {!! Form::select('tag_ids[]', $tag, isset($obj->tag_ids) ? explode(',', $obj->tag_ids) : null, [
                                                'class' => 'form-control select2 width_100_p tags',
                                                'id' => 'tags',
                                                'data-placeholder' => __('index.select_tags'),
                                                'multiple',
                                            ]) !!}
                                        </td>
                                        <td class="ds_w_1_p">
                                            <button type="button"
                                                class="btn btn-md tag_add pull-right fit-content btn-success-edited pd-12 ms-2 open_modal_tag"><iconify-icon
                                                    icon="ph:plus-fill" width="22"></iconify-icon></button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>@lang('index.status') {!! starSign() !!}</label>
                            {!! Form::select(
                                'status',
                                ['1' => __('index.active'), '2' => __('index.in_active')],
                                isset($obj->status) ? $obj->status : null,
                                ['class' => 'form-control select2', 'id' => 'status'],
                            ) !!}
                        </div>
                        @if ($errors->has('status'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('status') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2 col-md-6 col-lg-4">                        
                        <div class="form-group custom_table">
                            <label>@lang('index.upload_video') (.mp4)</label>
                            <table>
                                <tr>
                                    <td>
                                        <input tabindex="1" type="file" name="video_link" class="form-control">
                                    </td>
                                    <td class="w_1">
                                        <div class="d-flex">
                                            @if(isset($obj->video_link) && file_exists('uploads/article_videos/'.$obj->video_link))
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_common_image_modal viw_file" id="image_block"><iconify-icon icon="solar:eye-bold" width="22"></iconify-icon></button>
                                            @endif
                                            <button type="button" id="preview_block" class="btn btn-md ms-2 pull-right fit-content btn-success-edited viw_file open_preview_image displayNone">
                                                <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            @if(Session::has('video_link'))
                            <span class="error_alert text-danger" role="alert">
                                {{ Session::get('video_link') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-6 col-lg-4">
                        <div class="form-group custom_table">
                            <label>@lang('index.thumbnail_image') (jpeg,jpg,png, 2MB)</label>
                            <table>
                                <tr>
                                    <td>
                                        <input tabindex="1" type="file" name="image" accept="image/jpeg,image/jpg,image/png" class="form-control" id="profile_photo">
                                        <input type="hidden" id="image_url" name="image_url" value="">
                                    </td>
                                    <td class="w_1">
                                        <div class="d-flex">
                                            @if(isset($obj->video_thumbnail) && file_exists('uploads/article_videos/'.$obj->video_thumbnail))
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_common_image_modal viw_file" id="image_block"><iconify-icon icon="solar:eye-bold" width="22"></iconify-icon></button>
                                            @endif
                                            <button type="button" id="preview_block" class="btn btn-md ms-2 pull-right fit-content btn-success-edited viw_file open_preview_image displayNone">
                                                <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            @if(Session::has('photo_error'))
                            <span class="error_alert text-danger" role="alert">
                                {{ Session::get('photo_error') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-12 col-lg-12">
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                            <label class="mt-2 mb-0">@lang('index.article_details') {!! starSign() !!}
                            </label>
                            <button type="button" class="btn btn-success-edited pull-right btn-xs open_media_modal"
                                data="iconViewer">
                                @lang('index.insert_media')
                            </button>
                        </div>
                            <textarea id="page_content" name="page_content" class="has-validation" required>{{ old('page_content') ?? ($obj->page_content ?? '') }}</textarea>
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
                        <button type="submit" name="submit" class="btn bg-blue-btn w-100" id="submit-btn">
                            <span class="me-2 spinner d-none"><iconify-icon icon="la:spinner"
                                    width="22"></iconify-icon></span>
                            @lang('index.submit')
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('articles.index') }}">
                            @lang('index.back')
                        </a>
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
                    <button type="button" class="btn-close close_modal_tag" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
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
                                            {!! Form::text('tag_title', null, [
                                                'class' => 'form-control',
                                                'id' => 'tag_title',
                                                'placeholder' => __('index.title'),
                                            ]) !!}
                                        </div>
                                        <span class="error_alert text-danger displayNone" role="alert"
                                            id="title-error">
                                            @lang('index.title_required')
                                        </span>
                                    </div>

                                    <div class="col-sm-12 mb-2 col-md-12">
                                        <div class="form-group">
                                            <label>@lang('index.description')</label>
                                            <textarea name="description" id="tiny_tag" class="form-control" placeholder="@lang('index.description')" maxlength="1000">{{ isset($obj->description) ? $obj->description : null }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-2 mb-2">
                                        <button type="button" class="btn bg-blue-btn btn-md add_new_tag"
                                            id="submit-tag">
                                            <span class="me-2 tag-spinner d-none"><iconify-icon icon="la:spinner"
                                                    width="22"></iconify-icon></span>
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
{{-- Crop Image --}}
<div class="modal fade" id="crop_image">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('index.thumbnail_image')</h4>
                <button type="button" class="btn-close close_modal_crop" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img class="img-fluid displayNone"/>
                </div>
                <br>
                <button id="crop_result" class="btn btn-sm bg-blue-btn">@lang('index.crop')</button>
            </div>
        </div>
    </div>
</div>
{{-- Preview Image Modal --}}
<div class="modal fade" id="preview_image">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('index.image')</h4>
                <button type="button" class="btn-close close_preview_image" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body text-center pb-3">
                <img src="" alt="" class="img-responsive w-100" id="crop-preview">
            </div>
        </div>
    </div>
</div>

    @include('helper.media_modal')

@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <link rel="stylesheet" href="{{ asset('frequent_changing/js/magnific-popup.css?var=2.2') }}">
    <script src="{{ asset('frequent_changing/js/jquery.magnific-popup.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/article.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/crop/cropper.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/media_management.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/article_image.js?var=1.0') }}"></script>
@endpush
