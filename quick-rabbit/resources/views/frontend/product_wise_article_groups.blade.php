@extends(layout())
@section('menu')
    @include('frontend.menu_others')
@endsection

@section('footer_menu')
    @include('frontend.others_footer')
@endsection

@section('content')
    <input type="hidden" name="" class="product_category_id" value="{{ isset($product) ? $product->id : '' }}">
    <input type="hidden" id="active_article_id" value="{{ isset($active_id) && $active_id ? $active_id : '' }}">
    

    <div class="breadcrumb-wrapper article-breadcrumb-wrapper">
        <div class="container">
            <div class="row g-4 align-items-center">
                <h2 class="mb-0 titlewithicon">
                    {{ $product->title ?? '' }}
                </h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.articles')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>
    
    <!-- Article Details -->
    <div class="article-details-wrapper-page">
        <div class="container">
            <div class="search-area search_area_unique">
                <form class="article-top-search-form" action="#">
                    <div class="row input-box m-0">
                        <div class="col-12 position-relative">
                            <input type="text" id="searchInputModal"
                                class="form-control input-focused search-key top-search-form-input"
                                placeholder="@lang('index.search')... e:g transfer licenses">
                            <div class="search-icon" id="search-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.75 8.25C3.75 5.76825 5.76825 3.75 8.25 3.75C10.7317 3.75 12.75 5.76825 12.75 8.25C12.75 10.7317 10.7317 12.75 8.25 12.75C5.76825 12.75 3.75 10.7317 3.75 8.25ZM15.5302 14.4697L12.984 11.9228C13.7737 10.9073 14.25 9.6345 14.25 8.25C14.25 4.94175 11.5582 2.25 8.25 2.25C4.94175 2.25 2.25 4.94175 2.25 8.25C2.25 11.5582 4.94175 14.25 8.25 14.25C9.6345 14.25 10.9072 13.7738 11.9227 12.984L14.4697 15.5303C14.616 15.6765 14.808 15.75 15 15.75C15.192 15.75 15.384 15.6765 15.5302 15.5303C15.8235 15.237 15.8235 14.763 15.5302 14.4697Z"
                                        fill="white" />
                                    <mask id="mask0_2305_3964" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="2"
                                        y="2" width="14" height="14">
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
                        <div class="col-12 d-flex justify-content-center align-items-center gap-3">
                            <span class="article_page_popular_search_title">@lang('index.popular_search'):</span>
                            <ul class="popular-search-list list-unstyled d-flex gap-2">
                                <li>@lang('index.printer')</li>
                                <li>@lang('index.getting_started')</li>
                                <li>@lang('index.settings')</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <input type="hidden" id="active_page" value="Article">
            <div class="row article-card-wrap">
                <div class="col-12 col-md-5 col-lg-4 article-sidebar">
                    <h2 class="product-title">{{ $product->title ?? '' }}</h2>
                    <div class="article-card-body">

                        <div class="accordion accordion-flush" id="articleSidebar">
                            <!-- Accordion Item -->
                            @foreach ($groups as $group)
                                <div class="accordion-item main_group_article">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{  $loop->index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#number{{ $group->id }}" id="title_{{ $group->id }}"
                                            aria-expanded="false" aria-controls="number{{ $group->id }}">                                            
                                            {{ $group->title }}
                                        </button>
                                    </h2>

                                    <div id="number{{ $group->id }}" class="accordion-collapse collapse {{  $loop->index == 0 ? 'show' : '' }}"
                                        data-bs-parent="#articleSidebar">
                                        <div class="accordion-body article-card">
                                            <!-- List -->
                                            <ul class="list-unstyled">
                                                @if (count($group->articles))
                                                    @foreach ($group->articles as $group_article)
                                                    <li>
                                                        <svg width="20" height="20" viewBox="0 0 20 20"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M17.4455 4.85906L12.7581 0.17168C12.6482 0.0618314 12.4992 8.7829e-05 12.3438 0L4.14062 0C3.17137 0 2.38281 0.788555 2.38281 1.75781V18.2422C2.38281 19.2114 3.17137 20 4.14062 20H15.8594C16.8286 20 17.6172 19.2114 17.6172 18.2422V5.27344C17.6172 5.11367 17.5501 4.96363 17.4455 4.85906ZM12.9297 2.00051L15.6167 4.6875H13.5156C13.1925 4.6875 12.9297 4.42465 12.9297 4.10156V2.00051ZM15.8594 18.8281H4.14062C3.81754 18.8281 3.55469 18.5653 3.55469 18.2422V1.75781C3.55469 1.43473 3.81754 1.17188 4.14062 1.17188H11.7578V4.10156C11.7578 5.07082 12.5464 5.85938 13.5156 5.85938H16.4453V18.2422C16.4453 18.5653 16.1825 18.8281 15.8594 18.8281Z"
                                                                fill="#727272" />
                                                            <path
                                                                d="M13.5156 8.28125H6.48438C6.16078 8.28125 5.89844 8.54359 5.89844 8.86719C5.89844 9.19078 6.16078 9.45312 6.48438 9.45312H13.5156C13.8392 9.45312 14.1016 9.19078 14.1016 8.86719C14.1016 8.54359 13.8392 8.28125 13.5156 8.28125ZM13.5156 10.625H6.48438C6.16078 10.625 5.89844 10.8873 5.89844 11.2109C5.89844 11.5345 6.16078 11.7969 6.48438 11.7969H13.5156C13.8392 11.7969 14.1016 11.5345 14.1016 11.2109C14.1016 10.8873 13.8392 10.625 13.5156 10.625ZM13.5156 12.9688H6.48438C6.16078 12.9688 5.89844 13.2311 5.89844 13.5547C5.89844 13.8783 6.16078 14.1406 6.48438 14.1406H13.5156C13.8392 14.1406 14.1016 13.8783 14.1016 13.5547C14.1016 13.2311 13.8392 12.9688 13.5156 12.9688ZM11.1719 15.3125H6.48438C6.16078 15.3125 5.89844 15.5748 5.89844 15.8984C5.89844 16.222 6.16078 16.4844 6.48438 16.4844H11.1719C11.4955 16.4844 11.7578 16.222 11.7578 15.8984C11.7578 15.5748 11.4955 15.3125 11.1719 15.3125Z"
                                                                fill="#727272" />
                                                        </svg>

                                                        <a class="text-truncate article_title article_title article_title_content make_color {{ isset($article) && $article->id == $group_article->id ? 'active-article' : '' }}"
                                                            href="{{ route('article-details', [$product->slug, $group_article->title_slug]) }}">{{ $group_article->title }}</a>
                                                    </li>
                                                    @endforeach
                                                @else
                                                    <li>
                                                        <div class="alert alert-danger">@lang('index.no_article_found')</div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-7 col-lg-8 article-card-right" id="focused-div">

                    <div class="article_list_for">
                        <h2><span class="article_list_for">@lang('index.article_list_for'):</span> <span
                                class="article_list_for_title">{{ $groups[0]->title }}</span>
                        </h2>
                    </div>

                    <div class="article-card">
                        <!-- List -->
                        <ul class="list-unstyled">
                            @if (count($groups))
                                @foreach ($groups[0]->articles as $article)
                                    <li>
                                        <a class="text-truncate art_title_list match_bold"
                                            href="{{ route('article-details', [$product->slug, $article->title_slug]) }}">
                                            {{ $article->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <div class="alert alert-danger">@lang('index.no_article_found')</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/article.js') }}"></script>
@endpush
