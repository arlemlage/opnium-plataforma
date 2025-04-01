@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/article.css?var=2.2') }}">
@endpush

@section('content')
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.article_view') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.article'), 'secondSection' => __('index.article_view')])
            </div>
        </section>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            <span class="heading-text">@lang('index.published_date')</span> :
                            {{ isset($obj->created_at)? orgDateFormat($obj->created_at):"" }}
                        </p>
                        <p class="">
                            <span class="heading-text">@lang('index.product_category')</span>
                             :
                            {{ isset($obj->product_category_id)? $obj->getProductCategory->title:"" }}
                        </p>
                        <p class="">
                            <span class="heading-text">@lang('index.internal_external')</span>
                             :
                            {{ ($obj->internal_external==2)? __('index.internal'):__('index.external') }}
                        </p>
                        <p class="">
                            <span class="heading-text">@lang('index.article_group')</span> :
                            {{ isset($obj->getArticleGroup)? $obj->getArticleGroup->title:"" }}
                        </p>

                        @if(count($tags) > 0)
                            <p class="mb-1">
                                <span class="heading-text">@lang('index.tags')</span>
                                <hr class="mt-0">
                                @foreach($tags as $tag)
                                    <span class="tag-bg">{{ $tag->title }}</span>
                                @endforeach
                            </p>
                        @endif
                    </div>
                </div>
            </div>
         

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title p-0">{{ $obj->title ?? "" }}</h5>
                        <hr>
                        <div class="content-body">{!! $obj->page_content ?? "" !!}</div>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-12 col-md-2 mt-3">
                <a class="btn custom_header_btn w-100 mt-4" href="{{ route('articles.index') }}">
                    @lang('index.back')
                </a>
            </div>

        </div>


    </section>
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
