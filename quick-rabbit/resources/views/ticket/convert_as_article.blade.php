@extends('layouts.app')
@section('title','Edit Profile')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.add_article') }}</h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.ticket'), 'secondSection' => __('index.add_article')])
        </div>
    </section>

    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => 'POST', 'files'=>true,'url' => ['convert-ticket-to-article']]) !!}
            @csrf
            <input type="hidden" name="ticket_id" value="{{ encrypt_decrypt($obj->id, 'encrypt') }}">
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
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

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.product_category') {!! starSign() !!}</label>
                            {!! Form::select('product_category_id', $product_category, isset($obj->product_category_id)? $obj->product_category_id:null, ['class'=>'form-control select2','id'=>'product_category_id','placeholder'=>__('index.select')]) !!}
                        </div>
                        @if ($errors->has('product_category_id'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('product_category_id') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.article_group') {!! starSign() !!}</label>

                            <select name="article_group_id" class="form-control select2" id="article_group_id">
                                <option value="">@lang('index.select')</option>
                                @isset($obj)
                                    <option value="{{ $obj->article_group_id }}" selected>{{ $obj->getArticleGroup->title ?? "" }}</option>
                                @endisset
                            </select>
                        </div>
                        @if ($errors->has('article_group_id'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('article_group_id') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label class="d-flex me-2">
                                @lang('index.internal_external')
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('index.why_internal_external') }}">
                                    <iconify-icon icon="ri:question-fill" width="22"></iconify-icon> 
                                </span>
                            
                                 {!! starSign() !!}
                            </label>
                            {!! Form::select('internal_external',['1'=>'Internal', '2'=>'External'], isset($obj->internal_external)? $obj->internal_external:null, ['class'=>'form-control select2', 'placeholder'=>__('index.select')]) !!}
                        </div>
                        @if ($errors->has('internal_external'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('internal_external') }}
                            </span>
                        @endif
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
                            {!! Form::select('status',['1'=>__('index.active'), '2'=> __('index.in_active')], isset($obj->status)? $obj->status:null, ['class'=>'form-control select2']) !!}
                        </div>
                        @if ($errors->has('status'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('status') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label>@lang('index.article_details') {!! starSign() !!}</label>
                            <textarea name="page_content" id="tiny" class="form-control tiny">
                                {{ isset($obj->ticket_content)? $obj->ticket_content:null }} &#13;&#10;

                                @foreach($obj->getReplyComments as $key=>$comment)
                                    <?php
                                        $comment_fresh = str_replace('Regards,', ' ',$comment->ticket_comment);
                                        $comment_fresh = str_replace('Door Soft Support', ' ',$comment_fresh);
                                    ?>
                                    {!! $comment_fresh !!}
                                    &#13;&#10;
                                @endforeach
                            </textarea>
                        </div>
                        @if ($errors->has('page_content'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('page_content') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-12 col-md-2 mb-2">
                        <button type="submit" name="submit" class="btn bg-blue-btn w-100">@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-12 col-md-2 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('articles.index') }}">
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
                                        <textarea name="description" id="tiny_tag" class="form-control" placeholder="@lang('index.description')">{{ isset($obj->description)? $obj->description:null }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-2 mb-2">
                                    <button type="button" class="btn bg-blue-btn btn-md add_new_tag">@lang('index.submit')</button>
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
    <script src="{{ asset('frequent_changing/js/article.js?var=2.2') }}"></script>
@endpush
