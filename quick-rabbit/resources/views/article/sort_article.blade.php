@extends('layouts.app')
@push('css')
    <link href="{{ asset('assets/jquery_ui/jquery-ui.css?var=2.2') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/drag_drop_list.css?var=2.2') }}">
@endpush
@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row">
                <div class="col-md-8">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}"
                        class="top-left-header  mt-2">@lang('index.article_sorting')</h2>
                    <div class="row justify-content-between">
                        <div class="col-6 p-0">
                            <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}"
                                class="top-left-header  mt-2">@lang('index.article_sorting')</h2>
                        </div>
                        @include('layouts.breadcrumbs', ['firstSection' => __('index.article'), 'secondSection' => __('index.article_sorting')])
                    </div>
                </div>
                <div class="col-md-offset-2 col-md-4">
                    <div class="btn_list m-right d-flex">
                        <a class="btn custom_header_btn m-right"
                           href="{{ route('articles.index') }}">@lang('index.back')</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">@lang('index.product_category') {!! starSign() !!}</label>
                            <select id="product_category_id" class="form-control select2 mr-5">
                                <option value="">@lang('index.select')</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.article_group') {!! starSign() !!}</label>

                            <select name="article_group_id" class="form-control select2" id="article_group_id">
                                <option value="">@lang('index.select')</option>
                                @isset($obj)
                                    <option value="{{ $obj->article_group_id }}"
                                            selected>{{ $obj->getArticleGroup->title ?? "" }}</option>
                                @endisset
                            </select>
                        </div>
                        @if ($errors->has('article_group_id'))
                            <span class="error_alert text-danger" role="alert">
                            {{ $errors->first('article_group_id') }}
                        </span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="sort_menu list-group" id="sort_articles">
                            <p class="alert alert-danger">@lang('index.select_article_group_first')</p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script src="{{ asset('assets/jquery_ui/jquery-ui.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/article_sort.js?var=2.2') }}"></script>
@endpush


