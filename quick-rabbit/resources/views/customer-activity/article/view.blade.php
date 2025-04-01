@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/article.css?var=2.2') }}">
@endpush

@section('content')
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.article_view') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.article'), 'secondSection' => __('index.article_view') ])
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
                            {{ ($obj->internal_external==1)? __('index.internal'):__('index.external') }}
                        </p>
                        <p class="">
                            <span class="heading-text">@lang('index.article_group')</span> :
                            {{ isset($obj->getArticleGroup)? $obj->getArticleGroup->title:"" }}
                        </p>

                        @if(count($tags) > 0)
                            <p>
                                <span class="heading-text">@lang('index.tags')</span>
                                <hr>
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

                @if(auth()->user())
                {!! Form::open(['method' => 'POST', 'url' => ['article-review/'.encrypt_decrypt($obj->id, 'encrypt')], 'class'=>'needs-validation', 'novalidate']) !!}
                    <div class="card mt-4">
                        <div class="card-body">
                            <p class="fw-bold text-muted pb-0 mb-0">Write a review</p>
                            <span>Current Rating: {{ number_format((float)$rating, 2, '.', '') }}</span>
                            <!-- Rating -->
                            <div class="form-group required">
                                <div class="rating">
                                    <input type="radio" name="rating" value="5" id="5" required> <label for="5">☆</label>
                                    <input type="radio" name="rating" value="4" id="4" required> <label for="4">☆</label>
                                    <input type="radio" name="rating" value="3" id="3" required> <label for="3">☆</label>
                                    <input type="radio" name="rating" value="2" id="2" required> <label for="2">☆</label>
                                    <input type="radio" name="rating" value="1" id="1" required> <label for="1">☆</label>
                                </div>
                                <div class="col-sm-6 col-md-12">
                                    <label>{{ __('index.review') }}</label>
                                    {!! Form::textarea('review', null, ['class' => 'form-control review','placeholder'=>__('index.review')]) !!}
                                </div>
                                <div class="col-md-1 my-2">
                                    <button type="submit" class="btn bg-blue-btn btn-md">@lang('index.submit')</button>

                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                @else
                    <div class="card mt-4">
                        <div class="card-body">
                            <p class="fw-bold text-muted pb-0 mb-0">Write a review</p>
                            <span>Current Rating: {{ $rating }}</span>
                            <!-- Rating -->
                            <div class="form-group required">
                                <div class="rating">
                                    <input type="radio" name="rating" value="5" id="5"><label for="5" required>☆</label>
                                    <input type="radio" name="rating" value="4" id="4"><label for="4" required>☆</label>
                                    <input type="radio" name="rating" value="3" id="3"><label for="3" required>☆</label>
                                    <input type="radio" name="rating" value="2" id="2"><label for="2" required>☆</label>
                                    <input type="radio" name="rating" value="1" id="1"><label for="1" required>☆</label>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <label>{{ __('index.review') }}</label>
                                    {!! Form::textarea('review', null, ['class' => 'form-control review','placeholder'=>__('index.review')]) !!}
                                </div>
                                <div class="col-sm-3 col-md-1">
                                    <button type="submit" class="review_submit_btn btn bg-blue-btn  btn-md">@lang('index.submit')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-sm-12 col-md-2 mt-2">
                    <a class="btn custom_header_btn w-100" href="{{ url('article-list') }}">
                        @lang('index.back')
                    </a>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script src="{{ asset('frequent_changing/js/customer_article_view.js?var=2.2') }}"></script>
@endpush
