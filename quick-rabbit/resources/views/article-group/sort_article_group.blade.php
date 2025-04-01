@extends('layouts.app')
@push('css')
    <link href="{{ asset('assets/bower_components/jquery_ui/jquery-ui.css?var=2.2') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/drag_drop_list.css?var=2.2') }}">
@endpush
@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header  mt-2">@lang('index.article_group_sorting')</h2>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.article_group'), 'secondSection' =>  __('index.article_sorting')])
        </div>
    </section>
    <div class="box-wrapper no_animation">
        <!-- general form elements -->
        <div class="table-box">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">@lang('index.article_group_sorting') {!! starSign() !!}</label>
                        <select id="product_category_id" class="form-control select2 mr-5">
                            <option value="">@lang('index.select')</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <ul class="sort_menu list-group" id="sort_article_groups">
                        <p class="alert alert-warning">@lang('index.select_product_category_first')</p>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 col-md-2 mb-2">
                <a class="btn custom_header_btn m-right btn-w-150 mt-10" href="{{ route('article-group.index') }}">@lang('index.back')</a>
            </div>
        </div>
    </div>
        
</section>
@stop

@push('js')
    <script src="{{ asset('assets/bower_components/jquery_ui/jquery-ui.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/article_group_sort.js?var=2.2') }}"></script>
@endpush


