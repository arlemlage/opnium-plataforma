@extends(layout())
@section('menu')
    @include('frontend.menu_others')
@endsection

@section('footer_menu')
    @include('frontend.others_footer')
@endsection
@section('content')    
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row g-4 align-items-center">
                <h2 class="mb-0">@lang('index.blogs')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.pages')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    <!-- Blog Wrapper -->
    <div class="blog-wrapper blog-wrapper-blog-page">
        <input type="hidden" id="active_page" value="Blogs">
        <div class="container">
            <div class="row blog-row">
                @foreach ($blogs as $blog)
                    <div class="col-12 col-md-6 col-lg-4 blog-col">
                        <div class="card blog-card">
                            <!-- Post Thumbnail -->
                            <a class="post-thumbnail" href="{{ route('blog-details', $blog->slug) }}">
                                <img loading="lazy" class="w-100"
                                    src="{{ $blog->thumb_img == null ? asset($blog->image) : asset($blog->thumb_img) }}"
                                    alt="">
                                <div class="light-shadow"></div>
                            </a>

                            <!-- Blog Content -->
                            <div class="blog-content">
                                <div class="d-flex gap-3 time_person justify-content-between">
                                    <span class="text-small addedBy">
                                        by {{ $blog->getCreatedBy->fullname }}
                                    </span>
                                    <span class="text-small time">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 0C5.55312 0 6 0.446875 6 1V2H10V1C10 0.446875 10.4469 0 11 0C11.5531 0 12 0.446875 12 1V2H13.5C14.3281 2 15 2.67188 15 3.5V5H1V3.5C1 2.67188 1.67188 2 2.5 2H4V1C4 0.446875 4.44688 0 5 0ZM1 6H15V14.5C15 15.3281 14.3281 16 13.5 16H2.5C1.67188 16 1 15.3281 1 14.5V6ZM3 8.5V9.5C3 9.775 3.225 10 3.5 10H4.5C4.775 10 5 9.775 5 9.5V8.5C5 8.225 4.775 8 4.5 8H3.5C3.225 8 3 8.225 3 8.5ZM7 8.5V9.5C7 9.775 7.225 10 7.5 10H8.5C8.775 10 9 9.775 9 9.5V8.5C9 8.225 8.775 8 8.5 8H7.5C7.225 8 7 8.225 7 8.5ZM11.5 8C11.225 8 11 8.225 11 8.5V9.5C11 9.775 11.225 10 11.5 10H12.5C12.775 10 13 9.775 13 9.5V8.5C13 8.225 12.775 8 12.5 8H11.5ZM3 12.5V13.5C3 13.775 3.225 14 3.5 14H4.5C4.775 14 5 13.775 5 13.5V12.5C5 12.225 4.775 12 4.5 12H3.5C3.225 12 3 12.225 3 12.5ZM7.5 12C7.225 12 7 12.225 7 12.5V13.5C7 13.775 7.225 14 7.5 14H8.5C8.775 14 9 13.775 9 13.5V12.5C9 12.225 8.775 12 8.5 12H7.5ZM11 12.5V13.5C11 13.775 11.225 14 11.5 14H12.5C12.775 14 13 13.775 13 13.5V12.5C13 12.225 12.775 12 12.5 12H11.5C11.225 12 11 12.225 11 12.5Z"
                                                fill="#727272" />
                                        </svg>

                                        {{ date('M d, Y', strtotime($blog->created_at)) }}
                                    </span>
                                </div>
                                <a class="blog-title h4 my-2" href="{{ route('blog-details', $blog->slug) }}">
                                    {{ $blog->title ?? '' }}
                                </a>
                                <a href="{{ route('blog-details', $blog->slug) }}"
                                    class="blog_read_more_btn me-2">
                                    @lang('index.read_more')<svg width="44" height="30" viewBox="0 0 44 30"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M30.3536 15.3536C30.5488 15.1583 30.5488 14.8417 30.3536 14.6464L27.1716 11.4645C26.9763 11.2692 26.6597 11.2692 26.4645 11.4645C26.2692 11.6597 26.2692 11.9763 26.4645 12.1716L29.2929 15L26.4645 17.8284C26.2692 18.0237 26.2692 18.3403 26.4645 18.5355C26.6597 18.7308 26.9763 18.7308 27.1716 18.5355L30.3536 15.3536ZM-4.37114e-08 15.5L30 15.5L30 14.5L4.37114e-08 14.5L-4.37114e-08 15.5Z"
                                            fill="#1E1D1D" />
                                        <circle cx="29" cy="15" r="14.5" stroke="black" />
                                    </svg>

                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $blogs->links('frontend.paginate') }}
        </div>
    </div>
@endsection
