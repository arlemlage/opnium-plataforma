@extends('frontend.app-second')
@push('css')
@endpush

@section('menu')
    @include('frontend.menu_home')
@endsection

@section('footer_menu')
    @include('frontend.home_footer')
@endsection

@section('content')
    <!-- Hero Area -->

    <div class="hero-area second-hero-area" id="hero">
        <div class="image_right">
            <img src="{{ asset('assets/frontend/img/new-img/secon_hero_right.svg') }}" alt="">
        </div>
        <div class="image_left">
            <img src="{{ asset('assets/frontend/img/new-img/second_hero_left.svg') }}" alt="">
        </div>
        <div class="overlay_cross_icon d-none">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_128_330)">
                    <path
                        d="M30 56.25C23.0381 56.25 16.3613 53.4844 11.4384 48.5616C6.51562 43.6387 3.75 36.9619 3.75 30C3.75 23.0381 6.51562 16.3613 11.4384 11.4384C16.3613 6.51562 23.0381 3.75 30 3.75C36.9619 3.75 43.6387 6.51562 48.5616 11.4384C53.4844 16.3613 56.25 23.0381 56.25 30C56.25 36.9619 53.4844 43.6387 48.5616 48.5616C43.6387 53.4844 36.9619 56.25 30 56.25ZM30 60C37.9565 60 45.5871 56.8393 51.2132 51.2132C56.8393 45.5871 60 37.9565 60 30C60 22.0435 56.8393 14.4129 51.2132 8.7868C45.5871 3.16071 37.9565 0 30 0C22.0435 0 14.4129 3.16071 8.7868 8.7868C3.16071 14.4129 0 22.0435 0 30C0 37.9565 3.16071 45.5871 8.7868 51.2132C14.4129 56.8393 22.0435 60 30 60Z"
                        fill="white" fill-opacity="0.7" />
                    <path
                        d="M17.4226 17.4225C17.5967 17.2479 17.8036 17.1093 18.0314 17.0148C18.2592 16.9203 18.5034 16.8716 18.7501 16.8716C18.9967 16.8716 19.2409 16.9203 19.4687 17.0148C19.6965 17.1093 19.9034 17.2479 20.0776 17.4225L30.0001 27.3487L39.9226 17.4225C40.0969 17.2482 40.3038 17.1099 40.5316 17.0155C40.7594 16.9212 41.0035 16.8726 41.2501 16.8726C41.4966 16.8726 41.7407 16.9212 41.9685 17.0155C42.1963 17.1099 42.4032 17.2482 42.5776 17.4225C42.7519 17.5968 42.8902 17.8038 42.9845 18.0316C43.0789 18.2593 43.1274 18.5035 43.1274 18.75C43.1274 18.9965 43.0789 19.2407 42.9845 19.4684C42.8902 19.6962 42.7519 19.9032 42.5776 20.0775L32.6513 30L42.5776 39.9225C42.7519 40.0968 42.8902 40.3038 42.9845 40.5316C43.0789 40.7593 43.1274 41.0035 43.1274 41.25C43.1274 41.4965 43.0789 41.7407 42.9845 41.9684C42.8902 42.1962 42.7519 42.4032 42.5776 42.5775C42.4032 42.7518 42.1963 42.8901 41.9685 42.9845C41.7407 43.0788 41.4966 43.1274 41.2501 43.1274C41.0035 43.1274 40.7594 43.0788 40.5316 42.9845C40.3038 42.8901 40.0969 42.7518 39.9226 42.5775L30.0001 32.6512L20.0776 42.5775C19.9032 42.7518 19.6963 42.8901 19.4685 42.9845C19.2407 43.0788 18.9966 43.1274 18.7501 43.1274C18.5035 43.1274 18.2594 43.0788 18.0316 42.9845C17.8038 42.8901 17.5969 42.7518 17.4226 42.5775C17.2482 42.4032 17.1099 42.1962 17.0156 41.9684C16.9212 41.7407 16.8727 41.4965 16.8727 41.25C16.8727 41.0035 16.9212 40.7593 17.0156 40.5316C17.1099 40.3038 17.2482 40.0968 17.4226 39.9225L27.3488 30L17.4226 20.0775C17.2479 19.9033 17.1094 19.6964 17.0149 19.4686C16.9204 19.2408 16.8717 18.9966 16.8717 18.75C16.8717 18.5034 16.9204 18.2592 17.0149 18.0314C17.1094 17.8036 17.2479 17.5967 17.4226 17.4225Z"
                        fill="white" fill-opacity="0.7" />
                </g>
                <defs>
                    <clipPath id="clip0_128_330">
                        <rect width="60" height="60" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </div>
        <div class="container second-home-page-container-for-hero position-relative">
            <input type="hidden" id="active_page" value="Home">
            <div class="row g-4 g-sm-5 justify-content-center justify-lg-content-between align-items-end">
                <div class="col-12 col-md-10 col-lg-10 col-xl-11">
                    <div class="hero-content text-center">
                        <div class="hero-content-text">
                            <h4 class="hero-subtitle" data-aos="fade-right">
                                @lang('index.this_portal_is')
                                <span class="img-with-text">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_16_37)">
                                            <path
                                                d="M6.53543 9.00317C6.668 9.00335 6.79518 8.95064 6.8889 8.85691C6.98262 8.76319 7.03534 8.63597 7.03515 8.50344C7.03515 8.22744 7.25905 8.00354 7.53506 8.00354C7.81111 8.00354 8.03497 8.22739 8.03497 8.50344C8.03497 8.7795 8.25868 9.00317 8.53469 9.00317C8.81093 9.00317 9.0346 8.77945 9.0346 8.50344C9.0346 7.67514 8.36318 7.00391 7.53506 7.00391C6.70698 7.00391 6.03552 7.67514 6.03552 8.50344C6.03549 8.56909 6.04841 8.6341 6.07353 8.69475C6.09864 8.7554 6.13547 8.81051 6.1819 8.85692C6.22832 8.90333 6.28345 8.94014 6.34411 8.96523C6.40477 8.99032 6.46978 9.00322 6.53543 9.00317ZM13.3097 12.305C11.443 13.2382 8.62602 13.2382 6.75895 12.305C6.512 12.1814 6.21181 12.2816 6.08824 12.5285C5.9649 12.7754 6.06481 13.0758 6.31176 13.1992C7.47506 13.7479 8.74811 14.0244 10.0342 14.0075C11.3204 14.0243 12.5934 13.7479 13.7567 13.1992C14.0037 13.0758 14.1038 12.7754 13.9804 12.5285C13.8569 12.2815 13.5566 12.1814 13.3097 12.305V12.305Z"
                                                fill="#5065E2" />
                                            <path
                                                d="M18.5317 8.00379H18.0318V6.50425C18.0306 5.12467 16.9123 4.00639 15.5326 4.00513H14.0331V2.91323C14.7216 2.66998 15.1347 1.96575 15.0112 1.24602C14.8876 0.526104 14.2635 0 13.5332 0C12.8028 0 12.1788 0.526104 12.0552 1.24602C11.9317 1.9658 12.3448 2.66998 13.0332 2.91323V4.00508H7.03509V2.91323C7.72375 2.66998 8.13669 1.96575 8.01331 1.24602C7.88987 0.526104 7.26578 0 6.53542 0C5.80505 0 5.18086 0.526104 5.05748 1.24602C4.93396 1.9658 5.34689 2.66998 6.03551 2.91323V4.00508H4.53597C3.15635 4.00658 2.0383 5.12463 2.0368 6.50429V8.00383H1.53689C0.709147 8.00477 0.0382907 8.67563 0.0373535 9.50337V11.5028C0.0382907 12.3306 0.709147 13.0014 1.53689 13.0024H2.0368V15.0016C2.0383 16.3814 3.15635 17.4995 4.53597 17.501H7.03514V19.5002C7.03521 19.5895 7.05915 19.677 7.10446 19.7539C7.14978 19.8308 7.21483 19.8941 7.29287 19.9373C7.37088 19.9806 7.45905 20.0021 7.54821 19.9998C7.63737 19.9974 7.72427 19.9713 7.7999 19.924L11.6773 17.501H15.5326C16.9123 17.4997 18.0306 16.3815 18.0318 15.0016V13.0024H18.5317C19.3595 13.0014 20.0303 12.3306 20.0313 11.5028V9.50332C20.0303 8.67558 19.3595 8.00472 18.5317 8.00379ZM13.5332 1.0061C13.8093 1.0061 14.0331 1.22976 14.0331 1.50582C14.0331 1.78201 13.8093 2.00573 13.5332 2.00573C13.2572 2.00573 13.0333 1.78201 13.0333 1.50582C13.0339 1.23014 13.2574 1.00661 13.5332 1.0061ZM6.53542 1.0061C6.81147 1.0061 7.03514 1.22976 7.03514 1.50582C7.03514 1.78201 6.81147 2.00573 6.53542 2.00573C6.25936 2.00573 6.03551 1.78201 6.03551 1.50582C6.03588 1.22995 6.25941 1.00647 6.53542 1.0061ZM1.53689 12.0025C1.26107 12.0024 1.03736 11.7786 1.03698 11.5028V9.50332C1.03736 9.22746 1.26107 9.00379 1.53689 9.00342H2.0368V12.0025L1.53689 12.0025ZM17.0322 15.0016C17.0312 15.8295 16.3604 16.5004 15.5326 16.5012H11.5338C11.4402 16.5012 11.3485 16.5275 11.2693 16.5773L8.03495 18.5982V17.001C8.03492 16.8684 7.98224 16.7413 7.88849 16.6476C7.79475 16.5538 7.66762 16.5011 7.53505 16.5011H4.53597C3.70822 16.5004 3.03737 15.8295 3.03643 15.0016V6.50425C3.03737 5.6765 3.70822 5.00565 4.53597 5.00471H15.5326C16.3604 5.00565 17.0312 5.6765 17.0322 6.50425V15.0016ZM19.0314 11.5028C19.0311 11.7786 18.8076 12.0022 18.5317 12.0025H18.0318V9.00346H18.5317C18.8076 9.00403 19.0311 9.2275 19.0314 9.50337V11.5028Z"
                                                fill="#5065E2" />
                                            <path
                                                d="M12.5335 7.00391C11.7057 7.00484 11.0349 7.6757 11.0339 8.50344C11.0339 8.77945 11.2576 9.00317 11.5337 9.00317C11.8099 9.00317 12.0336 8.77945 12.0336 8.50344C12.0336 8.22744 12.2575 8.00354 12.5335 8.00354C12.8095 8.00354 13.0332 8.22739 13.0332 8.50344C13.0332 8.7795 13.2571 9.00317 13.5331 9.00317C13.8092 9.00317 14.033 8.77945 14.033 8.50344C14.0321 7.6757 13.3612 7.00484 12.5335 7.00391Z"
                                                fill="#5065E2" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_16_37">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    @lang('index.ai_powered')
                                </span>
                                @lang('index.to_assist')
                            </h4>
                            <h2 class="hero-title banner_text wow fadeInUp" data-wow-delay="1000ms" data-wow-duration="1000ms">
                                {{-- we used this variable without escape due to remark html content --}}
                                {{ siteSetting()->banner_text ?? 'Hello! what can we help you find?' }}
                            </h2>
                        </div>
                        <!-- Card -->
                        <div>
                            <div class="search-area search_area_unique">
                                <form class="top-search-form second-top-search-form" action="#">
                                    <div class="row input-box second-input-box m-0">
                                        <div class="col-12 col-lg-8">
                                            <input type="text" id="searchInputModal"
                                                class="form-control input-focused search-key top-search-form-input"
                                                placeholder="@lang('index.search')... e:g license uninstall">
                                            <div class="search-icon" id="search-icon">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.75 8.25C3.75 5.76825 5.76825 3.75 8.25 3.75C10.7317 3.75 12.75 5.76825 12.75 8.25C12.75 10.7317 10.7317 12.75 8.25 12.75C5.76825 12.75 3.75 10.7317 3.75 8.25ZM15.5302 14.4697L12.984 11.9228C13.7737 10.9073 14.25 9.6345 14.25 8.25C14.25 4.94175 11.5582 2.25 8.25 2.25C4.94175 2.25 2.25 4.94175 2.25 8.25C2.25 11.5582 4.94175 14.25 8.25 14.25C9.6345 14.25 10.9072 13.7738 11.9227 12.984L14.4697 15.5303C14.616 15.6765 14.808 15.75 15 15.75C15.192 15.75 15.384 15.6765 15.5302 15.5303C15.8235 15.237 15.8235 14.763 15.5302 14.4697Z"
                                                        fill="white" />
                                                    <mask id="mask0_2305_3964" style="mask-type:luminance"
                                                        maskUnits="userSpaceOnUse" x="2" y="2" width="14"
                                                        height="14">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M3.75 8.25C3.75 5.76825 5.76825 3.75 8.25 3.75C10.7317 3.75 12.75 5.76825 12.75 8.25C12.75 10.7317 10.7317 12.75 8.25 12.75C5.76825 12.75 3.75 10.7317 3.75 8.25ZM15.5302 14.4697L12.984 11.9228C13.7737 10.9073 14.25 9.6345 14.25 8.25C14.25 4.94175 11.5582 2.25 8.25 2.25C4.94175 2.25 2.25 4.94175 2.25 8.25C2.25 11.5582 4.94175 14.25 8.25 14.25C9.6345 14.25 10.9072 13.7738 11.9227 12.984L14.4697 15.5303C14.616 15.6765 14.808 15.75 15 15.75C15.192 15.75 15.384 15.6765 15.5302 15.5303C15.8235 15.237 15.8235 14.763 15.5302 14.4697Z"
                                                            fill="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_2305_3964)">
                                                        <rect width="18" height="18" fill="white" />
                                                    </g>
                                                </svg>
                                            </div>
                                            <button type="button" class="cross-icon" id="crossIcon">
                                                <svg width="22" height="22" viewBox="0 0 22 22"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2.95076 3.92425C2.88684 3.86033 2.83614 3.78444 2.80154 3.70093C2.76695 3.61741 2.74915 3.5279 2.74915 3.4375C2.74915 3.3471 2.76695 3.25759 2.80154 3.17407C2.83614 3.09055 2.88684 3.01467 2.95076 2.95075C3.01468 2.88683 3.09057 2.83612 3.17409 2.80153C3.2576 2.76694 3.34712 2.74913 3.43751 2.74913C3.52791 2.74913 3.61742 2.76694 3.70094 2.80153C3.78446 2.83612 3.86034 2.88683 3.92426 2.95075L11 10.0279L18.0758 2.95075C18.1397 2.88683 18.2156 2.83612 18.2991 2.80153C18.3826 2.76694 18.4721 2.74913 18.5625 2.74913C18.6529 2.74913 18.7424 2.76694 18.8259 2.80153C18.9095 2.83612 18.9853 2.88683 19.0493 2.95075C19.1132 3.01467 19.1639 3.09055 19.1985 3.17407C19.2331 3.25759 19.2509 3.3471 19.2509 3.4375C19.2509 3.5279 19.2331 3.61741 19.1985 3.70093C19.1639 3.78444 19.1132 3.86033 19.0493 3.92425L11.9721 11L19.0493 18.0757C19.1132 18.1397 19.1639 18.2156 19.1985 18.2991C19.2331 18.3826 19.2509 18.4721 19.2509 18.5625C19.2509 18.6529 19.2331 18.7424 19.1985 18.8259C19.1639 18.9094 19.1132 18.9853 19.0493 19.0492C18.9853 19.1132 18.9095 19.1639 18.8259 19.1985C18.7424 19.2331 18.6529 19.2509 18.5625 19.2509C18.4721 19.2509 18.3826 19.2331 18.2991 19.1985C18.2156 19.1639 18.1397 19.1132 18.0758 19.0492L11 11.9721L3.92426 19.0492C3.86034 19.1132 3.78446 19.1639 3.70094 19.1985C3.61742 19.2331 3.52791 19.2509 3.43751 19.2509C3.34712 19.2509 3.2576 19.2331 3.17409 19.1985C3.09057 19.1639 3.01468 19.1132 2.95076 19.0492C2.88684 18.9853 2.83614 18.9094 2.80154 18.8259C2.76695 18.7424 2.74915 18.6529 2.74915 18.5625C2.74915 18.4721 2.76695 18.3826 2.80154 18.2991C2.83614 18.2156 2.88684 18.1397 2.95076 18.0757L10.0279 11L2.95076 3.92425Z"
                                                        fill="white" />
                                                </svg>
                                            </button>
                                        </div>   
                                        <div class="search-results-card shadow-sm text-center mx-auto" id="searchResults">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link" id="search1-tab" data-bs-toggle="tab"
                                                        data-bs-target="#search1" type="button" role="tab"
                                                        aria-controls="search1" aria-selected="true">@lang('index.article')</button>
            
                                                    <button class="nav-link" id="search2-tab" data-bs-toggle="tab"
                                                        data-bs-target="#search2" type="button" role="tab"
                                                        aria-controls="search2" aria-selected="false">@lang('index.faq')</button>
            
                                                    <button class="nav-link" id="search3-tab" data-bs-toggle="tab"
                                                        data-bs-target="#search3" type="button" role="tab"
                                                        aria-controls="search3" aria-selected="false">@lang('index.blog')</button>
            
                                                    <button class="nav-link" id="search4-tab" data-bs-toggle="tab"
                                                        data-bs-target="#search4" type="button" role="tab"
                                                        aria-controls="search4" aria-selected="false">@lang('index.page')</button>
                                                    <button class="nav-link" id="search5-tab" data-bs-toggle="tab"
                                                        data-bs-target="#search5" type="button" role="tab"
                                                        aria-controls="search5" aria-selected="false">AI</button>
                                                </div>
                                            </nav>
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12 text-center">
                                                    <h2 class="card-title">
                                                        {{ __('index.check_search_result') }}
                                                    </h2>
                                                    <div class="lds-facebook loader-img">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                     
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 d-flex justify-content-center align-items-center gap-3 mt-4">
                                <span class="article_page_popular_search_title">@lang('index.popular_search'):</span>
                                <ul class="popular-search-list list-unstyled d-flex gap-2">
                                    <li>@lang('index.printer')</li>
                                    <li>@lang('index.getting_started')</li>
                                    <li>@lang('index.settings')</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="support_image">
                        <img src="{{ asset('assets/frontend/img/new-img/second_home_page_bg_image.svg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="ellipse_1"></div>
            <div class="ellipse_2"></div>
            <div class="ellipse_3"></div>
        </div>
    </div>
    </div>
    <div class="feature-section-main second-feature-section-main">

        <div class="container">
            <div class="feature-section-flex">
                <div class="text-center">
                    <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                        @include('frontend.svg.star')
                        @lang('index.core_feature')
                    </p>
                    <h2 class="section-title">{{ sectionTitle()[0]['title'] }}</h2>
                </div>

                <div class="feature-section-wrap" data-aos="fade-up" data-aos-duration="3000">
                    <div class="feature-section">
                        <div class="feature-card second-feature-card">
                            <div class="feature-body row">
                                <div class="col-sm-5 d-flex gap-90 align-items-center">
                                    <div class="number">
                                        01
                                    </div>
                                    <div class="d-flex gap-30 align-items-center">
                                        <div class="icon">
                                            <img src="{{ featureSetting()[0]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[0]['icon']) : asset('assets/frontend/img/core-img/ai_powered.svg') }}"
                                                alt="" class="icon-image">
                                        </div>
                                        <h5 class="">{{ featureSetting()[0]['title'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <p class="mb-0">
                                        {{ featureSetting()[0]['description'] }}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <div class="service-arrow">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.75 1.87639C19.1423 1.07254 20.8577 1.07254 22.25 1.87639L34.5705 8.98964C35.9628 9.79349 36.8205 11.2791 36.8205 12.8868V27.1132C36.8205 28.7209 35.9628 30.2065 34.5705 31.0104L22.25 38.1236C20.8577 38.9275 19.1423 38.9275 17.75 38.1236L5.42949 31.0104C4.03719 30.2065 3.17949 28.7209 3.17949 27.1132V12.8868C3.17949 11.2791 4.03719 9.79348 5.42949 8.98964L17.75 1.87639Z"
                                                stroke="#1E1D1D" />
                                            <g clip-path="url(#clip0_292_208)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.721 23.3736C13.6522 23.2539 13.6338 23.1117 13.6699 22.9783C13.7059 22.845 13.7934 22.7314 13.9132 22.6626L24.565 16.5434L20.0902 15.3348C19.9566 15.2987 19.8429 15.211 19.774 15.0911C19.7051 14.9712 19.6867 14.8288 19.7228 14.6953C19.7589 14.5617 19.8465 14.448 19.9665 14.3791C20.0864 14.3102 20.2288 14.2918 20.3623 14.3279L26.0507 15.8653C26.1169 15.8831 26.1789 15.9137 26.2332 15.9555C26.2875 15.9973 26.333 16.0494 26.3671 16.1088C26.4012 16.1682 26.4233 16.2338 26.4321 16.3017C26.4408 16.3697 26.4361 16.4387 26.4181 16.5048L24.8807 22.1932C24.8446 22.3268 24.757 22.4405 24.6371 22.5094C24.5171 22.5783 24.3747 22.5967 24.2412 22.5606C24.1077 22.5245 23.994 22.4369 23.9251 22.317C23.8562 22.197 23.8378 22.0546 23.8739 21.9211L25.0839 17.4466L14.4321 23.5658C14.3123 23.6346 14.1701 23.653 14.0368 23.617C13.9034 23.581 13.7899 23.4934 13.721 23.3736Z"
                                                    fill="#2D2C2B" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_292_208">
                                                    <rect width="16.6667" height="16.6667" fill="white"
                                                        transform="translate(8.6665 16.6667) rotate(-29.8763)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        @lang('index.get_started')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card second-feature-card">
                            <div class="feature-body row">
                                <div class="col-sm-5 d-flex gap-90 align-items-center">
                                    <div class="number">
                                        02
                                    </div>
                                    <div class="d-flex gap-30 align-items-center">
                                        <div class="icon">
                                            <img src="{{ featureSetting()[1]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[1]['icon']) : asset('assets/frontend/img/core-img/knowledgebase.svg') }}"
                                                alt="" class="icon-image">
                                        </div>
                                        <h5 class="">{{ featureSetting()[1]['title'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <p class="mb-0">
                                        {{ featureSetting()[1]['description'] }}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <div class="service-arrow">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.75 1.87639C19.1423 1.07254 20.8577 1.07254 22.25 1.87639L34.5705 8.98964C35.9628 9.79349 36.8205 11.2791 36.8205 12.8868V27.1132C36.8205 28.7209 35.9628 30.2065 34.5705 31.0104L22.25 38.1236C20.8577 38.9275 19.1423 38.9275 17.75 38.1236L5.42949 31.0104C4.03719 30.2065 3.17949 28.7209 3.17949 27.1132V12.8868C3.17949 11.2791 4.03719 9.79348 5.42949 8.98964L17.75 1.87639Z"
                                                stroke="#1E1D1D" />
                                            <g clip-path="url(#clip0_292_208)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.721 23.3736C13.6522 23.2539 13.6338 23.1117 13.6699 22.9783C13.7059 22.845 13.7934 22.7314 13.9132 22.6626L24.565 16.5434L20.0902 15.3348C19.9566 15.2987 19.8429 15.211 19.774 15.0911C19.7051 14.9712 19.6867 14.8288 19.7228 14.6953C19.7589 14.5617 19.8465 14.448 19.9665 14.3791C20.0864 14.3102 20.2288 14.2918 20.3623 14.3279L26.0507 15.8653C26.1169 15.8831 26.1789 15.9137 26.2332 15.9555C26.2875 15.9973 26.333 16.0494 26.3671 16.1088C26.4012 16.1682 26.4233 16.2338 26.4321 16.3017C26.4408 16.3697 26.4361 16.4387 26.4181 16.5048L24.8807 22.1932C24.8446 22.3268 24.757 22.4405 24.6371 22.5094C24.5171 22.5783 24.3747 22.5967 24.2412 22.5606C24.1077 22.5245 23.994 22.4369 23.9251 22.317C23.8562 22.197 23.8378 22.0546 23.8739 21.9211L25.0839 17.4466L14.4321 23.5658C14.3123 23.6346 14.1701 23.653 14.0368 23.617C13.9034 23.581 13.7899 23.4934 13.721 23.3736Z"
                                                    fill="#2D2C2B" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_292_208">
                                                    <rect width="16.6667" height="16.6667" fill="white"
                                                        transform="translate(8.6665 16.6667) rotate(-29.8763)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        @lang('index.get_started')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card second-feature-card">
                            <div class="feature-body row">
                                <div class="col-sm-5 d-flex gap-90 align-items-center">
                                    <div class="number">
                                        03
                                    </div>
                                    <div class="d-flex gap-30 align-items-center">
                                        <div class="icon">
                                            <img src="{{ featureSetting()[2]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[2]['icon']) : asset('assets/frontend/img/core-img/support.svg') }}"
                                                alt="" class="icon-image">
                                        </div>
                                        <h5 class="">{{ featureSetting()[2]['title'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <p class="mb-0">
                                        {{ featureSetting()[2]['description'] }}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <div class="service-arrow">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.75 1.87639C19.1423 1.07254 20.8577 1.07254 22.25 1.87639L34.5705 8.98964C35.9628 9.79349 36.8205 11.2791 36.8205 12.8868V27.1132C36.8205 28.7209 35.9628 30.2065 34.5705 31.0104L22.25 38.1236C20.8577 38.9275 19.1423 38.9275 17.75 38.1236L5.42949 31.0104C4.03719 30.2065 3.17949 28.7209 3.17949 27.1132V12.8868C3.17949 11.2791 4.03719 9.79348 5.42949 8.98964L17.75 1.87639Z"
                                                stroke="#1E1D1D" />
                                            <g clip-path="url(#clip0_292_208)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.721 23.3736C13.6522 23.2539 13.6338 23.1117 13.6699 22.9783C13.7059 22.845 13.7934 22.7314 13.9132 22.6626L24.565 16.5434L20.0902 15.3348C19.9566 15.2987 19.8429 15.211 19.774 15.0911C19.7051 14.9712 19.6867 14.8288 19.7228 14.6953C19.7589 14.5617 19.8465 14.448 19.9665 14.3791C20.0864 14.3102 20.2288 14.2918 20.3623 14.3279L26.0507 15.8653C26.1169 15.8831 26.1789 15.9137 26.2332 15.9555C26.2875 15.9973 26.333 16.0494 26.3671 16.1088C26.4012 16.1682 26.4233 16.2338 26.4321 16.3017C26.4408 16.3697 26.4361 16.4387 26.4181 16.5048L24.8807 22.1932C24.8446 22.3268 24.757 22.4405 24.6371 22.5094C24.5171 22.5783 24.3747 22.5967 24.2412 22.5606C24.1077 22.5245 23.994 22.4369 23.9251 22.317C23.8562 22.197 23.8378 22.0546 23.8739 21.9211L25.0839 17.4466L14.4321 23.5658C14.3123 23.6346 14.1701 23.653 14.0368 23.617C13.9034 23.581 13.7899 23.4934 13.721 23.3736Z"
                                                    fill="#2D2C2B" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_292_208">
                                                    <rect width="16.6667" height="16.6667" fill="white"
                                                        transform="translate(8.6665 16.6667) rotate(-29.8763)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        @lang('index.get_started')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card second-feature-card">
                            <div class="feature-body row">
                                <div class="col-sm-5 d-flex gap-90 align-items-center">
                                    <div class="number">
                                        04
                                    </div>
                                    <div class="d-flex gap-30 align-items-center">
                                        <div class="icon">
                                            <img src="{{ featureSetting()[3]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[3]['icon']) : asset('assets/frontend/img/core-img/live_chat.svg') }}"
                                                alt="" class="icon-image">
                                        </div>
                                        <h5 class="">{{ featureSetting()[3]['title'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <p class="mb-0">
                                        {{ featureSetting()[3]['description'] }}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <div class="service-arrow">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.75 1.87639C19.1423 1.07254 20.8577 1.07254 22.25 1.87639L34.5705 8.98964C35.9628 9.79349 36.8205 11.2791 36.8205 12.8868V27.1132C36.8205 28.7209 35.9628 30.2065 34.5705 31.0104L22.25 38.1236C20.8577 38.9275 19.1423 38.9275 17.75 38.1236L5.42949 31.0104C4.03719 30.2065 3.17949 28.7209 3.17949 27.1132V12.8868C3.17949 11.2791 4.03719 9.79348 5.42949 8.98964L17.75 1.87639Z"
                                                stroke="#1E1D1D" />
                                            <g clip-path="url(#clip0_292_208)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.721 23.3736C13.6522 23.2539 13.6338 23.1117 13.6699 22.9783C13.7059 22.845 13.7934 22.7314 13.9132 22.6626L24.565 16.5434L20.0902 15.3348C19.9566 15.2987 19.8429 15.211 19.774 15.0911C19.7051 14.9712 19.6867 14.8288 19.7228 14.6953C19.7589 14.5617 19.8465 14.448 19.9665 14.3791C20.0864 14.3102 20.2288 14.2918 20.3623 14.3279L26.0507 15.8653C26.1169 15.8831 26.1789 15.9137 26.2332 15.9555C26.2875 15.9973 26.333 16.0494 26.3671 16.1088C26.4012 16.1682 26.4233 16.2338 26.4321 16.3017C26.4408 16.3697 26.4361 16.4387 26.4181 16.5048L24.8807 22.1932C24.8446 22.3268 24.757 22.4405 24.6371 22.5094C24.5171 22.5783 24.3747 22.5967 24.2412 22.5606C24.1077 22.5245 23.994 22.4369 23.9251 22.317C23.8562 22.197 23.8378 22.0546 23.8739 21.9211L25.0839 17.4466L14.4321 23.5658C14.3123 23.6346 14.1701 23.653 14.0368 23.617C13.9034 23.581 13.7899 23.4934 13.721 23.3736Z"
                                                    fill="#2D2C2B" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_292_208">
                                                    <rect width="16.6667" height="16.6667" fill="white"
                                                        transform="translate(8.6665 16.6667) rotate(-29.8763)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        @lang('index.get_started')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card second-feature-card">
                            <div class="feature-body row">
                                <div class="col-sm-5 d-flex gap-90 align-items-center">
                                    <div class="number">
                                        05
                                    </div>
                                    <div class="d-flex gap-30 align-items-center">
                                        <div class="icon">
                                            <img src="{{ featureSetting()[4]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[4]['icon']) : asset('assets/frontend/img/core-img/crm.svg') }}"
                                                alt="" class="icon-image">
                                        </div>
                                        <h5 class="">{{ featureSetting()[4]['title'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <p class="mb-0">
                                        {{ featureSetting()[4]['description'] }}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <div class="service-arrow">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.75 1.87639C19.1423 1.07254 20.8577 1.07254 22.25 1.87639L34.5705 8.98964C35.9628 9.79349 36.8205 11.2791 36.8205 12.8868V27.1132C36.8205 28.7209 35.9628 30.2065 34.5705 31.0104L22.25 38.1236C20.8577 38.9275 19.1423 38.9275 17.75 38.1236L5.42949 31.0104C4.03719 30.2065 3.17949 28.7209 3.17949 27.1132V12.8868C3.17949 11.2791 4.03719 9.79348 5.42949 8.98964L17.75 1.87639Z"
                                                stroke="#1E1D1D" />
                                            <g clip-path="url(#clip0_292_208)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.721 23.3736C13.6522 23.2539 13.6338 23.1117 13.6699 22.9783C13.7059 22.845 13.7934 22.7314 13.9132 22.6626L24.565 16.5434L20.0902 15.3348C19.9566 15.2987 19.8429 15.211 19.774 15.0911C19.7051 14.9712 19.6867 14.8288 19.7228 14.6953C19.7589 14.5617 19.8465 14.448 19.9665 14.3791C20.0864 14.3102 20.2288 14.2918 20.3623 14.3279L26.0507 15.8653C26.1169 15.8831 26.1789 15.9137 26.2332 15.9555C26.2875 15.9973 26.333 16.0494 26.3671 16.1088C26.4012 16.1682 26.4233 16.2338 26.4321 16.3017C26.4408 16.3697 26.4361 16.4387 26.4181 16.5048L24.8807 22.1932C24.8446 22.3268 24.757 22.4405 24.6371 22.5094C24.5171 22.5783 24.3747 22.5967 24.2412 22.5606C24.1077 22.5245 23.994 22.4369 23.9251 22.317C23.8562 22.197 23.8378 22.0546 23.8739 21.9211L25.0839 17.4466L14.4321 23.5658C14.3123 23.6346 14.1701 23.653 14.0368 23.617C13.9034 23.581 13.7899 23.4934 13.721 23.3736Z"
                                                    fill="#2D2C2B" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_292_208">
                                                    <rect width="16.6667" height="16.6667" fill="white"
                                                        transform="translate(8.6665 16.6667) rotate(-29.8763)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        @lang('index.get_started')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card second-feature-card">
                            <div class="feature-body row">
                                <div class="col-sm-5 d-flex gap-90 align-items-center">
                                    <div class="number">
                                        06
                                    </div>
                                    <div class="d-flex gap-30 align-items-center">
                                        <div class="icon">
                                            <img src="{{ featureSetting()[5]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[5]['icon']) : asset('assets/frontend/img/core-img/forum.svg') }}"
                                                alt="" class="icon-image">
                                        </div>
                                        <h5 class="">{{ featureSetting()[5]['title'] }}</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <p class="mb-0">
                                        {{ featureSetting()[5]['description'] }}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <div class="service-arrow">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.75 1.87639C19.1423 1.07254 20.8577 1.07254 22.25 1.87639L34.5705 8.98964C35.9628 9.79349 36.8205 11.2791 36.8205 12.8868V27.1132C36.8205 28.7209 35.9628 30.2065 34.5705 31.0104L22.25 38.1236C20.8577 38.9275 19.1423 38.9275 17.75 38.1236L5.42949 31.0104C4.03719 30.2065 3.17949 28.7209 3.17949 27.1132V12.8868C3.17949 11.2791 4.03719 9.79348 5.42949 8.98964L17.75 1.87639Z"
                                                stroke="#1E1D1D" />
                                            <g clip-path="url(#clip0_292_208)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.721 23.3736C13.6522 23.2539 13.6338 23.1117 13.6699 22.9783C13.7059 22.845 13.7934 22.7314 13.9132 22.6626L24.565 16.5434L20.0902 15.3348C19.9566 15.2987 19.8429 15.211 19.774 15.0911C19.7051 14.9712 19.6867 14.8288 19.7228 14.6953C19.7589 14.5617 19.8465 14.448 19.9665 14.3791C20.0864 14.3102 20.2288 14.2918 20.3623 14.3279L26.0507 15.8653C26.1169 15.8831 26.1789 15.9137 26.2332 15.9555C26.2875 15.9973 26.333 16.0494 26.3671 16.1088C26.4012 16.1682 26.4233 16.2338 26.4321 16.3017C26.4408 16.3697 26.4361 16.4387 26.4181 16.5048L24.8807 22.1932C24.8446 22.3268 24.757 22.4405 24.6371 22.5094C24.5171 22.5783 24.3747 22.5967 24.2412 22.5606C24.1077 22.5245 23.994 22.4369 23.9251 22.317C23.8562 22.197 23.8378 22.0546 23.8739 21.9211L25.0839 17.4466L14.4321 23.5658C14.3123 23.6346 14.1701 23.653 14.0368 23.617C13.9034 23.581 13.7899 23.4934 13.721 23.3736Z"
                                                    fill="#2D2C2B" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_292_208">
                                                    <rect width="16.6667" height="16.6667" fill="white"
                                                        transform="translate(8.6665 16.6667) rotate(-29.8763)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        @lang('index.get_started')
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Most Discussed Wrapper -->
    <div class="most-discussed-wrapper">
        <div class="most-discussed-wrapper-img">
            <img src="{{ asset('assets/frontend/img/new/most_discussed_bg.svg') }}" alt="">
        </div>
        <div class="container">
            <div class="row feature-section-flex">
                <div class="col-lg-4 justify-content-start">
                    <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                        @include('frontend.svg.star')
                        @lang('index.topic')
                    </p>
                    <h2 class="section-title">@lang('index.most_discussed_topic')</h2>
                    <a class="see_more d-none d-lg-block" href="{{ route('forum') }}">
                        @lang('index.see_more')<svg width="43" height="44" viewBox="0 0 43 44" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12.1345 31.461C11.9549 31.2891 11.8509 31.0529 11.8454 30.8043C11.8399 30.5557 11.9333 30.3151 12.1052 30.1355L27.3915 14.1584L19.0501 14.3441C18.8012 14.3496 18.5603 14.256 18.3805 14.0839C18.2006 13.9118 18.0964 13.6752 18.0909 13.4263C18.0854 13.1775 18.179 12.9366 18.3511 12.7567C18.5232 12.5768 18.7598 12.4727 19.0086 12.4672L29.6127 12.2328C29.7359 12.23 29.8586 12.2514 29.9735 12.296C30.0885 12.3406 30.1936 12.4075 30.2827 12.4927C30.3718 12.5779 30.4432 12.6799 30.4928 12.7928C30.5424 12.9057 30.5693 13.0273 30.5719 13.1506L30.8062 23.7546C30.8117 24.0035 30.7181 24.2444 30.546 24.4242C30.3739 24.6041 30.1373 24.7083 29.8884 24.7138C29.6395 24.7193 29.3987 24.6257 29.2188 24.4536C29.0389 24.2815 28.9348 24.0449 28.9293 23.7961L28.7463 15.4546L13.46 31.4317C13.2881 31.6113 13.0519 31.7154 12.8033 31.7209C12.5548 31.7263 12.3142 31.6329 12.1345 31.461Z"
                                fill="#2D2C2B" />
                        </svg>

                    </a>
                </div>

                <div class="col-lg-8 most-discussed-wrap" data-aos="fade-up" data-aos-duration="3000">
                    <div class="most-discussed-section">
                        @foreach ($most_discussed_topic->take(3) as $topic)
                            <div class="most-discussed-card">
                                <div class="most-discussed-body">
                                    <div class="left">
                                        <div class="icon">
                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="right_up">
                                            <a href="{{ route('forum-comment', $topic->slug) }}">
                                                <h5 class="">{{ $topic->subject }}</h5>
                                            </a>
                                            <p class="mb-0">
                                                {!! Str::limit($topic->description, 100, '[…]') !!}
                                            </p>
                                        </div>
                                        <div class="right_down">
                                            <div class="image">
                                                <img src="{{ asset('assets/frontend/img/second_home_page/av1.png') }}"
                                                    alt="">
                                                <img src="{{ asset('assets/frontend/img/second_home_page/av2.png') }}"
                                                    alt="">
                                                <img src="{{ asset('assets/frontend/img/second_home_page/av3.png') }}"
                                                    alt="">
                                                <img src="{{ asset('assets/frontend/img/second_home_page/av4.png') }}"
                                                    alt="">

                                                <img src="{{ asset('assets/frontend/img/second_home_page/av5.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="text">
                                                <p>{{ $topic->comments_count }} @lang('index.replies_in_this_topic'):</p>
                                                @php
                                                    $names = [];
                                                    foreach ($topic->lastFourReply as $reply) {
                                                        $names[] = $reply['comment_by'];
                                                    }
                                                    $commaSeparatedNames = implode(', ', $names);
                                                @endphp
                                                <p>@lang('index.written_by') {{ $commaSeparatedNames }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="knowledge-article" class="knowledge-article second-knowledge-article">
        <div class="container">
            <div class="row justify-content-between align-items-end">
                <div class="col-12 col-lg-8">
                    <div class="text-left">
                        <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                            @include('frontend.svg.star')
                            @lang('index.articles')
                        </p>
                        <h2 class="section-title text-left m-0">{{ sectionTitle()[1]['title'] }}</h2>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="javascript:void(0)" class="customPrevBtn">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1.61719 9.11719C1.12891 9.60547 1.12891 10.3984 1.61719 10.8867L7.86719 17.1367C8.35547 17.625 9.14844 17.625 9.63672 17.1367C10.125 16.6484 10.125 15.8555 9.63672 15.3672L5.51562 11.25H17.5C18.1914 11.25 18.75 10.6914 18.75 10C18.75 9.30859 18.1914 8.75 17.5 8.75H5.51953L9.63281 4.63281C10.1211 4.14453 10.1211 3.35156 9.63281 2.86328C9.14453 2.375 8.35156 2.375 7.86328 2.86328L1.61328 9.11328L1.61719 9.11719Z"
                                    fill="#2D2C2B" />
                            </svg>

                        </a>
                        <a href="javascript:void(0)" class="customNextBtn">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.3828 10.8828C18.8711 10.3945 18.8711 9.60156 18.3828 9.11328L12.1328 2.86328C11.6445 2.375 10.8516 2.375 10.3633 2.86328C9.875 3.35156 9.875 4.14453 10.3633 4.63281L14.4844 8.75H2.5C1.80859 8.75 1.25 9.30859 1.25 10C1.25 10.6914 1.80859 11.25 2.5 11.25H14.4805L10.3672 15.3672C9.87891 15.8555 9.87891 16.6484 10.3672 17.1367C10.8555 17.625 11.6484 17.625 12.1367 17.1367L18.3867 10.8867L18.3828 10.8828Z"
                                    fill="#2D2C2B" />
                            </svg>

                        </a>
                    </div>
                </div>
            </div>

            <!--Showing Selected Product Article List-->
            @foreach ($products as $product)
                @if ($loop->index == 0)
                    @if (count($product->article_groups) > 0)
                        <div class="{{ $loop->first ? 'documentation-active' : 'documentation-inactive' }}"
                            id="single_product_{{ $product->id }}" data-id="{{ $product->id }}"
                            data-slug="{{ $product->slug }}" data-aos="fade-up" data-aos-duration="3000">
                            <!-- TODO: Start Single Article Group-->
                            <div class="row justify-content-center justify-content-md-between">
                                <div class="owl-wrapper owl-carousel owl-theme" id="knowledge_base_carousal">
                                    @foreach ($product->article_groups as $group)
                                        <div class="knowledge-tem">
                                            <div class="knowledge-wrapper">
                                                <div class="knowledge-left">
                                                    <div class="icon_text">
                                                        <div class="img-wrap">
                                                            @if (isset($group->icon))
                                                                @php
                                                                    $icon = asset(
                                                                        'uploads/article_group/' . $group->icon,
                                                                    );
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $icon = asset('/uploads/article_group/default.png');
                                                                @endphp
                                                            @endif
                                                            <img loading="lazy" src="{{ $icon }}"
                                                                class="attachment-full size-full" alt=""
                                                                decoding="async">
                                                        </div>
                                                        <div class="title-wrapper">
                                                            <a href="{{ route('viewAll', $group->slug) }}">
                                                                <h4> {{ $group->title }} </h4>
                                                            </a>
                                                            <span class="text-muted">{{ count($group->articles) }}
                                                                Articles</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="knowledge-body">
                                                    <ul class="article-link-list">
                                                        @if (count($group->articles))
                                                            @foreach ($group->articles->take(5) as $article)
                                                                @if ($loop->index < 5)
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('article-details', [$product->slug, $article->title_slug]) }}">
                                                                            <img loading="lazy"
                                                                                src="{{ asset('/assets/frontend/img/core-img/doc.svg') }}"
                                                                                class="attachment-full size-full doc_img"
                                                                                alt="" decoding="async">
                                                                            <span
                                                                                class="text-truncated">{{ $article->title }}</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                <span class="alert alert-danger">
                                                                    @lang('index.no_article_found')
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                    @if (sizeof($group->articles) > 5)
                                                        <a href="{{ route('viewAll', $group->slug) }}"
                                                            class="article-view-link">
                                                            <span class="me-2">@lang('index.view_all')</span> <svg
                                                                width="44" height="30" viewBox="0 0 44 30"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M30.3536 15.3536C30.5488 15.1583 30.5488 14.8417 30.3536 14.6464L27.1716 11.4645C26.9763 11.2692 26.6597 11.2692 26.4645 11.4645C26.2692 11.6597 26.2692 11.9763 26.4645 12.1716L29.2929 15L26.4645 17.8284C26.2692 18.0237 26.2692 18.3403 26.4645 18.5355C26.6597 18.7308 26.9763 18.7308 27.1716 18.5355L30.3536 15.3536ZM-4.37114e-08 15.5L30 15.5L30 14.5L4.37114e-08 14.5L-4.37114e-08 15.5Z"
                                                                    fill="#1E1D1D" />
                                                                <circle cx="29" cy="15" r="14.5"
                                                                    stroke="black" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row justify-content-center knowledge-footer-btn">
                                <div class="col-12 d-flex justify-content-center">
                                    <a class="see_more" href="{{ route('product-wise-article-groups', $product->slug) }}">
                                        @lang('index.see_more')<svg width="43" height="44" viewBox="0 0 43 44"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12.1345 31.461C11.9549 31.2891 11.8509 31.0529 11.8454 30.8043C11.8399 30.5557 11.9333 30.3151 12.1052 30.1355L27.3915 14.1584L19.0501 14.3441C18.8012 14.3496 18.5603 14.256 18.3805 14.0839C18.2006 13.9118 18.0964 13.6752 18.0909 13.4263C18.0854 13.1775 18.179 12.9366 18.3511 12.7567C18.5232 12.5768 18.7598 12.4727 19.0086 12.4672L29.6127 12.2328C29.7359 12.23 29.8586 12.2514 29.9735 12.296C30.0885 12.3406 30.1936 12.4075 30.2827 12.4927C30.3718 12.5779 30.4432 12.6799 30.4928 12.7928C30.5424 12.9057 30.5693 13.0273 30.5719 13.1506L30.8062 23.7546C30.8117 24.0035 30.7181 24.2444 30.546 24.4242C30.3739 24.6041 30.1373 24.7083 29.8884 24.7138C29.6395 24.7193 29.3987 24.6257 29.2188 24.4536C29.0389 24.2815 28.9348 24.0449 28.9293 23.7961L28.7463 15.4546L13.46 31.4317C13.2881 31.6113 13.0519 31.7154 12.8033 31.7209C12.5548 31.7263 12.3142 31.6329 12.1345 31.461Z"
                                                fill="#2D2C2B" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="row justify-content-center g-4 mt-5 {{ $loop->first ? 'documentation-active' : 'documentation-inactive' }}"
                            id="no_article_sec_{{ $product->id }}" data-id="{{ $product->id }}" data-aos="fade-up"
                            data-aos-duration="3000">
                            <div class="col-12 col-md-6 no-article-found text-center mx-auto">
                                <img class="mx-auto d-block no-found-image"
                                    src="{{ asset('/assets/frontend/img/core-img/no_article.svg') }}"
                                    alt="data not found">
                                <h4>@lang('index.no_article_found')</h4>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </section>

    <!-- Testimonial -->
    <section class="testimonial-wrap second-testimonial-wrap">
        <div class="container">
            <div class="d-flex flex-column gap-30">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-12">
                        <div class="text-center">
                            <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                                @include('frontend.svg.star')
                                @lang('index.testimonial')
                            </p>
                            <h2 class="section-title text-center">@lang('index.what_says_valuable_user') <br>@lang('index.said_about_us')</h2>
                        </div>
                    </div>
                </div>
                <div class="testimonial_sec row">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-lg-4 item">
                            <div class="testimonial-content-bg">
                                <div class="below_section">
                                    @if ($testimonial->user_id != null)
                                        <img src="{{ asset($testimonial->user->image) }}" class="img-fluid avater_imag"
                                            alt="">
                                    @else
                                        <img src="{{ asset('assets/images/avator.jpg') }}" class="img-fluid avater_imag"
                                            alt="">
                                    @endif

                                    <div class="below_section_text">
                                        <p>{{ $testimonial->user->full_name }}</p>
                                        <div class="star">
                                            @for ($i = 1; $i <= $testimonial->rating; $i++)
                                                <img src="{{ asset('assets/frontend/img/second_home_page/star.svg') }}"
                                                    class="img-fluid" alt="">
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="quota_img">
                                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M39.5547 20.4891C39.4531 19.4 39.5305 16.4407 42.3656 12.325C42.4692 12.1747 42.5169 11.9928 42.5003 11.811C42.4837 11.6292 42.404 11.4589 42.275 11.3297C41.1188 10.1735 40.4031 9.44456 39.9016 8.9344C39.2414 8.26096 38.9406 7.95471 38.4992 7.55471C38.3574 7.42666 38.1735 7.35494 37.9824 7.35306C37.7913 7.35119 37.6061 7.41931 37.4617 7.54456C32.5196 11.8446 27.0313 20.7297 27.8258 31.6149C28.2906 38.0071 32.9531 42.6469 38.9117 42.6469C45.025 42.6469 49.9992 37.6735 49.9992 31.5594C49.9992 25.661 45.3711 20.8235 39.5547 20.4891ZM38.911 41.0844C33.7945 41.0844 29.7883 37.0547 29.3836 31.5024C28.4899 19.2586 35.768 11.3071 37.9664 9.20081C38.1805 9.41253 38.4258 9.66175 38.7867 10.0289C39.2211 10.4711 39.8164 11.0774 40.7164 11.9805C37.275 17.2828 37.9242 21.061 38.2086 21.6024C38.3438 21.8602 38.6211 22.0328 38.9117 22.0328C44.1641 22.0328 48.4367 26.3063 48.4367 31.5594C48.4367 36.811 44.1633 41.0844 38.911 41.0844ZM11.8078 20.4891C11.7063 19.4032 11.7805 16.4461 14.6188 12.325C14.7223 12.1747 14.77 11.9928 14.7534 11.811C14.7369 11.6292 14.6572 11.4589 14.5281 11.3297C13.3742 10.1758 12.6594 9.4469 12.1586 8.93753C11.4961 8.26253 11.1938 7.9555 10.7531 7.55471C10.6112 7.42686 10.4275 7.35521 10.2365 7.35319C10.0454 7.35118 9.86025 7.41895 9.71564 7.54378C4.77424 11.8438 -0.715607 20.7274 0.0773619 31.6157C0.544549 38.0071 5.20705 42.6469 11.1649 42.6469C17.2797 42.6469 22.2539 37.6735 22.2539 31.5594C22.2539 25.6602 17.6242 20.8219 11.8078 20.4891ZM11.1649 41.0844C6.05002 41.0844 2.04142 37.0547 1.63517 31.5016V31.5024C0.744549 19.2571 8.02189 11.3063 10.2211 9.20081C10.436 9.41253 10.682 9.66253 11.043 10.0313C11.4774 10.4735 12.0719 11.0782 12.9703 11.9805C9.52892 17.2836 10.1781 21.061 10.4625 21.6016C10.5977 21.8594 10.875 22.0328 11.1656 22.0328C16.418 22.0328 20.6914 26.3063 20.6914 31.5594C20.6914 36.811 16.418 41.0844 11.1649 41.0844Z"
                                                fill="black" fill-opacity="0.2" />
                                        </svg>

                                    </div>
                                </div>
                                <p class="second_home_testimonial_para">{{ $testimonial->review }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="faq-wrapper second-faq-wrapper" id="faq">
        <div class="container">
            <div class="faq-wrapper-flex second-wrapper-flex">
                <div class="row justify-content-start gap-md-30">
                    <div class="col-12 col-lg-4">
                        <div class="text-left">
                            <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                                @include('frontend.svg.star')
                                @lang('index.faqs')
                            </p>
                            <h2 class="section-title text-left">{{ sectionTitle()[2]['title'] }}</h2>
                            <div class="question_image d-none d-lg-block">
                                <svg width="300" height="300" viewBox="0 0 300 300" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_514_1019)">
                                        <path
                                            d="M139.323 300C124.587 300 112.597 287.526 112.597 272.194V261.04C112.597 245.708 124.585 233.234 139.321 233.234C154.057 233.234 166.047 245.709 166.047 261.04V272.194C166.048 287.526 154.058 300 139.323 300ZM139.323 242.986C129.963 242.986 122.349 251.085 122.349 261.039V272.194C122.349 282.148 129.963 290.247 139.322 290.247C148.681 290.247 156.295 282.148 156.295 272.194V261.039C156.296 251.085 148.682 242.986 139.323 242.986ZM151.537 214.437H151.508L131.401 214.316C126.95 214.862 122.439 213.506 118.962 210.564C115.23 207.406 113.038 202.753 112.946 197.793C112.495 173.439 121.299 153.634 139.113 138.929C141.321 137.106 143.612 135.283 146.038 133.354C163.68 119.319 183.677 103.412 180.591 80.5741C179.26 70.729 173.684 64.6825 169.241 61.344C162.2 56.0543 153.127 53.7723 144.355 55.076C131.768 56.9505 120.124 65.9691 112.412 79.815L112.337 79.9482C107.313 88.9568 96.3604 92.3371 87.4007 87.6454L73.5765 80.406C64.5547 75.6825 60.7639 64.4594 64.9459 54.856C73.396 35.4493 87.9227 20.0945 106.954 10.4523C124.441 1.59173 144.79 -1.79712 164.247 0.906987C203.181 6.32063 230.662 34.0589 235.966 73.296C239.955 102.798 228.771 129.419 202.729 152.416C199.665 155.123 196.488 157.701 193.416 160.194C179.84 171.213 168.115 180.729 166.357 198.9C165.583 206.896 159.785 213.262 152.256 214.383C152.018 214.419 151.778 214.437 151.537 214.437ZM149.213 44.9667C158.494 44.9667 167.665 47.9644 175.097 53.5477C183.481 59.8467 188.864 68.9807 190.253 79.2674C194.08 107.593 170.807 126.107 152.107 140.984C149.718 142.885 147.46 144.68 145.319 146.448C129.696 159.345 122.296 176.081 122.695 197.612C122.735 199.767 123.67 201.773 125.258 203.118C126.721 204.356 128.535 204.884 130.371 204.615C130.617 204.572 130.867 204.554 131.117 204.561L151.135 204.682C154.072 204.085 156.319 201.368 156.649 197.96C158.8 175.728 173.272 163.982 187.269 152.622C190.264 150.192 193.361 147.68 196.273 145.107C220.053 124.106 229.876 101.044 226.303 74.6012C221.539 39.361 197.839 15.4221 162.904 10.5639C132.01 6.27029 90.9692 19.5128 73.8847 58.7491C71.7709 63.6035 73.6609 69.444 78.0985 71.767L91.9235 79.0063C96.2349 81.2627 101.35 79.6276 103.821 75.2L103.893 75.0691C113.09 58.5586 127.316 47.7553 142.919 45.4307C145.003 45.1211 147.106 44.966 149.213 44.9667Z"
                                            fill="#F7F7F7" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_514_1019">
                                            <rect width="300" height="300" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="faq-content-list second-faq-content-list row" data-aos="fade-up"
                            data-aos-duration="3000">
                            @foreach ($faq as $key => $value)
                                <div class="col-lg-12">
                                    <div class="accordion" id="accordionFaq">
                                        <div
                                            class="accordion-item second-page-accordion-item {{ $loop->last ? 'border-none' : '' }}">
                                            <h2 class="accordion-header {{ $key == 0 ? 'margin-top-zero' : '' }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse_{{ $loop->index }}" aria-expanded="false"
                                                    aria-controls="collapse_{{ $loop->index }}">
                                                    {{ $value->question ?? '' }}
                                                </button>
                                            </h2>
                                            <div id="collapse_{{ $loop->index }}" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    {!! $value->answer ?? '' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Wrapper -->
    <div class="blog-wrapper second-blog-wrapper" id="blog">

        <div class="container">
            <div class="blog-wrapper-flex">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="text-center">
                            <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                                @include('frontend.svg.star')
                                @lang('index.blogs')
                            </p>
                            <h2 class="section-title">{{ sectionTitle()[3]['title'] }}</h2>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-duration="3000">
                    <div class="row justify-content-center justify-content-md-between second-blog-row">
                        @foreach ($blogs->take(4) as $blog)
                            <div
                                class="col-12 {{ $loop->index == 0 ? 'col-md-12 first_blog_item' : 'col-md-6 col-lg-4' }} second-blog-col">
                                <div class="card blog-card second-blog-card">
                                    <!-- Post Thumbnail -->
                                    <a class="post-thumbnail" href="{{ route('blog-details', $blog->slug) }}">
                                        <img class="w-100"
                                            src="{{ $blog->thumb_img == null ? asset($blog->image) : asset($blog->thumb_img) }}"
                                            alt="">
                                    </a>
                                    <!-- Blog Content -->
                                    <div class="blog-content second-blog-content">
                                        <div class="d-flex gap-15 align-items-center second_time_person">
                                            <span class="text-small time">
                                                {{ $blog->category->title }}
                                            </span>
                                            <svg width="30" height="2" viewBox="0 0 30 2" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <line y1="0.90625" x2="30" y2="0.90625" stroke="#727272" />
                                            </svg>

                                            <span class="text-small time">
                                                {{ date('M d, Y', strtotime($blog->created_at)) }}
                                            </span>
                                        </div>
                                        <a class="second-blog-title h4 my-2"
                                            href="{{ route('blog-details', $blog->slug) }}">
                                            {{ $blog->title ?? '' }}
                                        </a>
                                        @if ($loop->index == 0)
                                            <!-- strip_tags function used for removing html tag here. -->
                                            <p class="post-excerpt second-post-excerpt">
                                                {!! $blog->blog_content ? Strip_tags(Str::limit($blog->blog_content, 150)) : '' !!}
                                            </p>
                                        @endif

                                        <a href="{{ route('blog-details', $blog->slug) }}"
                                            class="second_blog_service_arrow">
                                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.75 1.87639C19.1423 1.07254 20.8577 1.07254 22.25 1.87639L34.5705 8.98964C35.9628 9.79349 36.8205 11.2791 36.8205 12.8868V27.1132C36.8205 28.7209 35.9628 30.2065 34.5705 31.0104L22.25 38.1236C20.8577 38.9275 19.1423 38.9275 17.75 38.1236L5.42949 31.0104C4.03719 30.2065 3.17949 28.7209 3.17949 27.1132V12.8868C3.17949 11.2791 4.03719 9.79348 5.42949 8.98964L17.75 1.87639Z"
                                                    stroke="#1E1D1D" />
                                                <g clip-path="url(#clip0_292_208)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M13.721 23.3736C13.6522 23.2539 13.6338 23.1117 13.6699 22.9783C13.7059 22.845 13.7934 22.7314 13.9132 22.6626L24.565 16.5434L20.0902 15.3348C19.9566 15.2987 19.8429 15.211 19.774 15.0911C19.7051 14.9712 19.6867 14.8288 19.7228 14.6953C19.7589 14.5617 19.8465 14.448 19.9665 14.3791C20.0864 14.3102 20.2288 14.2918 20.3623 14.3279L26.0507 15.8653C26.1169 15.8831 26.1789 15.9137 26.2332 15.9555C26.2875 15.9973 26.333 16.0494 26.3671 16.1088C26.4012 16.1682 26.4233 16.2338 26.4321 16.3017C26.4408 16.3697 26.4361 16.4387 26.4181 16.5048L24.8807 22.1932C24.8446 22.3268 24.757 22.4405 24.6371 22.5094C24.5171 22.5783 24.3747 22.5967 24.2412 22.5606C24.1077 22.5245 23.994 22.4369 23.9251 22.317C23.8562 22.197 23.8378 22.0546 23.8739 21.9211L25.0839 17.4466L14.4321 23.5658C14.3123 23.6346 14.1701 23.653 14.0368 23.617C13.9034 23.581 13.7899 23.4934 13.721 23.3736Z"
                                                        fill="#2D2C2B" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_292_208">
                                                        <rect width="16.6667" height="16.6667" fill="white"
                                                            transform="translate(8.6665 16.6667) rotate(-29.8763)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            @lang('index.read_more')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Wrapper -->
    <div class="second-contact-wrapper">
        <div class="container contact_page" data-aos="fade-up" data-aos-duration="3000">
            <div class="d-flex contact_page_top">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-6 form_section">
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="d-flex flex-column gap-10 align-items-start">
                                    <p class="text-uppercase text-secondary section_header text-size-20">
                                        @include('frontend.svg.star')
                                        @lang('index.contact_us')
                                    </p>
                                    <h4 class="section-title text-left m-0">@lang('index.get_in_touch_with_us')</h4>
                                    <p class="section-subtitle text-left">@lang('index.contact_us_quote')</p>
                                </div>
                            </div>
                        </div>
                        <div class="card p-0">
                            <div class="card-body p-0">
                                <form action="{{ route('store-message') }}" id="formContact" method="POST"
                                    class="form_contact">
                                    @csrf
                                    <div class="row contact-form">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group form_contact_group_name">
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name') }}"
                                                    class="form-control contact_name @error('name') is-invalid @enderror"
                                                    placeholder="@lang('index.full_name')">
                                                <span class="text-danger contact_name_r required_symbol">*</span>
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group form_contact_group_email">
                                                <input type="email" value="{{ old('email') }}" name="email"
                                                    id="email"
                                                    class="form-control contact_email @error('email') is-invalid @enderror"
                                                    placeholder="@lang('index.email')">
                                                <span class="text-danger contact_email_r required_symbol">*</span>
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <div class="form-group form_contact_group_subject">
                                                <input type="text" value="{{ old('subject') }}" name="subject"
                                                    id="subject"
                                                    class="form-control contact_subject @error('subject') is-invalid @enderror"
                                                    placeholder="@lang('index.subject')">
                                                <span class="text-danger contact_subject_r required_symbol">*</span>
                                                @error('subject')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea name="message" class="form-control contact-message @error('message') is-invalid @enderror"
                                                    placeholder="@lang('index.type_your_message_here')" id="message" name="message" cols="30" rows="20" maxlength="1000"></textarea>
                                                @error('message')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
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
                                                    <span id="captcha-error"
                                                        class="text-danger d-none">@lang('index.invalid_captcha_code')</span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <button class="gt-btn send_message_btn comment-submit-button" type="submit">
                                                @lang('index.send_msg')
                                                <span class="icon">
                                                    <svg width="14" height="15" viewBox="0 0 14 15"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12.545 1.40324L10.4939 12.695C10.4649 12.9031 10.3694 13.0963 10.2218 13.2457C10.0741 13.3952 9.88214 13.493 9.67442 13.5245C9.4667 13.5561 9.25435 13.5198 9.06896 13.4209C8.88357 13.322 8.73505 13.166 8.64551 12.9759L6.39267 8.24091C6.38365 8.22375 6.37131 8.20854 6.35638 8.19618C6.34145 8.18381 6.32421 8.17453 6.30567 8.16886L1.37227 6.92424C1.17401 6.87371 0.995994 6.76365 0.862173 6.60889C0.728352 6.45413 0.645151 6.26209 0.623768 6.05861L0.620648 6.03291C0.596232 5.82634 0.637613 5.61733 0.738897 5.43565C0.840183 5.25396 0.996208 5.10887 1.18476 5.02102L11.1587 0.297653C11.3186 0.22318 11.4957 0.193633 11.671 0.212179C11.8464 0.230725 12.0133 0.296667 12.1541 0.402927C12.3063 0.516355 12.4237 0.670247 12.4928 0.847091C12.5619 1.02393 12.58 1.21663 12.545 1.40324Z"
                                                            fill="#5065E2" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                        @if (Session::has('message'))
                                            <div class="col-12">
                                                <div
                                                    class="alert alert-{{ Session::get('type') ?? 'info' }} alert-dismissible fade show">
                                                    <div class="alert-body">
                                                        <span><i class="m-right bi bi-check"></i>
                                                            {{ Session::get('message') }}</span>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 contact_info">
                        <div class="row g-4">
                            <div class="col-12 col-sm-12 col-lg-12 col-xl-12 inside_contact">
                                <div class="section_wrapper">
                                    <div class="header">
                                        <h4>@lang('index.address')</h4>
                                    </div>
                                    <div class="body">
                                        <div class="content d-flex align-items-baseline">
                                            <p> {{ siteSetting()->address ?? '' }}</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="section_wrapper">
                                    <div class="header">
                                        <h4>@lang('index.contact')</h4>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <a href="tel:{{ siteSetting()->phone ?? '' }}">@lang('index.phone'):
                                                &nbsp;{{ siteSetting()->phone ?? '' }}</a>
                                        </div>
                                        <div class="content">
                                            <a
                                                href="mailto:{{ siteSetting()->email ?? '' }}">@lang('index.email'):&nbsp;{{ siteSetting()->email ?? '' }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="section_wrapper">
                                    <div class="header">
                                        <h4>@lang('index.office_time')</h4>
                                    </div>
                                    <div class="body">
                                        <div class="content d-flex align-items-baseline">
                                            <i class="bi bi-clock"></i>
                                            <p>
                                                @foreach (chatSchedules() ?? [] as $schedule)
                                                    @if ($loop->first)
                                                        {{ $schedule }} -
                                                    @endif
                                                    @if ($loop->last)
                                                        {{ $schedule }}
                                                    @endif
                                                @endforeach
                                                :&nbsp;
                                                <span>{{ chatScheduleTime()['start_time'] . ' - ' . chatScheduleTime()['end_time'] }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="section_wrapper">
                                    <div class="body">
                                        <div class="content d-flex align-items-baseline">
                                            <div class="social-icons-off-canvas social_icons_footer">
                                                <a target="_blank" href="{{ siteSetting()->facebook_url ?? '#' }}">
                                                    <svg width="16" height="17" viewBox="0 0 16 17"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_519_1034)">
                                                            <path
                                                                d="M5.0625 9.56016V16.207H8.6875V9.56016H11.3906L11.9531 6.50391H8.6875V5.42266C8.6875 3.80703 9.32188 3.18828 10.9594 3.18828C11.4688 3.18828 11.8781 3.20078 12.1156 3.22578V0.453906C11.6688 0.332031 10.575 0.207031 9.94375 0.207031C6.60312 0.207031 5.0625 1.78516 5.0625 5.18828V6.50391H3V9.56016H5.0625Z"
                                                                fill="#2D2C2B" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_519_1034">
                                                                <rect width="16" height="16" fill="white"
                                                                    transform="translate(0 0.207031)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </a>
                                                <a target="_blank" href="{{ siteSetting()->twitter_url ?? '#' }}">
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14.3553 5.23856C14.3655 5.38069 14.3655 5.52284 14.3655 5.66497C14.3655 9.99997 11.066 14.9949 5.03553 14.9949C3.17766 14.9949 1.45178 14.4568 0 13.5228C0.263969 13.5533 0.51775 13.5634 0.791875 13.5634C2.32484 13.5634 3.73603 13.0457 4.86294 12.1624C3.42131 12.132 2.21319 11.1878 1.79694 9.88831C2 9.91875 2.20303 9.93906 2.41625 9.93906C2.71066 9.93906 3.00509 9.89844 3.27919 9.82741C1.77666 9.52281 0.649719 8.20303 0.649719 6.60913V6.56853C1.08625 6.81219 1.59391 6.96447 2.13194 6.98475C1.24869 6.39591 0.670031 5.39084 0.670031 4.25378C0.670031 3.64466 0.832437 3.08628 1.11672 2.59897C2.73094 4.58881 5.15734 5.88828 7.87812 6.03044C7.82737 5.78678 7.79691 5.533 7.79691 5.27919C7.79691 3.47206 9.25884 2 11.0761 2C12.0202 2 12.873 2.39594 13.472 3.03553C14.2131 2.89341 14.9238 2.61928 15.5532 2.24366C15.3096 3.00509 14.7918 3.64469 14.1116 4.05075C14.7715 3.97972 15.4111 3.79694 15.9999 3.54316C15.5533 4.19287 14.9949 4.77153 14.3553 5.23856Z"
                                                            fill="#2D2C2B" />
                                                    </svg>
                                                </a>
                                                <a target="_blank" href="{{ siteSetting()->instagram_url ?? '#' }}">
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_93_172)">
                                                            <path
                                                                d="M0 1.146C0 0.513 0.526 0 1.175 0H14.825C15.474 0 16 0.513 16 1.146V14.854C16 15.487 15.474 16 14.825 16H1.175C0.526 16 0 15.487 0 14.854V1.146ZM4.943 13.394V6.169H2.542V13.394H4.943ZM3.743 5.182C4.58 5.182 5.101 4.628 5.101 3.934C5.086 3.225 4.581 2.686 3.759 2.686C2.937 2.686 2.4 3.226 2.4 3.934C2.4 4.628 2.921 5.182 3.727 5.182H3.743ZM8.651 13.394V9.359C8.651 9.143 8.667 8.927 8.731 8.773C8.904 8.342 9.299 7.895 9.963 7.895C10.832 7.895 11.179 8.557 11.179 9.529V13.394H13.58V9.25C13.58 7.03 12.396 5.998 10.816 5.998C9.542 5.998 8.971 6.698 8.651 7.191V7.216H8.635L8.651 7.191V6.169H6.251C6.281 6.847 6.251 13.394 6.251 13.394H8.651Z"
                                                                fill="#2D2C2B" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_93_172">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </a>
                                                <a target="_blank" href="{{ siteSetting()->dribble_url ?? '#' }}">
                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M8.375 0.203125C5.16875 0.203125 2 2.34063 2 5.8C2 8 3.2375 9.25 3.9875 9.25C4.29688 9.25 4.475 8.3875 4.475 8.14375C4.475 7.85313 3.73438 7.23438 3.73438 6.025C3.73438 3.5125 5.64687 1.73125 8.12187 1.73125C10.25 1.73125 11.825 2.94063 11.825 5.1625C11.825 6.82188 11.1594 9.93438 9.00313 9.93438C8.225 9.93438 7.55937 9.37188 7.55937 8.56563C7.55937 7.38438 8.38438 6.24063 8.38438 5.02188C8.38438 2.95313 5.45 3.32813 5.45 5.82813C5.45 6.35313 5.51562 6.93438 5.75 7.4125C5.31875 9.26875 4.4375 12.0344 4.4375 13.9469C4.4375 14.5375 4.52187 15.1188 4.57812 15.7094C4.68438 15.8281 4.63125 15.8156 4.79375 15.7563C6.36875 13.6 6.3125 13.1781 7.025 10.3563C7.40938 11.0875 8.40313 11.4813 9.19063 11.4813C12.5094 11.4813 14 8.24688 14 5.33125C14 2.22813 11.3188 0.203125 8.375 0.203125Z"
                                                            fill="#2D2C2B" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Wrapper -->
    <div class="second-cta-wrapper">
        <div class="container">
            <div class="wrapper position-relative">
                <div class="img_sec">
                    <img src="{{ asset('assets/frontend/img/new/cta_img.svg') }}" alt="">
                </div>
                <div class="row">
                    <div class="col-xl-6 col-12 d-flex flex-column gap-20">
                        <span>@lang('index.ready_to_drive_in')</span>
                        <h3>@lang('index.cta_title')</h3>
                        <p>@lang('index.cta_description')</p>
                        <ul>
                            <li><i class="bi bi-check2"></i>@lang('index.fast_response')</li>
                            <li><i class="bi bi-check2"></i>@lang('index.experienced_team')</li>
                            <li><i class="bi bi-check2"></i>@lang('index.efficient_ticketing_system')</li>
                        </ul>
                        <a href="{{ route('open-ticket') }}" class="open_ticket-btn">
                            @lang('index.open_ticket')
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="15" cy="15" r="15" fill="#5065E2" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8 15.0001C8 14.8675 8.05268 14.7404 8.14645 14.6466C8.24021 14.5528 8.36739 14.5001 8.5 14.5001H20.293L17.146 11.3541C17.0521 11.2603 16.9994 11.1329 16.9994 11.0001C16.9994 10.8674 17.0521 10.74 17.146 10.6461C17.2399 10.5523 17.3672 10.4995 17.5 10.4995C17.6328 10.4995 17.7601 10.5523 17.854 10.6461L21.854 14.6461C21.9006 14.6926 21.9375 14.7478 21.9627 14.8085C21.9879 14.8693 22.0009 14.9344 22.0009 15.0001C22.0009 15.0659 21.9879 15.131 21.9627 15.1918C21.9375 15.2525 21.9006 15.3077 21.854 15.3541L17.854 19.3541C17.7601 19.448 17.6328 19.5008 17.5 19.5008C17.3672 19.5008 17.2399 19.448 17.146 19.3541C17.0521 19.2603 16.9994 19.1329 16.9994 19.0001C16.9994 18.8674 17.0521 18.74 17.146 18.6461L20.293 15.5001H8.5C8.36739 15.5001 8.24021 15.4475 8.14645 15.3537C8.05268 15.2599 8 15.1328 8 15.0001Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </div>
                    <div class="col-xl-6 col-12">
                        <img src="{{ asset('assets/frontend/img/new-img/cta_image.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/jquery-captcha/jquery-captcha.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/contact.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/home_page.js') }}"></script>
@endpush
