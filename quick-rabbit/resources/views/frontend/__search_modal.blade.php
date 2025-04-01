<div class="modal fade" id="searchBoxModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-label="Close">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
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
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row g-4 g-sm-5 justify-content-center justify-lg-content-between align-items-end">
                        <div class="col-12 col-md-10 col-lg-10 col-xl-11">
                            <div class="search-area">
                                <form class="top-search-form" action="#">
                                    <div class="row input-box m-0">
                                        <div class="col-12 col-lg-8">
                                            <div class="row gap-0">
                                                @if (appTheme() == 'single')
                                                    <input type="hidden" name="product_category_id"
                                                        class="product_category_id" value="{{ getAllProduct()[0]->id }}">
                                                @endif
                                                <div class="col-md-5 col-lg-3 col-xl-3 col-xs-5 col-12 p-0 {{ appTheme() == 'single' ? 'd-none' : '' }}">
                                                    <select id="categorySelect"
                                                        class="hero-form-select product_category_id_modal"
                                                        aria-label="Default select example">
                                                        <option value="">@lang('index.all_product_category')</option>
                                                        @foreach (getAllProduct() as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="{{ appTheme() == 'single' ? '' : 'col-md-7 col-lg-9 col-xl-9 col-xs-7 ' }}col-12 p-0">
                                                    <input type="text" id="searchInputModal"
                                                        class="form-control input-focused search-key top-search-form-input"
                                                        placeholder="@lang('index.search')... e:g license uninstall" autofocus>
                                                    <div class="search-icon" id="search-icon-modal">
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
                                                <div class="search-results-card shadow-sm text-center mx-auto"
                                                    id="searchResults">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <button class="nav-link" id="search1-tab"
                                                                data-bs-toggle="tab" data-bs-target="#search1"
                                                                type="button" role="tab" aria-controls="search1"
                                                                aria-selected="true">@lang('index.article')</button>

                                                            <button class="nav-link" id="search2-tab"
                                                                data-bs-toggle="tab" data-bs-target="#search2"
                                                                type="button" role="tab" aria-controls="search2"
                                                                aria-selected="false">@lang('index.faq')</button>

                                                            <button class="nav-link" id="search3-tab"
                                                                data-bs-toggle="tab" data-bs-target="#search3"
                                                                type="button" role="tab" aria-controls="search3"
                                                                aria-selected="false">@lang('index.blog')</button>

                                                            <button class="nav-link" id="search4-tab"
                                                                data-bs-toggle="tab" data-bs-target="#search4"
                                                                type="button" role="tab" aria-controls="search4"
                                                                aria-selected="false">@lang('index.page')</button>
                                                            <button class="nav-link" id="search5-tab"
                                                                data-bs-toggle="tab" data-bs-target="#search5"
                                                                type="button" role="tab" aria-controls="search5"
                                                                aria-selected="false">AI</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
