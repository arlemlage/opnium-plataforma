@extends(layout())
@section('menu')
    @include('frontend.menu_others')
@endsection

@section('footer_menu')
    @include('frontend.others_footer')
@endsection

@section('content')
    @include('frontend.__social_share')
    <input type="hidden" name="blog_id" id="blog_id" value="{{ $blog->id }}">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row g-4 align-items-center">
                <h2 class="mb-0">@lang('index.blog_details')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.pages')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    <div class="article-details-wrapper blog-details-wrapper">
        <div class="container" id="focused-div">
            @if (!Session::has('message'))
                <input type="hidden" id="active_page" value="BlogDetails">
            @endif
            <div class="row justify-content-center blog_sec">
                <div class="col-12 col-md-12 col-lg-8 article-details-col">
                    <div class="post-meta">
                        <ul class="mb-0 ps-0 list-unstyled d-flex align-items-center gap-30">
                            <li class="mb-0 date_sec">
                                <span>{{ date('d', strtotime($blog->created_at)) }}</span><span><svg width="1"
                                        height="21" viewBox="0 0 1 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <line x1="0.5" y1="0.5" x2="0.499999" y2="20.5"
                                            stroke="#E3E3E3" />
                                    </svg>
                                </span><span>{{ date('M', strtotime($blog->created_at)) }}</span>
                            </li>
                            <li class="mb-0 author_sec"><i class="bi bi-person"></i> by
                                {{ $blog->getCreatedBy->fullname }}
                            </li>
                            <li class="mb-0 author_sec"><svg width="18" height="19" viewBox="0 0 18 19"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_217_500)">
                                        <path
                                            d="M5.85031 12.2C9.08187 12.2 11.7003 9.9838 11.7003 7.25005C11.7003 4.5163 9.08187 2.30005 5.85031 2.30005C2.61875 2.30005 0.000307812 4.5163 0.000307812 7.25005C0.000307812 8.33567 0.413745 9.33974 1.11406 10.1582C1.01562 10.4225 0.86937 10.656 0.714683 10.8529C0.579683 11.0272 0.44187 11.1622 0.34062 11.255C0.289995 11.3 0.247808 11.3366 0.219683 11.3591C0.20562 11.3704 0.19437 11.3788 0.188745 11.3816L0.18312 11.3872C0.0284328 11.5025 -0.0390672 11.705 0.0228078 11.8879C0.0846828 12.0707 0.256245 12.2 0.450308 12.2C1.06343 12.2 1.68218 12.0425 2.19687 11.8485C2.45562 11.75 2.6975 11.6404 2.90843 11.5279C3.77187 11.9554 4.77593 12.2 5.85031 12.2ZM12.6003 7.25005C12.6003 10.4085 9.81312 12.7879 6.51125 13.0719C7.19468 15.1644 9.46156 16.7 12.1503 16.7C13.2247 16.7 14.2287 16.4554 15.095 16.0279C15.3059 16.1404 15.545 16.25 15.8037 16.3485C16.3184 16.5425 16.9372 16.7 17.5503 16.7C17.7444 16.7 17.9187 16.5735 17.9778 16.3879C18.0369 16.2022 17.9722 15.9997 17.8147 15.8844L17.8091 15.8788C17.8034 15.8732 17.7922 15.8675 17.7781 15.8563C17.75 15.8338 17.7078 15.8 17.6572 15.7522C17.5559 15.6594 17.4181 15.5244 17.2831 15.35C17.1284 15.1532 16.9822 14.9169 16.8837 14.6554C17.5841 13.8397 17.9975 12.8357 17.9975 11.7472C17.9975 9.13724 15.6097 6.99692 12.5806 6.8113C12.5919 6.95474 12.5975 7.10099 12.5975 7.24724L12.6003 7.25005Z"
                                            fill="#5065E2" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_217_500">
                                            <rect width="18" height="18" fill="white"
                                                transform="translate(0 0.5)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                @lang('index.comments') ({{ addLeadingZero(count($blog_comments)) }})
                            </li>
                        </ul>
                    </div>
                    <h2 class="blog_title" id="for_print_pdf_title">{{ $blog->title ?? '' }}</h2>
                    <input type="hidden" id="for_print_title" value="{{ $blog->title ?? '' }}">
                    <div class="article-details">
                        @if ($blog->image != 'assets/images/camera-icon.jpg')
                            <div class="img-article">
                                <div class="text-center">
                                    <img class="border-0" src="{{ asset($blog->image) }}" alt="">
                                </div>
                            </div>
                        @endif

                        <div class="blog_content_details for_print_pdf_content" id="for_print_pdf_content">
                            {!! $blog->blog_content !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="tag-wrapper">
                                    Tag:
                                    <span class="d-flex gap-16">
                                        @foreach ($post_tags as $key => $single_tag)
                                            <a class="tag_links"
                                                href="{{ route('blogs', ['tag' => $single_tag->title]) }}">{{ $single_tag->title ?? '' }}</a>
                                            @if (sizeof($post_tags) - 1 > $key)
                                            @endif
                                        @endforeach
                                    </span>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="share-link-wrapper">
                                    <span class="share-span">@lang('index.share'):</span>
                                    <ul class="share-link-list">
                                        <li><a target="_blank"
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                                title="Share on Facebook.">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.06299 10.5223V18H9.68799V10.5223H12.3911L12.9536 7.08398H9.68799V5.86758C9.68799 4.05 10.3224 3.35391 11.9599 3.35391C12.4692 3.35391 12.8786 3.36797 13.1161 3.39609V0.277734C12.6692 0.140625 11.5755 0 10.9442 0C7.60361 0 6.06299 1.77539 6.06299 5.60391V7.08398H4.00049V10.5223H6.06299Z"
                                                        fill="#171717" />
                                                </svg>

                                            </a></li>
                                        <li><a target="_blank"
                                                href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ $blog->title }}"
                                                title="Tweet this!">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_441_670)">
                                                        <path
                                                            d="M16.1502 6.23856C16.1616 6.38069 16.1616 6.52284 16.1616 6.66497C16.1616 11 12.4497 15.9949 5.66546 15.9949C3.57535 15.9949 1.63374 15.4568 0.000488281 14.5228C0.297453 14.5533 0.582957 14.5634 0.891348 14.5634C2.61594 14.5634 4.20352 14.0457 5.47129 13.1624C3.84946 13.132 2.49032 12.1878 2.02204 10.8883C2.25049 10.9188 2.4789 10.9391 2.71877 10.9391C3.04998 10.9391 3.38122 10.8984 3.68957 10.8274C1.99923 10.5228 0.731422 9.20303 0.731422 7.60913V7.56853C1.22252 7.81219 1.79363 7.96447 2.39892 7.98475C1.40526 7.39591 0.754273 6.39084 0.754273 5.25378C0.754273 4.64466 0.93698 4.08628 1.2568 3.59897C3.07279 5.58881 5.8025 6.88828 8.86338 7.03044C8.80628 6.78678 8.77201 6.533 8.77201 6.27919C8.77201 4.47206 10.4167 3 12.4611 3C13.5233 3 14.4826 3.39594 15.1565 4.03553C15.9903 3.89341 16.7897 3.61928 17.4979 3.24366C17.2237 4.00509 16.6413 4.64469 15.8761 5.05075C16.6185 4.97972 17.338 4.79694 18.0004 4.54316C17.498 5.19288 16.8698 5.77153 16.1502 6.23856Z"
                                                            fill="#171717" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_441_670">
                                                            <rect width="18" height="18" fill="white"
                                                                transform="translate(0.000488281)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                            </a></li>
                                        <li><a target="_blank"
                                                href="https://www.instagram.com/?url={{ urlencode(request()->url()) }}">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.0042 4.95708C6.76826 4.95708 4.96475 6.7606 4.96475 8.99653C4.96475 11.2325 6.76826 13.036 9.0042 13.036C11.2401 13.036 13.0437 11.2325 13.0437 8.99653C13.0437 6.7606 11.2401 4.95708 9.0042 4.95708ZM9.0042 11.6227C7.55928 11.6227 6.37803 10.445 6.37803 8.99653C6.37803 7.5481 7.55576 6.37036 9.0042 6.37036C10.4526 6.37036 11.6304 7.5481 11.6304 8.99653C11.6304 10.445 10.4491 11.6227 9.0042 11.6227ZM14.1511 4.79185C14.1511 5.31567 13.7292 5.73403 13.2089 5.73403C12.6851 5.73403 12.2667 5.31216 12.2667 4.79185C12.2667 4.27153 12.6886 3.84966 13.2089 3.84966C13.7292 3.84966 14.1511 4.27153 14.1511 4.79185ZM16.8265 5.7481C16.7667 4.48599 16.4784 3.36802 15.5538 2.44692C14.6327 1.52583 13.5147 1.23755 12.2526 1.17427C10.9519 1.10044 7.05303 1.10044 5.75225 1.17427C4.49365 1.23403 3.37568 1.52231 2.45107 2.44341C1.52646 3.3645 1.2417 4.48247 1.17842 5.74458C1.10459 7.04536 1.10459 10.9442 1.17842 12.245C1.23818 13.5071 1.52646 14.625 2.45107 15.5461C3.37568 16.4672 4.49014 16.7555 5.75225 16.8188C7.05303 16.8926 10.9519 16.8926 12.2526 16.8188C13.5147 16.759 14.6327 16.4708 15.5538 15.5461C16.4749 14.625 16.7632 13.5071 16.8265 12.245C16.9003 10.9442 16.9003 7.04888 16.8265 5.7481ZM15.146 13.6407C14.8718 14.3297 14.3409 14.8606 13.6483 15.1383C12.6112 15.5497 10.1503 15.4547 9.0042 15.4547C7.85811 15.4547 5.39365 15.5461 4.36006 15.1383C3.671 14.8641 3.14014 14.3333 2.8624 13.6407C2.45107 12.6036 2.546 10.1426 2.546 8.99653C2.546 7.85044 2.45459 5.38599 2.8624 4.35239C3.13662 3.66333 3.66748 3.13247 4.36006 2.85474C5.39717 2.44341 7.85811 2.53833 9.0042 2.53833C10.1503 2.53833 12.6147 2.44692 13.6483 2.85474C14.3374 3.12895 14.8683 3.65981 15.146 4.35239C15.5573 5.3895 15.4624 7.85044 15.4624 8.99653C15.4624 10.1426 15.5573 12.6071 15.146 13.6407Z"
                                                        fill="#171717" />
                                                </svg>

                                            </a></li>
                                        <li><a target="_blank" href="http://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.37549 0.228516C6.16924 0.228516 3.00049 2.6332 3.00049 6.525C3.00049 9 4.23799 10.4062 4.98799 10.4062C5.29736 10.4062 5.47549 9.43594 5.47549 9.16172C5.47549 8.83477 4.73486 8.13867 4.73486 6.77813C4.73486 3.95156 6.64736 1.94766 9.12236 1.94766C11.2505 1.94766 12.8255 3.3082 12.8255 5.80781C12.8255 7.67461 12.1599 11.1762 10.0036 11.1762C9.22549 11.1762 8.55986 10.5434 8.55986 9.63633C8.55986 8.30742 9.38486 7.0207 9.38486 5.64961C9.38486 3.32227 6.45049 3.74414 6.45049 6.55664C6.45049 7.14727 6.51611 7.80117 6.75049 8.33906C6.31924 10.4273 5.43799 13.5387 5.43799 15.6902C5.43799 16.3547 5.52236 17.0086 5.57861 17.673C5.68486 17.8066 5.63174 17.7926 5.79424 17.7258C7.36924 15.3 7.31299 14.8254 8.02549 11.6508C8.40986 12.4734 9.40361 12.9164 10.1911 12.9164C13.5099 12.9164 15.0005 9.27773 15.0005 5.99766C15.0005 2.50664 12.3192 0.228516 9.37549 0.228516Z"
                                                        fill="#171717" />
                                                </svg>

                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                            <hr class="m-3">
                        </div>
                    </div>
                    <!-- Comment Card -->
                    <div class="blog_bottom_part article-comment">
                        <div class="reply-list comment-list-wrapper">
                            <h3 class="comment-title"> @lang('index.comments')
                                ({{ addLeadingZero(count($blog_comments)) }})</span>
                            </h3>
                            <ul class="comment-list">
                                @if (count($blog_comments))
                                    @foreach ($blog_comments as $comment)
                                        <li class="comment-item" id="{{ $loop->last ? 'focused-comment' : '' }}">
                                            <div class="comment-inner">
                                                <img class="comment-avatar" src="{{ asset($comment->user_image) }}"
                                                    alt="user">
                                                <div class="comment-data">
                                                    <div class='top_text'>
                                                        <div class="d-flex align-items-center gap-15">
                                                            <h4 class="user-name">{{ $comment->name ?? '' }}</h4>
                                                            <span
                                                                class="date">{{ $comment->created_at->format('d M, Y h:i A') }}</span>
                                                        </div>
                                                    </div>
                                                    <p class="user-feedback">
                                                        {!! $comment->comment !!}
                                                    </p>
                                                    <div class="right_text">
                                                        <button class="reply_now" id="reply_btn"
                                                            data-name="{{ $comment->name }}">
                                                            <svg width="14" height="14" viewBox="0 0 14 14"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_321_1785)">
                                                                    <path
                                                                        d="M7.0186 10.4125L3.0216 7.54246C2.92767 7.48666 2.84987 7.40739 2.79583 7.31243C2.74179 7.21747 2.71338 7.11009 2.71338 7.00084C2.71338 6.89158 2.74179 6.7842 2.79583 6.68925C2.84987 6.59429 2.92767 6.51502 3.0216 6.45921L7.0186 3.58746C7.11388 3.53142 7.22229 3.50159 7.33283 3.50099C7.44337 3.50039 7.5521 3.52904 7.64798 3.58405C7.74386 3.63906 7.82348 3.71845 7.87876 3.81418C7.93404 3.9099 7.96301 4.01855 7.96272 4.12909V5.24996C9.27522 5.24996 13.2127 5.24996 14.0877 12.25C11.9002 8.31246 7.96272 8.74996 7.96272 8.74996V9.87084C7.96272 10.3608 7.43247 10.6566 7.0186 10.4133V10.4125Z"
                                                                        fill="#5065E2" />
                                                                    <path
                                                                        d="M4.57808 3.75633C4.61227 3.80262 4.637 3.85519 4.65085 3.91104C4.6647 3.96689 4.66739 4.02493 4.65878 4.08183C4.65016 4.13872 4.6304 4.19336 4.60064 4.24261C4.57088 4.29186 4.53169 4.33475 4.48533 4.36883L0.974826 6.95183L0.938076 6.97633C0.91905 6.98777 0.903307 7.00393 0.892377 7.02325C0.881447 7.04257 0.875703 7.06439 0.875703 7.08658C0.875703 7.10878 0.881447 7.1306 0.892377 7.14992C0.903307 7.16924 0.91905 7.1854 0.938076 7.19683L0.974826 7.22133L4.48533 9.80608C4.53273 9.8397 4.57297 9.88243 4.60368 9.93177C4.63439 9.98111 4.65496 10.0361 4.66419 10.0935C4.67343 10.1508 4.67113 10.2095 4.65745 10.266C4.64376 10.3225 4.61896 10.3756 4.58449 10.4224C4.55002 10.4692 4.50658 10.5087 4.45669 10.5385C4.4068 10.5683 4.35147 10.5879 4.29394 10.5961C4.2364 10.6043 4.1778 10.6009 4.12158 10.5862C4.06535 10.5715 4.01261 10.5458 3.96645 10.5105L0.471701 7.93883C0.327221 7.84865 0.208069 7.72318 0.125462 7.57423C0.0428554 7.42529 -0.000488281 7.25778 -0.000488281 7.08746C-0.000488281 6.91714 0.0428554 6.74963 0.125462 6.60068C0.208069 6.45174 0.327221 6.32627 0.471701 6.23608L3.96645 3.66358C4.05986 3.5948 4.17677 3.56592 4.29147 3.58332C4.40616 3.60071 4.50926 3.66294 4.57808 3.75633Z"
                                                                        fill="#5065E2" />
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_321_1785">
                                                                        <rect width="14" height="14"
                                                                            fill="white" />
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            @lang('index.replay')
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="article-comment-box reply-form">
                            <h3 class="comment-title">@lang('index.comments_heading')</h3>                            
                            
                                @if (Session::has('message'))
                                    <div class="alert alert-{{ Session::get('type') ?? 'info' }} alert-dismissible fade show">
                                        <div class="alert-body">
                                            <span><i class="m-right bi bi-check"></i>
                                                {{ Session::get('message') }}</span>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('store-blog-comment') }}" method="POST" id="blog-comment">
                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                    @csrf
                                    <div class="row comment-form-row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="@lang('index.name')" id="name"
                                                    value="{{ Auth::check() ? Auth::user()->full_name : '' }}">
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="text-danger d-none name-max-error">
                                                    @lang('index.name_max_100')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="@lang('index.email')" id="email"
                                                    value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="text-danger d-none name-max-error">
                                                    @lang('index.name_max_100')
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 text-area-col">
                                            <div class="form-comment">
                                                <textarea name="comment" class="comment-text-area" placeholder="Type your comment" id="comment" cols="30"
                                                    rows="10">{{ old('comment') ?? (Session::get('comment') ?? '') }}</textarea>
                                                @error('comment')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <p class="text-danger d-none comment-max-error">
                                                    @lang('index.comment_max_1000')
                                                </p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="isCaptchaEnable" value="{{ isCaptchaEnable() }}">
                                        @if (isCaptchaEnable())
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="captcha-box d-flex align-items-center mb-3">
                                                    <canvas id="canvas"></canvas>
                                                    <a href="javascript:void(0)" id="change-code" class="reset-btn">
                                                        <img src="{{ asset('assets/frontend/img/core-img/repeat.svg') }}"
                                                            alt="">
                                                    </a>
                                                </div>

                                                <input name="code" class="form-control col-md-3 code-input-control"
                                                    id="code" placeholder="@lang('index.captcha_code')">
                                                <span id="captcha-error" class="text-danger d-none">@lang('index.invalid_captcha_code')</span>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-12">
                                            <button class="gt-btn send_message_btn comment-submit-button" type="submit">
                                                @lang('index.post_comment')
                                                <span class="icon">
                                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.545 1.40324L10.4939 12.695C10.4649 12.9031 10.3694 13.0963 10.2218 13.2457C10.0741 13.3952 9.88214 13.493 9.67442 13.5245C9.4667 13.5561 9.25435 13.5198 9.06896 13.4209C8.88357 13.322 8.73505 13.166 8.64551 12.9759L6.39267 8.24091C6.38365 8.22375 6.37131 8.20854 6.35638 8.19618C6.34145 8.18381 6.32421 8.17453 6.30567 8.16886L1.37227 6.92424C1.17401 6.87371 0.995994 6.76365 0.862173 6.60889C0.728352 6.45413 0.645151 6.26209 0.623768 6.05861L0.620648 6.03291C0.596232 5.82634 0.637613 5.61733 0.738897 5.43565C0.840183 5.25396 0.996208 5.10887 1.18476 5.02102L11.1587 0.297653C11.3186 0.22318 11.4957 0.193633 11.671 0.212179C11.8464 0.230725 12.0133 0.296667 12.1541 0.402927C12.3063 0.516355 12.4237 0.670247 12.4928 0.847091C12.5619 1.02393 12.58 1.21663 12.545 1.40324Z" fill="#5065E2"/>
                                                        </svg>  
                                                </span>                                               
                                            </button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 left_site_col">
                    <div class="search_card">
                        <h2 class="title">@lang('index.search')</h2>
                        <form action="{{ route('blogs') }}" method="get">
                            @csrf
                            <div class="search-form">
                                <input type="text" name="search" class="form-control"
                                    placeholder="@lang('index.search')" value="{{ request()->search }}">
                                <button type="submit" class="search-btn">
                                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_225_505)">
                                            <path
                                                d="M13.459 6.5C13.459 7.93437 12.9934 9.25938 12.209 10.3344L16.1652 14.2937C16.5559 14.6844 16.5559 15.3188 16.1652 15.7094C15.7746 16.1 15.1402 16.1 14.7496 15.7094L10.7934 11.75C9.71836 12.5375 8.39336 13 6.95898 13C3.36836 13 0.458984 10.0906 0.458984 6.5C0.458984 2.90937 3.36836 0 6.95898 0C10.5496 0 13.459 2.90937 13.459 6.5ZM6.95898 11C7.54993 11 8.13509 10.8836 8.68106 10.6575C9.22703 10.4313 9.7231 10.0998 10.141 9.68198C10.5588 9.26412 10.8903 8.76804 11.1164 8.22208C11.3426 7.67611 11.459 7.09095 11.459 6.5C11.459 5.90905 11.3426 5.32389 11.1164 4.77792C10.8903 4.23196 10.5588 3.73588 10.141 3.31802C9.7231 2.90016 9.22703 2.56869 8.68106 2.34254C8.13509 2.1164 7.54993 2 6.95898 2C6.36804 2 5.78287 2.1164 5.23691 2.34254C4.69094 2.56869 4.19487 2.90016 3.777 3.31802C3.35914 3.73588 3.02767 4.23196 2.80153 4.77792C2.57538 5.32389 2.45898 5.90905 2.45898 6.5C2.45898 7.09095 2.57538 7.67611 2.80153 8.22208C3.02767 8.76804 3.35914 9.26412 3.777 9.68198C4.19487 10.0998 4.69094 10.4313 5.23691 10.6575C5.78287 10.8836 6.36804 11 6.95898 11Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_225_505">
                                                <rect width="16" height="16" fill="white"
                                                    transform="translate(0.458984)" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="category_card">
                        <h2 class="title">@lang('index.category')</h2>
                        <ul class="list-unlisted">
                            @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('blogs', ['category' => $category->slug]) }}">
                                    <span>{{ $category->title }}</span>
                                    <span>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.7063 8.70627C15.0969 8.31565 15.0969 7.68127 14.7063 7.29065L9.70625 2.29065C9.31563 1.90002 8.68125 1.90002 8.29063 2.29065C7.9 2.68127 7.9 3.31565 8.29063 3.70627L11.5875 7.00002H2C1.44687 7.00002 1 7.4469 1 8.00002C1 8.55315 1.44687 9.00002 2 9.00002H11.5844L8.29375 12.2938C7.90312 12.6844 7.90312 13.3188 8.29375 13.7094C8.68437 14.1 9.31875 14.1 9.70938 13.7094L14.7094 8.7094L14.7063 8.70627Z"
                                                fill="#727272" />
                                        </svg>
                                    </span>
                                </a>
                            </li>
                            @endforeach                                                       
                        </ul>
                    </div>
                    <div class="recent_post_sec">
                        <h2 class="title">@lang('index.recent_posts')</h2>
                        <div class="recent_posts">
                            @foreach ($recentPosts as $posts)
                            <div class="posts">
                                <div class="image">
                                    <img src="{{ asset($posts->image) }}" alt="">
                                </div>
                                <div class="title_with_author">
                                    <span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.625 12.25C2.625 12.25 1.75 12.25 1.75 11.375C1.75 10.5 2.625 7.875 7 7.875C11.375 7.875 12.25 10.5 12.25 11.375C12.25 12.25 11.375 12.25 11.375 12.25H2.625ZM7 7C7.69619 7 8.36387 6.72344 8.85616 6.23116C9.34844 5.73887 9.625 5.07119 9.625 4.375C9.625 3.67881 9.34844 3.01113 8.85616 2.51884C8.36387 2.02656 7.69619 1.75 7 1.75C6.30381 1.75 5.63613 2.02656 5.14384 2.51884C4.65156 3.01113 4.375 3.67881 4.375 4.375C4.375 5.07119 4.65156 5.73887 5.14384 6.23116C5.63613 6.72344 6.30381 7 7 7Z" fill="#727272"/>
                                        </svg>
                                        by {{ $posts->getCreatedBy->fullname }}</span>
                                    <a href="{{ route('blog-details', $posts->slug) }}">{{ $posts->title }}</a>
                                </div>
                            </div>
                            @endforeach                           
                        </div>
                    </div>
                    <div class="popular_tag_card">
                        <h2 class="title">@lang('index.popular_tags')</h2>
                        <ul>
                            @foreach ($tags as $tag)                                
                                <li><a href="{{ route('blogs', ['tag' => $single_tag->title]) }}">{{ $tag->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/jquery-captcha/jquery-captcha.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/blog-details.js') }}"></script>
@endpush
