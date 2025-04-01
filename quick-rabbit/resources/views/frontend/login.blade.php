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
                <h2 class="mb-0">@lang('index.login')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (urlPrefix() == 'admin')
                            @lang('index.login_as_admin')
                        @elseif(urlPrefix() == 'agent')
                            @lang('index.login_as_agent')
                        @elseif(urlPrefix() == 'customer')
                            @lang('index.login_as_customer')
                        @endif
                    </li>
                </ol>
            </div>
        </div>
    </div>
    </div>
    <div class="register-wrapper" id="focused-div">
        <input type="hidden" id="active_page" value="Login">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 left-col">
                    <div class="top_text">
                        <h2>
                            @if (urlPrefix() == 'admin')
                                @lang('index.login_as_admin')
                            @elseif(urlPrefix() == 'agent')
                                @lang('index.login_as_agent')
                            @elseif(urlPrefix() == 'customer')
                                @lang('index.login_as_customer')
                            @endif
                        </h2>
                        <p class="sub-text">@lang('index.login_account')</p>
                    </div>
                    
                    <!-- Form -->
                    <form action="{{ route('user-login') }}" method="POST" id="login_form">
                        @csrf
                        @if (Session::has('message'))
                        <div class="alert alert-{{ Session::get('type') ?? 'danger' }}">
                            <span>{{ Session::get('message') }}</span>
                        </div>
                    @endif

                    @if (Session::has('resend-message'))
                        <div class="alert alert-info">
                            <span>{{ Session::get('resend-message') }}</span>
                            <a href="{{ route('resend-link', Session::get('email')) }}">@lang('index.resend_verification_link')</a>
                        </div>
                    @endif
                        <div class="row login-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">@lang('index.email') <span class="text-danger">*</span></label>
                                    <div>
                                        <div class="position-relative">
                                            <input name="email" value="{{ getDemoAccess(1) }}" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="@lang('index.email_placeholder')">
                                            <svg class="email_icon" width="16" height="12" viewBox="0 0 16 12"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.6667 0H1.33334C0.597969 0 0 0.597969 0 1.33334V10.6667C0 11.402 0.597969 12 1.33334 12H14.6667C15.402 12 16 11.402 16 10.6667V1.33334C16 0.597969 15.402 0 14.6667 0ZM1.33334 0.666656H14.6667C14.7158 0.666656 14.7591 0.684563 14.8052 0.694688C13.6508 1.75116 9.82322 5.25278 8.48375 6.45963C8.37894 6.55403 8.21 6.66666 8.00003 6.66666C7.79006 6.66666 7.62113 6.55403 7.51597 6.45931C6.17663 5.25266 2.34878 1.75084 1.19463 0.69475C1.24081 0.684625 1.28419 0.666656 1.33334 0.666656ZM0.666656 10.6667V1.33334C0.666656 1.26803 0.686344 1.20878 0.703969 1.14909C1.58747 1.95772 4.25822 4.40097 5.98997 5.97575C4.26384 7.45847 1.59241 9.99122 0.701875 10.8404C0.686156 10.7837 0.666656 10.7283 0.666656 10.6667ZM14.6667 11.3333H1.33334C1.28009 11.3333 1.23275 11.3148 1.18303 11.3029C2.10325 10.4257 4.79169 7.87834 6.48747 6.42762C6.68125 6.60353 6.87532 6.77914 7.06966 6.95444C7.34441 7.2025 7.666 7.33334 8 7.33334C8.334 7.33334 8.65559 7.20247 8.93 6.95475C9.12445 6.77934 9.31862 6.60363 9.51253 6.42762C11.2084 7.87819 13.8965 10.4253 14.817 11.3029C14.7673 11.3148 14.72 11.3333 14.6667 11.3333ZM15.3333 10.6667C15.3333 10.7283 15.3138 10.7837 15.2982 10.8404C14.4073 9.99078 11.7362 7.45831 10.0101 5.97578C11.7419 4.401 14.4122 1.95797 15.296 1.14903C15.3137 1.20872 15.3333 1.268 15.3333 1.33331V10.6667Z"
                                                    fill="#727272" />
                                            </svg>
                                        </div>
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group password-sec">
                                    <label for="password">@lang('index.password') <span class="text-danger">*</span></label>
                                    <div>
                                        <div class="position-relative">
                                            <input name="password" type="password"
                                                class="form-control password-field-for-js @error('password') is-invalid @enderror"
                                                placeholder="@lang('index.password_placeholder')" value="{{ getDemoAccess(2) }}">
                                            <svg class="lock_icon" width="16" height="16" viewBox="0 0 16 16"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M7.99862 0.470581C5.64568 0.470581 3.76333 2.35293 3.76333 4.70588V6.58823C2.96333 6.58823 2.35156 7.19999 2.35156 7.99999V14.1176C2.35156 14.9176 2.96333 15.5294 3.76333 15.5294H12.2339C13.0339 15.5294 13.6457 14.9176 13.6457 14.1176V7.99999C13.6457 7.19999 13.0339 6.58823 12.2339 6.58823V4.70588C12.2339 2.35293 10.3516 0.470581 7.99862 0.470581ZM12.7045 7.99999V14.1176C12.7045 14.4 12.5163 14.5882 12.2339 14.5882H3.76333C3.48097 14.5882 3.29274 14.4 3.29274 14.1176V7.99999C3.29274 7.71764 3.48097 7.5294 3.76333 7.5294H12.2339C12.5163 7.5294 12.7045 7.71764 12.7045 7.99999ZM4.7045 6.58823V4.70588C4.7045 2.87058 6.16333 1.41176 7.99862 1.41176C9.83392 1.41176 11.2927 2.87058 11.2927 4.70588V6.58823H4.7045Z"
                                                    fill="#727272" />
                                                <path
                                                    d="M7.9977 8.94116C7.1977 8.94116 6.58594 9.55293 6.58594 10.3529C6.58594 10.9647 6.96241 11.4823 7.52711 11.6706V12.7059C7.52711 12.9882 7.71535 13.1765 7.9977 13.1765C8.28006 13.1765 8.46829 12.9882 8.46829 12.7059V11.6706C9.033 11.4823 9.40947 10.9647 9.40947 10.3529C9.40947 9.55293 8.7977 8.94116 7.9977 8.94116ZM7.9977 10.8235C7.71535 10.8235 7.52711 10.6353 7.52711 10.3529C7.52711 10.0706 7.71535 9.88234 7.9977 9.88234C8.28006 9.88234 8.46829 10.0706 8.46829 10.3529C8.46829 10.6353 8.28006 10.8235 7.9977 10.8235Z"
                                                    fill="#727272" />
                                            </svg>
                                            <img src="{{ asset('assets/frontend/img/core-img/password.svg') }}" alt=""
                                            class="password-icon" width="22">
                                        </div>                                        
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>                           

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 padding-12">
                                    @lang('index.login')
                                </button>
                            </div>
                            <div class="row">  
                                <div class="col-12 col-md-12">
                                    <div class="text-center">
                                        <a href="{{ route('reset-password-step-one') }}">
                                            @lang('index.forgot_password')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if (Request::is('customer*'))
                        <!-- Divider -->
                        <div class="register-divider-wrapper-wrapper">
                            <div class="register-divider-wrapper">
                                <p class="register-divider d-block">
                                    <span>@lang('index.or')</span>
                                </p>
                                <div class="others-login">
                                    <div class="row g-4">
                                        @if (socialInfo() && socialInfo()['envato_login'] == 'Active')
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <a class="btn btn-envato d-block social_btn"
                                                    href="{{ url('auth/envato') }}">
                                                    <svg width="26" height="24" viewBox="0 0 26 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <rect x="0.5" width="25" height="24"
                                                            fill="url(#pattern0_319_755)" />
                                                        <defs>
                                                            <pattern id="pattern0_319_755"
                                                                patternContentUnits="objectBoundingBox" width="1"
                                                                height="1">
                                                                <use xlink:href="#image0_319_755"
                                                                    transform="scale(0.04 0.0416667)" />
                                                            </pattern>
                                                            <image id="image0_319_755" width="25" height="24"
                                                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAYCAYAAAAPtVbGAAAB60lEQVRIDaWVv2sUURDHrxSsFLGMoGCpFhb5YfFmTvwP1NoiJGWKEJL7vksOLEQsBf8AsRARNDN7IZGAQiClhWIi2IgKYkjURlIm7iXzbm+zL5fdOzhm5jszny/Hu7dbqw3waS7SGJTvQ2kNwn+h/GOuXb88ALK76tU5r7zulffyXwi97k5WzKD0MA/O1wsyNlQRX6tB+E0eWFRD+UElEyi/KAIWa/SztIkXN1EMO3omNtdUuho1aiR1yjZbyyNnvfKOLZeI41lOyFvqzkHpd2tl9LyJJznoImMoPzZGT4TSM6/8z8SDX0G7RZB+GpSWjRMi2nwhXYTQFxOhPNkPFu0LfTZOiBCa75gobZoIpdUopOAiZmchvG2cEL3Qu46J0LdUbL11p7JLVfIAtwRKWwaaXrl1Gm133eoqMf0DGTvELKgpdAfq7ma1sjmUPga4JV74VxdE3yH8qFvHL11sBkIvjR2inUlsqawOpZkAt+Q/ZKEs6Lh5iBs2doizSf3icUslexsBnE+88quSsCMvrcP9e3l2qDu3XujPIEYQ/hSAscQn7uYgJo22uxZj9+hI+HZZIyh/TS9wD6hf4Zf4EoSfnsQsfcbNJjfO9GNG++m7BQlPQem5V/7glXa98PuDe0VPGov1K9Hlw8Y+++qJ8zfNYJEAAAAASUVORK5CYII=" />
                                                        </defs>
                                                    </svg>

                                                    @lang('index.login_with_envato')
                                                </a>
                                            </div>
                                        @endif
                                        @if (socialInfo() && socialInfo()['google_login'] == 'Active')
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <a class="btn btn-google d-block social_btn"
                                                    href="{{ url('auth/google') }}">
                                                    <svg width="28" height="28" viewBox="0 0 28 28"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_312_960)">
                                                            <path
                                                                d="M27.7283 14.3225C27.7283 13.3709 27.6511 12.414 27.4865 11.4778H14.2812V16.8689H21.8433C21.5295 18.6077 20.5212 20.1458 19.0448 21.1232V24.6213H23.5563C26.2056 22.1829 27.7283 18.582 27.7283 14.3225Z"
                                                                fill="#4285F4" />
                                                            <path
                                                                d="M14.2803 28.001C18.0561 28.001 21.2404 26.7612 23.5605 24.6213L19.049 21.1232C17.7938 21.9771 16.1734 22.4607 14.2854 22.4607C10.633 22.4607 7.5362 19.9966 6.42505 16.6837H1.76953V20.2898C4.14616 25.0174 8.98688 28.001 14.2803 28.001Z"
                                                                fill="#34A853" />
                                                            <path
                                                                d="M6.42088 16.6837C5.83444 14.9449 5.83444 13.0621 6.42088 11.3234V7.71729H1.7705C-0.215167 11.6732 -0.215167 16.3339 1.7705 20.2898L6.42088 16.6837Z"
                                                                fill="#FBBC04" />
                                                            <path
                                                                d="M14.2803 5.54127C16.2762 5.51041 18.2053 6.26146 19.6508 7.64012L23.6479 3.64305C21.1169 1.26642 17.7578 -0.0402103 14.2803 0.000943444C8.98687 0.000943444 4.14616 2.98459 1.76953 7.71728L6.41991 11.3234C7.52591 8.00536 10.6279 5.54127 14.2803 5.54127Z"
                                                                fill="#EA4335" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_312_960">
                                                                <rect width="28" height="28" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                    @lang('index.login_with_google')
                                                </a>
                                            </div>
                                        @endif
                                        @if (socialInfo() && socialInfo()['github_login'] == 'Active')
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <a class="btn btn-github d-block social_btn"
                                                    href="{{ url('auth/github') }}">
                                                    <svg width="28" height="28" viewBox="0 0 28 28"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_319_757)">
                                                            <path
                                                                d="M14 0.583344C6.265 0.583344 0 6.74334 0 14.3407C0 20.4202 4.011 25.5757 9.5725 27.3933C10.2725 27.5228 10.5292 27.097 10.5292 26.7318C10.5292 26.4052 10.5175 25.5395 10.5117 24.3927C6.61733 25.2222 5.796 22.547 5.796 22.547C5.159 20.9592 4.2385 20.5345 4.2385 20.5345C2.97033 19.6817 4.3365 19.6992 4.3365 19.6992C5.74233 19.7948 6.48083 21.1167 6.48083 21.1167C7.72917 23.2202 9.758 22.6123 10.5583 22.2612C10.6843 21.371 11.0448 20.7655 11.445 20.4213C8.33583 20.0772 5.068 18.8942 5.068 13.6232C5.068 12.1217 5.6105 10.8943 6.50883 9.93184C6.35133 9.58418 5.87883 8.18534 6.63133 6.29068C6.63133 6.29068 7.80383 5.92201 10.4813 7.70118C11.6013 7.39551 12.7913 7.24384 13.9813 7.23684C15.1713 7.24384 16.3613 7.39551 17.4813 7.70118C20.1413 5.92201 21.3138 6.29068 21.3138 6.29068C22.0663 8.18534 21.5938 9.58418 21.4538 9.93184C22.3463 10.8943 22.8888 12.1217 22.8888 13.6232C22.8888 18.9082 19.6163 20.0713 16.5013 20.4097C16.9913 20.8227 17.4463 21.6662 17.4463 22.9553C17.4463 24.7963 17.4288 26.2757 17.4288 26.7225C17.4288 27.083 17.6738 27.5135 18.3913 27.3758C23.9925 25.5698 28 20.4108 28 14.3407C28 6.74334 21.7315 0.583344 14 0.583344Z"
                                                                fill="black" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_319_757">
                                                                <rect width="28" height="28" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                    @lang('index.login_with_github')
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Divider -->
                            <p class="mb-0 text-center register-text">@lang('index.no_account') <a
                                    href="{{ route('register') }}">@lang('index.create_account') </a>
                            </p>
                        </div>
                    @endif
                </div>

                <div class="col-12 col-lg-6">
                    <div class="login-image rounded-4 mt-5">
                        @if (urlPrefix() == 'admin')
                            <img class="rounded-4" src="{{ asset('assets/frontend/img/core-img/customer-login-bg.svg') }}"
                                alt="">
                        @elseif(urlPrefix() == 'agent')
                            <img class="rounded-4" src="{{ asset('assets/frontend/img/core-img/customer-login-bg.svg') }}"
                                alt="">
                        @elseif(urlPrefix() == 'customer')
                            <img class="rounded-4"
                                src="{{ asset('assets/frontend/img/core-img/customer-login-bg.svg') }}" alt="">
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
