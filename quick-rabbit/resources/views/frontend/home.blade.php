@extends('frontend.app')
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
    <div class="hero-area" id="hero">
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
        <div class="image-1" loading="lazy">
            <img src="{{ asset('assets/frontend/img/new/Effect.svg') }}" alt="">
        </div>
        <div class="image-2" loading="lazy">
            <img src="{{ asset('assets/frontend/img/new/Stars.svg') }}" alt="">
        </div>
        <div class="container">
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
                                {{ siteSetting()->banner_text ?? 'Hello! what can we help you find?' }}
                            </h2>
                        </div>
                        <div>
                            <!-- Card -->
                            <div class="search-area hero_section_search_area search_area_unique">
                                <form class="top-search-form" action="#">
                                    <div class="row input-box m-0">
                                        <div class="col-12 col-lg-8">
                                            <div class="row gap-0">
                                                <div class="col-md-5 col-lg-3 col-xl-3 col-xs-5 col-12 p-0">
                                                    <select id="heroSelect" class="hero-form-select product_category_id"
                                                        aria-label="Default select example">
                                                        <option value="">@lang('index.all_product_category')</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-7 col-lg-9 col-xl-9 col-xs-7 col-12 p-0">
                                                    <input type="text" id="searchInputModal"
                                                        class="form-control input-focused search-key top-search-form-input"
                                                        placeholder="@lang('index.search')... e:g license uninstall">
                                                    <div class="search-icon" id="search-icon">
                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
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
                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="feature-section-main">
        <div class="feature-section-bg1">
            <img loading="lazy" src="{{ asset('assets/frontend/img/new/cf1.svg') }}" alt="">
        </div>
        <div class="feature-section-bg2">
            <img loading="lazy" src="{{ asset('assets/frontend/img/new/cf2.svg') }}" alt="">
        </div>
        <div class="container">
            <div class="feature-section-flex">
                <div class="text-center">
                    <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                        @include('frontend.svg.star')
                        @lang('index.core_feature')
                    </p>
                    <h2 class="section-title">{!! sectionTitleSplit(sectionTitle()[0]['title']) !!}</h2>
                </div>

                <div class="feature-section-wrap feature-section-wrap-big-screen">
                    <div class="feature-section">
                        <div class="feature-card" data-aos="fade-up">
                            <div class="feature-body">
                                <div class="icon">
                                    <img loading="lazy"
                                        src="{{ featureSetting()[0]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[0]['icon']) : asset('assets/frontend/img/core-img/ai_powered.svg') }}"
                                        alt="" class="icon-image">
                                </div>
                                <div class="content">
                                    <h5 class="">{{ featureSetting()[0]['title'] }}</h5>
                                    <p class="mb-0">
                                        {{ featureSetting()[0]['description'] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="feature-card" data-aos="fade-up">
                            <div class="feature-body">
                                <div class="icon">
                                    <img loading="lazy"
                                        src="{{ featureSetting()[1]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[1]['icon']) : asset('assets/frontend/img/core-img/knowledgebase.svg') }}"
                                        alt="" class="icon-image">
                                </div>
                                <div class="content">
                                    <h5 class="">{{ featureSetting()[1]['title'] }}</h5>
                                    <p class="mb-0">{{ featureSetting()[1]['description'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="feature-card" data-aos="fade-up">
                            <div class="feature-body">
                                <div class="icon">
                                    <img loading="lazy"
                                        src="{{ featureSetting()[2]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[2]['icon']) : asset('assets/frontend/img/core-img/support.svg') }}"
                                        alt="" class="icon-image">
                                </div>
                                <div class="content">
                                    <h5 class="">{{ featureSetting()[2]['title'] }}</h5>
                                    <p class="mb-0">{{ featureSetting()[2]['description'] }}</p>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="feature-section">
                        <div class="feature-card" data-aos="fade-up">
                            <div class="feature-body">
                                <div class="icon">
                                    <img loading="lazy"
                                        src="{{ featureSetting()[3]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[3]['icon']) : asset('assets/frontend/img/core-img/live_chat.svg') }}"
                                        alt="" class="icon-image">
                                </div>
                                <div class="content">
                                    <h5 class="">{{ featureSetting()[3]['title'] }}</h5>
                                    <p class="mb-0">{{ featureSetting()[3]['description'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="feature-card" data-aos="fade-up">
                            <div class="feature-body">
                                <div class="icon">
                                    <img loading="lazy"
                                        src="{{ featureSetting()[4]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[4]['icon']) : asset('assets/frontend/img/core-img/crm.svg') }}"
                                        alt="" class="icon-image">
                                </div>
                                <div class="content">
                                    <h5 class="">{{ featureSetting()[4]['title'] }}</h5>
                                    <p class="mb-0">{{ featureSetting()[4]['description'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="feature-card" data-aos="fade-up">
                            <div class="feature-body">
                                <div class="icon">
                                    <img loading="lazy"
                                        src="{{ featureSetting()[5]['icon'] != '' ? asset('uploads/settings/' . featureSetting()[5]['icon']) : asset('assets/frontend/img/core-img/forum.svg') }}"
                                        alt="" class="icon-image">
                                </div>
                                <div class="content">
                                    <h5 class="">{{ featureSetting()[5]['title'] }}</h5>
                                    <p class="mb-0">{{ featureSetting()[5]['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('frontend.__responsive_feature')
            </div>
        </div>
    </div>

    <section id="knowledge-article" class="knowledge-article">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="text-center">
                        <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                            @include('frontend.svg.star')

                            @lang('index.articles')

                        </p>
                        <h2 class="section-title">{{ sectionTitle()[1]['title'] }}</h2>
                    </div>
                </div>
            </div>

            <section class="center slider">
                @foreach ($products as $product)
                    <a href="#" class="product-card-link" data-id="{{ $product->id }}">
                        <div class="product-card">
                            <div class="image-wrapper">
                                <img alt="{{ $product->title ?? '' }}" src="{{ asset($product->photo_thumb) }}" />
                                <div class="light-shadow"></div>
                            </div>
                            <div class="inner-card">
                                <h2>
                                    {{ $product->title ?? '' }}
                                </h2>
                                <p>
                                    {{ substr($product->short_description ?? '', 0, 32) }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </section>
            <!--Showing Selected Product Article List-->
            @foreach ($products as $product)
                @if (count($product->article_groups) > 0)
                    <div class="{{ $loop->first ? 'documentation-active' : 'documentation-inactive' }}"
                        id="single_product_{{ $product->id }}" data-id="{{ $product->id }}"
                        data-slug="{{ $product->slug }}">
                        <div class="row">
                            <!-- TODO: Start Single Article Group-->
                            <div class="col-lg-12 col-md-12 col-12 right-wrapper">
                                <div class="row g-5">
                                    @foreach ($product->article_groups->take(3) as $group)
                                        @if ($loop->index < 6)
                                            <div class="col-md-6 col-lg-4 col-sm-12 col-12">
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
                                                                            $icon = asset(
                                                                                '/uploads/article_group/default.png',
                                                                            );
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
                                            </div>
                                            <!-- TODO: End Single Article Group-->
                                        @endif
                                    @endforeach
                                </div>

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
                        id="no_article_sec_{{ $product->id }}" data-id="{{ $product->id }}" data-aos="fade-up">
                        <div class="col-12 col-md-6 no-article-found text-center mx-auto">
                            <img loading="lazy" class="mx-auto d-block no-found-image"
                                src="{{ asset('/assets/frontend/img/core-img/no_article.svg') }}" alt="data not found">
                            <h4>@lang('index.no_article_found')</h4>
                        </div>
                    </div>
                @endif
                @if (appMode() == 'demo' && $loop->index > 3)
                @break
            @endif
        @endforeach
    </div>
</section>
<div class="video-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="text-center">
                    <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                        @include('frontend.svg.star')

                        @lang('index.video_articles')

                    </p>
                    <h2 class="section-title">
                        Watch Our Video Guides Here
                    </h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center video-row">
            @if (isset($videoArticles->first()[0]->video_thumbnail))
                <div class="col-xl-7 image-wrapper">
                    <img src="{{ asset('uploads/article_videos/' . $videoArticles->first()[0]->video_thumbnail) }}"
                        class="img-fluid video_image" alt="">
                    <div class="overlay_video"></div>
                    <div class="video-btn">
                        <a href="{{ asset('uploads/article_videos/' . $videoArticles->first()[0]->video_link) }}"
                            class="video-btn ripple video-popup">
                            <div class="inner_circle">
                                <svg width="70" height="70" viewBox="0 0 70 70" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M50.7325 38.0494L22.8944 54.2019C20.5319 55.5713 17.5 53.9132 17.5 51.1526V18.8476C17.5 16.0913 20.5275 14.4288 22.8944 15.8026L50.7325 31.9551C51.2699 32.2618 51.7166 32.7053 52.0273 33.2405C52.3381 33.7756 52.5017 34.3834 52.5017 35.0022C52.5017 35.6211 52.3381 36.2289 52.0273 36.764C51.7166 37.2992 51.2699 37.7426 50.7325 38.0494Z"
                                        fill="#5065E2" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
            <div class="col-xl-4">
                <h3>@lang('index.product_video_list')</h3>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($videoArticles as $key => $varticle)
                        <div class="accordion-item {{ $loop->first ? 'active' : '' }}">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush_{{ $key }}"
                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                    {{ getArticleGroupById($key)->title }} <span
                                        class="count">({{ str_pad(count($varticle), 2, '0', STR_PAD_LEFT) }})</span>
                                </button>
                            </h2>
                            <div id="flush_{{ $key }}"
                                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul class="sub_menu">
                                        @foreach ($varticle as $item)
                                            <li class="{{ $loop->first ? 'active_item' : '' }}"><svg width="16"
                                                    height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M10.804 7.99995L5 4.63295V11.3669L10.804 7.99995ZM11.596 7.30395C11.7186 7.37414 11.8205 7.47547 11.8913 7.59769C11.9622 7.71991 11.9995 7.85868 11.9995 7.99995C11.9995 8.14122 11.9622 8.27999 11.8913 8.40221C11.8205 8.52442 11.7186 8.62576 11.596 8.69595L5.233 12.3879C4.713 12.6899 4 12.3449 4 11.6919V4.30795C4 3.65495 4.713 3.30995 5.233 3.61195L11.596 7.30395Z"
                                                        fill="black" />
                                                </svg>
                                                <a href="javascript:void()" class="video_title"
                                                    data-link="{{ $item->video_link }}"
                                                    data-img="{{ $item->video_thumbnail }}">{{ $item->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial Wrapper -->
<div class="blog-wrapper testimonials-wrapper" id="blog">
    <div class="container blog-wrapper-flex">
        <div class="row justify-content-between align-items-end">
            <div class="col-12 col-md-8">
                <div class="text-left">
                    <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                        @include('frontend.svg.star')
                        @lang('index.testimonials')
                    </p>
                    <h2 class="section-title text-left m-0">@lang('index.what_says_valuable_user') <br>@lang('index.said_about_us')</h2>
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
    </div>
    <div class="testimonials-content">
        <div>
            <div class="row justify-content-center justify-content-md-between">
                <div class="owl-wrapper owl-carousel owl-theme" id="testimonial_carousel">
                    @foreach ($testimonials as $testimonial)
                        <div class="blog-col">
                            <div class="card blog-card">
                                <!-- Blog Content -->
                                <div class="blog-content">
                                    <div class="below_section_review_star">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 5V35L15 20V5H0ZM25 5V35L40 20V5H25Z" fill="#7F7F7F" />
                                        </svg>
                                        <p class="below_section_review">{{ $testimonial->review }}</p>
                                    </div>
                                    <hr class="below_section_hr">
                                    <div class="below_section">
                                        <div class="below_section_img">
                                            @if ($testimonial->user_id != null)
                                                <img src="{{ asset($testimonial->user->image) }}"
                                                    class="img-fluid avater_imag" alt="">
                                            @else
                                                <img src="{{ asset('assets/images/avator.jpg') }}"
                                                    class="img-fluid avater_imag" alt="">
                                            @endif
                                            <div class="below_section_name_designation">
                                                <p class="m-0 below_section_name">{{ $testimonial->user->full_name }}
                                                </p>
                                                <span class="below_section_designation">CEO & Founder</span>
                                            </div>
                                        </div>
                                        <div class="below_section_star">
                                            <div class="star">
                                                <svg width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_60_260)">
                                                        <path
                                                            d="M3.612 15.443C3.226 15.641 2.788 15.294 2.866 14.851L3.696 10.121L0.172996 6.76501C-0.156004 6.45101 0.0149962 5.87701 0.455996 5.81501L5.354 5.11901L7.538 0.792012C7.735 0.402012 8.268 0.402012 8.465 0.792012L10.649 5.11901L15.547 5.81501C15.988 5.87701 16.159 6.45101 15.829 6.76501L12.307 10.121L13.137 14.851C13.215 15.294 12.777 15.641 12.391 15.443L8 13.187L3.612 15.443Z"
                                                            fill="#DCF000" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_60_260">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                <span class="star_rating">
                                                    {{ $testimonial->rating }}
                                                </span>
                                            </div>
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

<div class="faq-wrapper" id="faq">
    <div class="container">
        <div class="faq-wrapper-flex">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-12">
                    <div class="text-center pl20">
                        <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                            @include('frontend.svg.star')
                            @lang('index.faqs')
                        </p>
                        <h2 class="section-title">{!! sectionTitleSplit(sectionTitle()[2]['title']) !!}</h2>
                    </div>
                </div>
            </div>

            <div class="faq-content-list row">
                <div class="faq-content-list row">
                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab"
                                data-bs-target="#all" type="button" role="tab" aria-controls="home"
                                aria-selected="true">All</button>
                        </li>
                        @foreach ($products as $product)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab_link_{{ $product->id }}" data-bs-toggle="tab"
                                    data-bs-target="#tab_{{ $product->id }}" type="button" role="tab"
                                    aria-controls="profile" aria-selected="false">{{ $product->title }}</button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="faq_content">
                                @foreach ($faq as $key => $value)
                                    <div class="col-lg-12 mb-3 d-flex justify-content-center">
                                        <div class="accordion" id="accordionFaq">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button
                                                        class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse_{{ $loop->index }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse_{{ $loop->index }}">
                                                        {{ $value->question ?? '' }}
                                                    </button>
                                                </h2>
                                                <div id="collapse_{{ $loop->index }}"
                                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
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
                        @foreach ($products as $product)
                            <div class="tab-pane fade" id="tab_{{ $product->id }}" role="tabpanel"
                                aria-labelledby="profile-tab">
                                @php
                                    $faq = App\Model\Faq::live()
                                        ->where('product_category_id', $product->id)
                                        ->latest('id')
                                        ->get();
                                @endphp
                                <div class="faq_content">
                                    @if (count($faq) > 0)
                                        @foreach ($faq as $key => $value)
                                            <div class="col-lg-12 mb-3 d-flex justify-content-center">
                                                <div class="accordion" id="accordionFaq">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_{{ $loop->index }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse_{{ $loop->index }}">
                                                                {{ $value->question ?? '' }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse_{{ $loop->index }}"
                                                            class="accordion-collapse collapse"
                                                            data-bs-parent="#accordionFaq">
                                                            <div class="accordion-body">
                                                                {!! $value->answer ?? '' !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row justify-content-center g-4 mt-5" id="no_article_sec"
                                            data-aos="fade-up">
                                            <div class="col-12 col-md-6 no-article-found text-center mx-auto">
                                                <img loading="lazy" class="mx-auto d-block no-found-image"
                                                    src="{{ asset('/assets/frontend/img/core-img/no_article.svg') }}"
                                                    alt="data not found">
                                                <h4>@lang('index.no_faq_found')</h4>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Help Wrapper -->
<section class="cta-area mt-n150 mb-n116">
    <div class="container d-flex justify-content-center">
        <div class="cta-wrap style1">
            <div class="row">
                <div class="col-lg-4">
                    @include('frontend.svg.cta')
                </div>
                <div class="col-lg-8">
                    <h4>Join Our Newsletter</h4>
                    <p>Get the latest articles, freebies, jobs and special offers delivered directly to your
                        inbox.</p>
                    <div class="subscribe-form">
                        <form action="#" method="post" class="offcanvas-body-form subscribe_form">
                            <input type="text" class="form-control email_subscribe"
                                placeholder="@lang('index.enter_your_email')" aria-label="Enter your email">
                            <button class="gt-btn" type="submit"><svg width="20" height="20"
                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_69_106)">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M14.3159 5.69288L7.71814 10.2753L0.817145 7.97383C0.335444 7.81288 0.0109179 7.36078 0.0136895 6.85287C0.0164975 6.34496 0.344743 5.89563 0.828304 5.7403L18.4718 0.0565164C18.8912 -0.0783506 19.3515 0.0323301 19.6631 0.34398C19.9746 0.655629 20.0852 1.11608 19.9504 1.53564L14.2685 19.1851C14.1133 19.6688 13.6641 19.9972 13.1563 20C12.6486 20.0028 12.1967 19.6781 12.0358 19.1963L9.72398 12.2595L14.3159 5.69288Z"
                                            fill="white" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_69_106">
                                            <rect width="19.9932" height="20" fill="white"
                                                transform="translate(0.0136719)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Wrapper -->
<div class="blog-wrapper" id="blog">
    <div class="blog1">
        <img src="{{ asset('assets/frontend/img/new/b1.svg') }}" alt="">
    </div>
    <div class="blog2">
        <img src="{{ asset('assets/frontend/img/new/b2.svg') }}" alt="">
    </div>
    <div class="container blog-wrapper-flex">
        <div class="row justify-content-between align-items-end">
            <div class="col-12 col-md-8">
                <div class="text-left">
                    <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                        @include('frontend.svg.star')
                        @lang('index.blogs')
                    </p>
                    <h2 class="section-title text-left m-0">{!! sectionTitleSplit(sectionTitle()[3]['title']) !!}</h2>
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

        <div>
            <div class="row justify-content-center justify-content-md-between">
                <div class="owl-wrapper owl-carousel owl-theme" id="blog_carousel">
                    @foreach ($blogs as $blog)
                        <div class="blog-col">
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
            </div>
            <div class="row justify-content-center knowledge-footer-btn">
                <div class="col-12 d-flex justify-content-center">
                    <a class="see_more" href="{{ route('blogs') }}">
                        @lang('index.see_more')<svg width="43" height="44" viewBox="0 0 43 44" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12.1345 31.461C11.9549 31.2891 11.8509 31.0529 11.8454 30.8043C11.8399 30.5557 11.9333 30.3151 12.1052 30.1355L27.3915 14.1584L19.0501 14.3441C18.8012 14.3496 18.5603 14.256 18.3805 14.0839C18.2006 13.9118 18.0964 13.6752 18.0909 13.4263C18.0854 13.1775 18.179 12.9366 18.3511 12.7567C18.5232 12.5768 18.7598 12.4727 19.0086 12.4672L29.6127 12.2328C29.7359 12.23 29.8586 12.2514 29.9735 12.296C30.0885 12.3406 30.1936 12.4075 30.2827 12.4927C30.3718 12.5779 30.4432 12.6799 30.4928 12.7928C30.5424 12.9057 30.5693 13.0273 30.5719 13.1506L30.8062 23.7546C30.8117 24.0035 30.7181 24.2444 30.546 24.4242C30.3739 24.6041 30.1373 24.7083 29.8884 24.7138C29.6395 24.7193 29.3987 24.6257 29.2188 24.4536C29.0389 24.2815 28.9348 24.0449 28.9293 23.7961L28.7463 15.4546L13.46 31.4317C13.2881 31.6113 13.0519 31.7154 12.8033 31.7209C12.5548 31.7263 12.3142 31.6329 12.1345 31.461Z"
                                fill="#2D2C2B" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection

@push('js')
<script src="{{ asset('assets/frontend/js/home_page.js') }}"></script>
@endpush
