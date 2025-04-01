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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.blog_view') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.blog'), 'secondSection' => __('index.blog_view') ])
            </div>
        </section>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        @if(isset($obj->image) && file_exists($obj->image))
                        <img src="{{ asset($obj->image) }}" alt="Blog-Image" class="img-responsive" height="250" width="100%">
                        @else 
                        <img src="{{ asset('assets/images/blog-camera.jpg') }}" alt="Blog-Image" class="img-responsive" height="250" width="100%">
                        
                        @endif

                        <div class="mt-2">
                            @if(count($tags) > 0)
                            <p class="mb-1">
                                <span class="heading-text">@lang('index.tags')</span>
                            </p>
                            <hr class="mt-0">
                            @foreach($tags as $tag)
                                <span class="tag-bg">{{ $tag->title }}</span>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <span class="fs-6">
                            <span class="heading-text">@lang('index.published_date')</span>
                             : {{ isset($obj->created_at)? orgDateFormat($obj->created_at):"" }}
                            </span>
                            <br>
                            <span class="heading-text">{{ $obj->title ?? "" }}
                            </span>
                        <h5 class="card-title mb-0 pt-2"></h5>
                        @if(isset($obj->video_url))
                        <iframe width="560" height="315" src="{{ $obj->video_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @endif
                        <div class="content-body">{!! $obj->blog_content ?? "" !!}</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2 mt-3">
                    <a class="btn custom_header_btn w-100 mt-4" href="{{ route('blog.index') }}">
                        @lang('index.back')
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
