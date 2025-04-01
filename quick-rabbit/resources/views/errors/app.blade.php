<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Quick Rabbit">
    <!-- Title -->
    <title>{{ siteSetting()->title ?? 'Quick Rabbit' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(siteSetting()->icon ?? '') }}">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap-icons.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select2.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.min.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.theme.default.css?var=2.1') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/plugin/aos-master/dist/aos.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/js/magnific-popup.css?var=2.2') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/new-design.css?var=2.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/new-design_v1.css?var=2.1.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css?var=2.1') }}">
    @stack('css')


<body class="custom-cursor">
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>
    <div class="overlay" id="overlay"></div>
    <input type="hidden" id="base_url_hidden" name="app-url" data-app_url="{!! url('/') !!}">
    <input type="hidden" id="user_id_hidden" name="app-user_id" data-app_user_id="{!! authUserId() !!}">
    <input type="hidden" id="default_theme" value="{{ $_GET['theme'] ?? '' }}">
    <input type="hidden" id="default_theme_temp" value="{{ siteSetting()->default_theme ?? 'dark' }}">
    <input type="hidden" id="please_login_first" value="@lang('index.please_login_first')">

    <input type="hidden" id="str_login" value="@lang('index.login')">
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>


    @if (count(getNotice()))
        <div class="bg-notice">
            <div class="t-container">
                <div class="owl-carousel owl-theme">
                    @foreach (getNotice() as $notice)
                        <div class="item">
                            <p>{{ $notice->notice ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    <input type="hidden" id="session_lan" value="{{ session()->get('lan') ?? 'en' }}">
    <input type="hidden" id="site_logo" value="{{ asset(siteSetting()->logo) }}">
    <input type="hidden" id="has_browser_push" value="{{ siteSetting()->browser_notification }}">
    <div
        class="top_hero_sec error_page_top">
        <div class="bg-image-header {{ request()->url() == route('home') ? 'd-none' : '' }}" loading="lazy"></div>
        <div class="ellipse2_breadcrumb {{ request()->url() == route('home') ? 'd-none' : '' }}" loading="lazy"></div>
        <!-- Top Header -->
        <div class="top-header {{ count(getNotice()) ? 'top-header-marque' : 'top-header-skip top_header_m_0' }}">
            <div class="t-container top-header-container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-3 col-sm-5 col-md-6 left-col">
                        <div class="contact-info d-flex align-items-center">
                            <a href="tel:{{ siteSetting()->phone ?? '' }}">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_100_134)">
                                        <path
                                            d="M15.5092 12.528C14.4218 11.598 13.3183 11.0346 12.2442 11.9632L11.6029 12.5245C11.1337 12.9319 10.2613 14.8355 6.88815 10.9552C3.51574 7.07989 5.52261 6.4765 5.99254 6.0726L6.63738 5.51064C7.70579 4.57991 7.30259 3.40824 6.53202 2.20216L6.067 1.47162C5.29291 0.268342 4.44999 -0.521901 3.37877 0.407425L2.79996 0.913181C2.32651 1.25808 1.00312 2.37917 0.682104 4.50897C0.295763 7.06444 1.51449 9.9908 4.30669 13.2016C7.09537 16.4139 9.82575 18.0274 12.4121 17.9993C14.5616 17.9761 15.8597 16.8227 16.2657 16.4034L16.8466 15.8969C17.915 14.9683 17.2512 14.0228 16.1632 13.0907L15.5092 12.528Z"
                                            fill="white" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_100_134">
                                            <rect width="18" height="18" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <span class="d-none d-md-inline-block">
                                    {{ siteSetting()->phone ?? '' }}
                                </span>
                            </a>
                            <a href="mailto:{{ siteSetting()->email ?? '' }}">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_100_140)">
                                        <path
                                            d="M10.5043 11.0283C10.0565 11.3268 9.53631 11.4846 9 11.4846C8.46373 11.4846 7.94355 11.3268 7.49573 11.0283L0.119848 6.11086C0.0791298 6.08363 0.0391656 6.0553 0 6.02588L0 14.0836C0 15.0074 0.749707 15.7406 1.65702 15.7406H16.3429C17.2668 15.7406 18 14.9909 18 14.0836V6.02585C17.9607 6.05534 17.9207 6.08373 17.8799 6.111L10.5043 11.0283Z"
                                            fill="white" />
                                        <path
                                            d="M0.704884 5.23328L8.08077 10.1507C8.35998 10.3369 8.67997 10.4299 8.99997 10.4299C9.31999 10.4299 9.64002 10.3368 9.91923 10.1507L17.2951 5.23328C17.7365 4.93919 18 4.44701 18 3.9158C18 3.0024 17.2569 2.25934 16.3435 2.25934H1.65646C0.743099 2.25937 8.71912e-07 3.00244 8.71912e-07 3.91667C-0.000272946 4.17725 0.0639503 4.43385 0.186942 4.66358C0.309934 4.89331 0.487872 5.08903 0.704884 5.23328Z"
                                            fill="white" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_100_140">
                                            <rect width="18" height="18" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <span class="d-none d-md-inline-block">
                                    {{ siteSetting()->email ?? '' }}
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="col-9 col-sm-12 col-md-6 right-col">
                        <div class="d-flex align-items-center justify-content-end top-bar-left-sec">
                            <!-- Dropdown -->
                            <div class="top-dropdown">
                                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_100_147)">
                                            <path
                                                d="M7.64493 10.4711L6.47306 4.61164C6.4465 4.47882 6.37474 4.3593 6.26999 4.27343C6.16524 4.18755 6.03398 4.14062 5.89853 4.14063H4.72665C4.5912 4.14062 4.45993 4.18755 4.35519 4.27343C4.25044 4.3593 4.17868 4.47882 4.15212 4.61164L2.98024 10.471C2.91677 10.7884 3.12259 11.097 3.43989 11.1605C3.7572 11.2239 4.06591 11.0181 4.12935 10.7008L4.50388 8.82812H6.1213L6.49583 10.7009C6.55931 11.0183 6.86814 11.224 7.18528 11.1605C7.50259 11.097 7.70841 10.7884 7.64493 10.4711ZM4.73825 7.65625L5.207 5.3125H5.41817L5.88692 7.65625H4.73825ZM17.0313 8.82812H15.2735V8.24219C15.2735 7.91859 15.0112 7.65625 14.6876 7.65625C14.364 7.65625 14.1017 7.91859 14.1017 8.24219V8.82812H12.3438C12.0202 8.82812 12.1579 9.09047 12.1579 9.41406C12.1579 9.73766 12.0202 10 12.3438 10H12.4856C12.8195 11.0786 13.3222 11.9065 13.8753 12.5699C13.4251 12.9817 12.9695 13.3194 12.5638 13.644C12.3111 13.8462 12.2701 14.2149 12.4723 14.4676C12.6745 14.7204 13.0433 14.7611 13.2958 14.5591C13.7039 14.2326 14.193 13.8698 14.6876 13.4159C15.1826 13.8702 15.6726 14.2336 16.0793 14.5591C16.332 14.7612 16.7008 14.7202 16.9029 14.4676C17.1051 14.2149 17.0641 13.8461 16.8114 13.644C16.4067 13.3202 15.9506 12.9821 15.4999 12.5699C16.053 11.9065 16.5557 11.0786 16.8895 10H17.0313C17.3549 10 17.6173 9.73766 17.6173 9.41406C17.6173 9.09047 17.3549 8.82812 17.0313 8.82812ZM14.6876 12.1088C14.3136 11.2393 13.9771 10.6788 13.7234 9.99609H15.6517C15.3981 10.6788 15.0616 11.2393 14.6876 12.1088Z"
                                                fill="white" />
                                            <path
                                                d="M18.2422 3.55469H9.78902L9.53785 1.53977C9.42813 0.661953 8.67828 0 7.79363 0H2.15781C0.788555 0 0 0.788555 0 2.15781V14.6875C0 15.6568 0.788555 16.4453 2.15781 16.4453H6.69855L6.94652 18.4602C7.05605 19.3363 7.8059 20 8.69078 20H18.2422C19.2114 20 20 19.2114 20 18.2422V5.3125C20 4.34324 19.2114 3.55469 18.2422 3.55469ZM2.15781 15.2734C1.43473 15.2734 1.17188 15.0106 1.17188 14.6875V2.15781C1.17188 1.43473 1.43473 1.17188 2.15781 1.17188H7.79363C8.08852 1.17188 8.33848 1.3925 8.375 1.68492L10.0689 15.2734H2.15781ZM8.07516 18.0371L7.87926 16.4453H9.45129L8.07516 18.0371ZM18.8281 18.2422C18.8281 18.5653 18.5653 18.8281 18.2422 18.8281H8.94039L11.171 16.2479C11.2272 16.1846 11.269 16.1098 11.2935 16.0287C11.318 15.9476 11.3246 15.8621 11.3128 15.7782L9.93512 4.72656H18.2422C18.5653 4.72656 18.8281 4.98941 18.8281 5.3125V18.2422Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_100_147">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span
                                        class="d-none d-sm-inline-block">{{ lanFullName(session()->get('lan')) }}</span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach (languageFolders() as $dir)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('change-language', ['lan' => $dir]) }}">
                                                {{ lanFullName($dir) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Dropdown -->
                            @guest
                                <div class="top-dropdown">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_100_156)">
                                                <path
                                                    d="M14.5481 0.01C14.5315 0.00865625 14.5175 0 14.5001 0H7.3335C6.23084 0 5.3335 0.897344 5.3335 2V2.66663C5.3335 3.03466 5.63209 3.33337 6.00012 3.33337C6.36815 3.33337 6.66675 3.03466 6.66675 2.66663V2C6.66675 1.63269 6.96606 1.33337 7.3335 1.33337H10.4394L10.2361 1.40138C9.69615 1.588 9.3335 2.09669 9.3335 2.66663V12.6666H7.3335C6.96606 12.6666 6.66675 12.3673 6.66675 12V10.6666C6.66675 10.2987 6.36815 10 6.00012 10C5.63209 10 5.3335 10.2987 5.3335 10.6666V12C5.3335 13.1027 6.23084 14 7.3335 14H9.3335V14.6666C9.3335 15.402 9.9314 16 10.6667 16C10.8094 16 10.9448 15.9794 11.0914 15.934L15.0968 14.5987C15.6374 14.412 16.0001 13.9033 16.0001 13.3334V1.33337C16.0001 0.556031 15.3301 -0.0533438 14.5481 0.01Z"
                                                    fill="white" />
                                                <path
                                                    d="M7.13794 6.19532L4.47131 3.5287C4.37809 3.43538 4.25928 3.37183 4.12992 3.34608C4.00056 3.32033 3.86647 3.33354 3.74463 3.38404C3.62293 3.43465 3.51894 3.52015 3.44575 3.62977C3.37257 3.73938 3.33347 3.86821 3.33337 4.00001V6.00001H0.666625C0.298719 6.00001 0 6.29873 0 6.66663C0 7.03467 0.298719 7.33338 0.666625 7.33338H3.33337V9.33338C3.33349 9.46518 3.3726 9.59399 3.44578 9.70359C3.51897 9.8132 3.62294 9.8987 3.74463 9.94932C3.86647 9.9998 4.00056 10.013 4.12991 9.98726C4.25926 9.96151 4.37807 9.89798 4.47131 9.8047L7.13794 7.13795C7.39869 6.87732 7.39869 6.45607 7.13794 6.19532Z"
                                                    fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_100_156">
                                                    <rect width="16" height="16" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <span>@lang('index.login_as')</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('customer.login') }}">
                                                @lang('index.customer')
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('agent.login') }}">
                                                @lang('index.agent')
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.login') }}">
                                                @lang('index.admin')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endguest
                            @auth
                                <div class="contact-info">
                                    <a href="{{ route('logout') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="24"
                                            height="24" viewBox="0 0 24 24" w stroke-width="1.5"
                                            stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                        </svg>

                                        @lang('index.logout')
                                    </a>
                                </div>
                            @endauth
                            <div class="contact-info">
                                @guest
                                    <a href="{{ route('register') }}">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.3334 8.95898H14.1667C14.001 8.95898 13.842 8.89314 13.7248 8.77593C13.6076 8.65872 13.5417 8.49974 13.5417 8.33398C13.5417 8.16822 13.6076 8.00925 13.7248 7.89204C13.842 7.77483 14.001 7.70898 14.1667 7.70898H18.3334C18.4992 7.70898 18.6581 7.77483 18.7754 7.89204C18.8926 8.00925 18.9584 8.16822 18.9584 8.33398C18.9584 8.49974 18.8926 8.65872 18.7754 8.77593C18.6581 8.89314 18.4992 8.95898 18.3334 8.95898Z"
                                                fill="white" />
                                            <path
                                                d="M16.25 11.0417C16.0843 11.0416 15.9253 10.9758 15.8081 10.8586C15.6909 10.7414 15.625 10.5824 15.625 10.4167V6.25C15.625 6.08424 15.6908 5.92527 15.8081 5.80806C15.9253 5.69085 16.0842 5.625 16.25 5.625C16.4158 5.625 16.5747 5.69085 16.6919 5.80806C16.8092 5.92527 16.875 6.08424 16.875 6.25V10.4167C16.875 10.5824 16.8091 10.7414 16.6919 10.8586C16.5747 10.9758 16.4157 11.0416 16.25 11.0417Z"
                                                fill="white" />
                                            <path
                                                d="M7.5 9.79199C6.63471 9.79199 5.78885 9.53541 5.06938 9.05467C4.34992 8.57394 3.78916 7.89066 3.45803 7.09123C3.1269 6.29181 3.04026 5.41214 3.20907 4.56347C3.37788 3.71481 3.79455 2.93526 4.40641 2.3234C5.01826 2.11155 5.79781 1.29487 6.64648 1.12606C7.49515 0.957248 8.37481 1.04389 9.17424 1.37502C9.97367 2.10615 10.6569 2.26691 11.1377 2.98637C11.6184 3.70584 11.875 4.5517 11.875 5.41699C11.8737 6.57691 11.4123 7.68893 10.5921 8.50911C9.77194 9.3293 8.65991 9.79066 7.5 9.79199ZM7.5 2.29199C6.88194 2.29199 6.27775 2.47527 5.76385 2.81865C5.24994 3.16203 4.8494 3.65009 4.61288 4.22111C4.37635 4.79213 4.31447 5.42046 4.43505 6.02665C4.55563 6.63284 4.85325 7.18966 5.29029 7.6267C5.72733 8.06374 6.28415 8.36137 6.89035 8.48195C7.49654 8.60253 8.12487 8.54064 8.69589 8.30412C9.26691 8.06759 9.75497 7.66706 10.0983 7.15315C10.4417 6.63925 10.625 6.03506 10.625 5.41699C10.624 4.58849 10.2945 3.7942 9.70863 3.20836C9.12279 2.62252 8.3285 2.29297 7.5 2.29199Z"
                                                fill="white" />
                                            <path
                                                d="M11.6667 18.959H3.33341C2.72582 18.9584 2.14328 18.7167 2.11364 18.2871C1.28401 17.8575 1.04237 17.2749 1.04175 16.6673C1.04175 14.9545 2.12218 13.3118 2.93335 12.1006C4.14452 10.8894 5.78723 10.209 7.50008 10.209C9.21294 10.209 10.8556 10.8894 12.0668 12.1006C13.278 13.3118 13.9584 14.9545 13.9584 16.6673C13.9578 17.2749 13.7162 17.8575 13.2865 18.2871C12.8569 18.7167 12.2743 18.9584 11.6667 18.959ZM7.50008 11.459C6.11922 11.4605 4.79536 12.0098 3.81894 12.9862C2.84252 13.9626 2.29329 15.2865 2.29175 16.6673C2.292 16.9435 2.40183 17.2083 2.59713 17.4036C2.79242 17.5989 3.05723 17.7087 3.33341 17.709H11.6667C11.9429 17.7087 12.2077 17.5989 12.403 17.4036C12.5983 17.2083 12.7082 16.9435 12.7084 16.6673C12.7069 15.2865 12.1576 13.9626 11.1812 12.9862C10.2048 12.0098 8.88094 11.4605 7.50008 11.459Z"
                                                fill="white" />
                                        </svg>
                                        @lang('index.register')
                                    </a>
                                @endguest
                                @auth

                                    @if (auth()->user()->role_id == 3)
                                        <a href="{{ route('user-home') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>
                                            @lang('index.customer_panel')
                                        </a>
                                    @elseif (auth()->user()->role_id == 2)
                                        <a href="{{ route('dashboard') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>
                                            @lang('index.agent_panel')
                                        </a>
                                    @elseif (auth()->user()->role_id == 1)
                                        <a href="{{ route('dashboard') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                            </svg>
                                            @lang('index.admin_panel')
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <header
            class="header-area {{ request()->url() == route('home') ? '' : 'bg-white others-page-header' }}  {{ count(getNotice()) ? 'header-area-marque' : 'header-area-skip header_area_m_38' }}"
            id="header">
            <div class="t-container header-container">
                <div class="d-flex justify-content-between align-items-center header-wrap w-100">
                    <div class="navbar-brand">
                        <button class="mobile-menu {{ request()->url() == route('home') ? '' : 'others_page_svg' }}"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop"
                            aria-controls="offcanvasWithBackdrop">
                            <svg viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="logo">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.75 6C15.75 5.80109 15.671 5.61032 15.5303 5.46967C15.3897 5.32902 15.1989 5.25 15 5.25H1C0.801088 5.25 0.610322 5.32902 0.46967 5.46967C0.329018 5.61032 0.25 5.80109 0.25 6C0.25 6.19891 0.329018 6.38968 0.46967 6.53033C0.610322 6.67098 0.801088 6.75 1 6.75H15C15.1989 6.75 15.3897 6.67098 15.5303 6.53033C15.671 6.38968 15.75 6.19891 15.75 6ZM15.75 1C15.75 0.801088 15.671 0.610322 15.5303 0.46967C15.3897 0.329018 15.1989 0.25 15 0.25H1C0.801088 0.25 0.610322 0.329018 0.46967 0.46967C0.329018 0.610322 0.25 0.801088 0.25 1C0.25 1.19891 0.329018 1.38968 0.46967 1.53033C0.610322 1.67098 0.801088 2.15 1 2.15H15C15.1989 2.15 15.3897 1.67098 15.5303 1.53033C15.671 1.38968 15.75 1.19891 15.75 1ZM15.75 11C15.75 10.8011 15.671 10.6103 15.5303 10.4697C15.3897 10.329 15.1989 10.25 15 10.25H1C0.801088 10.25 0.610322 10.329 0.46967 10.4697C0.329018 10.6103 0.25 10.8011 0.25 11C0.25 11.1989 0.329018 11.3897 0.46967 11.5303C0.610322 11.671 0.801088 12.15 1 12.15H15C15.1989 12.15 15.3897 11.671 15.5303 11.5303C15.671 11.3897 15.75 11.1989 15.75 11Z"
                                    fill="white" />
                            </svg>

                        </button>
                        <div class="offcanvas offcanvas-start mobile-menu-off-canvas" tabindex="-1"
                            id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel"
                            data-bs-scroll="false">
                            <div class="offcanvas-header">
                                <img loading="lazy" src="{{ asset(siteSetting()->logo) }}" alt="Logo">
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <!-- Mobile Menu -->
                                <div class="mobile-menu-list">
                                    <ul>
                                        <li>
                                            <a class="set_active" href="{{ url('/') }}">@lang('index.home')</a>
                                        </li>
                                        <li>
                                            <a class="set_active" href="#knowledge-article">@lang('index.articles')</a>
                                        </li>
                                        <li>
                                            <a class="set_active" href="#faq">@lang('index.faq')</a>
                                        </li>
                                        <li>
                                            <a class="set_active" href="{{ route('blogs') }}">@lang('index.blog')</a>
                                        </li>
                                        <li class="dropdown-list">
                                            <a href="javascript:void(0)"
                                                class="set_active dropdown-list-a">@lang('index.page')</a>
                                            <ul class="dropdown-body">
                                                <li>
                                                    <a class="dropdown-body-text" href="{{ route('about-us') }}">
                                                        @lang('index.about_us')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-body-text" href="{{ route('our-services') }}">
                                                        @lang('index.our_services')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-body-text"
                                                        href="{{ route('support-policy') }}">
                                                        @lang('index.support_policy')
                                                    </a>
                                                </li>
                                                @foreach (getAllPages() as $page)
                                                    <li>
                                                        <a class="dropdown-body-text"
                                                            href="{{ route('page-details', $page->slug) }}">
                                                            {{ $page->title ?? '' }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="set_active {{ urlPrefix() == 'forum' ? 'active' : '' }}"
                                                href="{{ route('forum') }}">@lang('index.forum')
                                            </a>
                                        </li>
                                        <li>
                                            <a class="set_active {{ urlPrefix() == 'contact' ? 'active' : '' }}"
                                                href="{{ route('contact') }}">
                                                @lang('index.contact')
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="ticket_btn_wrapper">
                                        <a href="{{ route('open-ticket') }}"
                                            class="gt-btn w-100 mt-3 ticket_btn d-none responsive_ticket_btn">
                                            @lang('index.open_ticket') <i class="bi bi-arrow-right-square ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Navbar Brand -->
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img loading="lazy" src="{{ asset(siteSetting()->logo) }}" alt="Logo">
                        </a>


                    </div>
                    <nav class="navbar navbar-expand-lg">
                        <div class="logo_icon">

                            <!-- Navbar Toggler -->
                            <button
                                class="navbar-toggler {{ request()->url() == route('home') ? '' : 'color-menu-toggler' }}"
                                id="navbarToggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                        <!-- Navbar -->
                        <div class="collapse navbar-collapse" id="navbarContent">
                            @yield('menu')
                        </div>

                    </nav>
                    <!-- Button -->
                    <div class="d-flex gap-3 button_sec">
                        <a href="{{ route('open-ticket') }}" class="gt-btn open_ticket_header_btn">
                            @lang('index.open_ticket')<i class="bi bi-arrow-right-square ms-1"></i>
                        </a>
                        <a href="javascript:void(0)" class="gt-btn header_last_section" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvas_right_button" aria-controls="offcanvasWithBackdrop">
                            <span><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 4.8001C6 4.13738 6.53728 3.6001 7.2 3.6001H22.8C23.4627 3.6001 24 4.13738 24 4.8001C24 5.46282 23.4627 6.0001 22.8 6.0001H7.2C6.53728 6.0001 6 5.46277 6 4.8001ZM22.8 10.8001H1.2C0.537281 10.8001 0 11.3374 0 12.0001C0 12.6628 0.537281 13.2001 1.2 13.2001H22.8C23.4627 13.2001 24 12.6628 24 12.0001C24 11.3374 23.4627 10.8001 22.8 10.8001ZM22.8 18.0001H12C11.3373 18.0001 10.8 18.5374 10.8 19.2001C10.8 19.8628 11.3373 20.4001 12 20.4001H22.8C23.4627 20.4001 24 19.8628 24 19.2001C24 18.5374 23.4627 18.0001 22.8 18.0001Z"
                                        fill="#1A1D1E" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
    </div>
    @yield('content')

    <!-- Help Wrapper -->
    <section class="cta-area mt-n150 mb-n116">
        <div class="container">
            <div class="cta-wrap style1">
                <div class="shape1_1 rotate360 d-none d-xl-block"><img
                        src="{{ asset('assets/frontend/img/shape/ctaShape1_1.png') }}" alt="shape"></div>
                <div class="shape1_2 d-none d-xl-block"><img
                        src="{{ asset('assets/frontend/img/shape/ctaShape1_2.png') }}" alt="shape">
                </div>
                <div class="shape1_3 d-none d-xl-block"><img
                        src="{{ asset('assets/frontend/img/shape/ctaShape1_3.png') }}" alt="shape">
                </div>
                <div class="cta-thumb d-xl-block">
                    <img src="{{ asset('assets/frontend/img/cta/1126.png') }}" alt="thumb">
                </div>
                <h3 class="cta-title text-white">@lang('index.contact_our_team_for_help')!</h3>
                <div class="btn-wrapper">
                    <a href="{{ route('ticket.create') }}" class="gt-btn style5 gt-btn-icon">@lang('index.open_ticket')</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Chatbox trigger -->
    @if (App\Model\ChatSetting::first()->chat_widget_show == 'on')
        @if (Auth::check())
            @if (authUserRole() == 3)
                <div class="chat-wrap-box" id="chatboxTrigger">
                    <div class="chatIcon">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <div class="close">
                        <i class="bi bi-x"></i>
                    </div>
                </div>
            @endif
        @else
            <div class="chat-wrap-box" id="chatboxTrigger">
                <div class="chatIcon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="close">
                    <i class="bi bi-x"></i>
                </div>
            </div>
        @endif
    @endif

    <!-- Chatbox Body -->
    <div class="chatbox-body shadow" id="chatboxBody">
        <!-- Chat Header -->
        <div class="chat-box-header d-flex align-items-center justify-content-between">
            <div class="user-info">
                <h2>@lang('index.hello_there') 👋🏻</h2>
                @if (!ipGroupMessage()['has_group'])
                    <p class="need_help_text">@lang('index.need_help'):</p>
                @endif
            </div>
            <div class="chat-close">
                <a href="javascript:void(0)" id="close-chat-" data-title="@lang('index.close_chat')"
                    class="btn btn-danger btn-sm chat-close-btn {{ showCloseChatButton() ? '' : 'd-none' }}">@lang('index.close_chat')</a>
                <form action="{{ route('guest-close-chat', ipGroupMessage()['group_id']) }}" method="get"
                    class="guest-close-chat-form">
                    <input type="hidden" name="group_id" id="group_id"
                        value="{{ ipGroupMessage()['group_id'] }}">
                </form>
            </div>
        </div>

        <!-- Chat Content -->
        <div
            class="chatbox-content set-chat-box {{ ipGroupMessage()['has_group'] ? 'trigger_to_large' : 'trigger_to_small' }} {{ !ipGroupMessage()['has_group'] ? 'p-0' : '' }}">
            <!-- Single User Chat -->
            @foreach (ipGroupMessage()['messages'] as $message)
                @if ($message->message_type == 'outgoing_message')
                    <div class="user-chat d-flex">
                        <!-- Status -->
                        <div class="chat-text">
                            <!-- for sometimes showing html content that's why we skip the scape -->
                            <span><span>{!! $message->message !!}</span></span>
                        </div>
                    </div>

                    <!-- Single User Chat -->
                @elseif($message->message_type == 'incoming_message')
                    <div class="agent-chat d-flex">
                        <div class="chat-text">
                            <span>
                                @if (ipGroupMessage()['has_group'] && isset(ipGroupMessage()['agent_image']))
                                    <img loading="lazy" src="{{ asset(ipGroupMessage()['agent_image']) }}"
                                        alt="" id="agent-photo">
                                @else
                                    <img loading="lazy" src="{{ asset('assets/frontend/img/bg-img/u4.png') }}"
                                        alt="" id="agent-photo">
                                @endif
                                <!-- for sometimes showing html content that's why we skip the scape -->
                                <span>{!! $message->message !!}</span>
                            </span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <i class="ai_is_replying"><span class="typing_name">{{ ipGroupMessage()['agent_name'] }}</span><span
                class="animated-dots"></span></i>
        <!-- Chat Footer -->
        <div class="chat-box-footer custom-select-item">
            @if (!ipGroupMessage()['has_group'])
                <input type="text" class="form-control guest-user-name mb-2" placeholder="@lang('index.name')"
                    maxlength="100">
                <input type="text" class="form-control guest-user-email bottom_margin_chat mb-2"
                    placeholder="@lang('index.email')" maxlength="100">
                <p class="text-danger invalid-email-error d-none"></p>
                <select id="chatSelect"
                    class="is-empty chat-select mb-2 form-select-menu customer-product-category chat-box-product"
                    aria-label="Default select example">
                    <option value="">
                        @lang('index.select_product_category')
                    </option>
                    @foreach (getAllProductCategory() as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                <!-- Sending Box -->
                <div class="chatbox-sending-box before_send">
                    <input type="text" class="form-control mb-2 message-box" placeholder="@lang('index.type_your_message_here')"
                        data-id={{ ipGroupMessage()['group_id'] }} maxlength="1000">
                    <div class="d-flex justify-content-between">
                        <div class="file-share d-flex align-items-center">

                        </div>
                        <button class="gt-btn send-btn customer-send-message customer-send-message-first-time"
                            type="button">
                            @lang('index.submit')</button>
                    </div>
                </div>
            @else
                <!-- Sending Box -->
                <div class="chatbox-sending-box chatbox-sending-box-non-group">
                    <input type="text" class="form-control mb-2 message-box group-message-box"
                        placeholder="@lang('index.type_your_message_here')" data-id={{ ipGroupMessage()['group_id'] }} maxlength="1000">
                    <button type="button" class="send_btn_with_icon send-btn customer-send-message">
                        <img loading="lazy" src="{{ asset('assets/frontend/img/core-img/send_chat.png') }}"
                            alt="" class="send_icon">
                    </button>
                </div>
            @endif

            <input type="hidden" class="selected-product-category"
                value="{{ ipGroupMessage()['product_id'] != 0 ? ipGroupMessage()['product_id'] : '' }}">
            <input type="hidden" class="selected-guest-name"
                value="{{ ipGroupMessage()['guest_name'] != 0 ? ipGroupMessage()['guest_name'] : '' }}">
            <input type="hidden" class="selected-guest-email"
                value="{{ ipGroupMessage()['guest_email'] != 0 ? ipGroupMessage()['guest_email'] : '' }}">

        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-wrap">
        <div class="row justify-content-between footer_first_row">
            <div class="first_card">
                <div class="">
                    <a class="mb-4 d-block footer-logo" href="{{ route('home') }}">
                        <img loading="lazy" src="{{ asset(siteSetting()->logo) }}" alt="">
                    </a>
                    <div class="footer-text-sec">

                        <p class="footer-text">{{ siteSetting()->footer_text ?? '' }}</p>

                        <div class="footer-contact-info">
                            <div class="d-flex">
                                <a href="mailto:{{ siteSetting()->email ?? '' }}">
                                    <div class="footer-icon"><i class="bi bi-envelope"></i></div>
                                    {{ siteSetting()->email ?? '' }}
                                </a>
                            </div>
                            <div class="d-flex">
                                <a href="tel:{{ siteSetting()->phone ?? '' }}">
                                    <div class="footer-icon"><i class="bi bi-telephone"></i></div>
                                    {{ siteSetting()->phone ?? '' }}
                                </a>
                            </div>
                            <div class="d-flex">
                                <a href="tel:{{ siteSetting()->phone ?? '' }}">
                                    <div class="footer-icon"><i class="bi bi-whatsapp"></i></div>
                                    {{ siteSetting()->phone ?? '' }}
                                </a>
                            </div>
                            <div class="address-info">
                                <div class="footer-icon"><i class="bi bi-geo-alt"></i></div>
                                <span>{{ siteSetting()->address ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="second_card">
                <div class="quick-links-nav">
                    <h5 class="text-white footer-sec-title">
                        @lang('index.business_hour')
                    </h5>

                    <ul class="business_hour">
                        @foreach (chatSchedules() ?? [] as $schedule)
                            <li><a href="#">{{ $schedule }} <br /><span
                                        class="">{{ chatScheduleTime()['start_time'] . ' - ' . chatScheduleTime()['end_time'] }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="third_card">
                <div class="quick-links-nav">
                    <h5 class="mb-3 text-white footer-sec-title">
                        @lang('index.recent_posts')
                    </h5>

                    <ul class="recent_posts">
                        @foreach (recentBlogs() as $blog)
                            <li>
                                <a href="{{ route('blog-details', $blog->slug) }}" class="image_sec">
                                    <img loading="lazy" class="footer_blog_image"
                                        src="{{ $blog->thumb_img == null ? asset($blog->image) : asset($blog->thumb_img) }}"
                                        alt="">
                                </a>
                                <div class="content_blog">
                                    <p class="m-0 date_sec">
                                        <i class="bi bi-clock"></i>
                                        {{ date('d M Y', strtotime($blog->created_at)) }}
                                    </p>
                                    <a href="{{ route('blog-details', $blog->slug) }}" class="m-0 post_title">
                                        {{ titleGenerate($blog->title) }}
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="fourth_card">
                <div class="quick-links-nav">
                    <h5 class="mb-3 text-white footer-sec-title">@lang('index.important_links')</h5>
                    <ul class="footer-link">
                        <li><a href="{{ route('about-us') }}">@lang('index.about_us')</a></li>
                        <li><a href="{{ route('contact') }}">@lang('index.contact_us')</a></li>
                        <li><a href="{{ route('support-policy') }}">@lang('index.support_policy')</a></li>
                        <li><a href="{{ route('our-services') }}">@lang('index.our_services')</a></li>
                        <li><a href="{{ route('forum') }}">@lang('index.forum')</a></li>
                        <li><a href="{{ route('customer.login') }}">@lang('index.login_as_customer')</a></li>
                    </ul>
                </div>
            </div>
            <div class="fifth_card">
                <div class="quick-links-nav footer-quick-links">
                    <h5 class="mb-3 text-white footer-sec-title">@lang('index.quick_links')</h5>
                    @yield('footer_menu')
                </div>
            </div>
        </div>
        <div class="subscriber-card">
            <div class="bg_img">
                <img loading="lazy" src="{{ asset('assets/frontend/img/shape/123.png') }}" alt="">
            </div>
            <div class="row justify-content-between">
                <div class="col-12 col-md-8">
                    <div class="text-center text-md-start">
                        <p class="subscriber_text">
                            @lang('index.need_more_help')
                        </p>
                        <p class="subscriber_text_description">
                            @lang('index.need_more_help_description')
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="subscribe-form">
                        <form id="subscribe_form" method="post">
                            <div class="input-group">
                                <input type="email" class="form-control" id="email"
                                    placeholder="@lang('index.enter_your_email')" aria-label="Enter your email" required>
                                <button class="gt-btn" type="submit">@lang('index.subscribe')<i
                                        class="bi bi-arrow-right-square ms-1"></i></button>
                            </div>
                        </form>
                        <p class="success_msg d-none"></p>
                        <p class="error_msg d-none"></p>
                    </div>
                </div>
            </div>
            <div class="scroll-to-top" id="scrollToTopButton">
                <svg width="24" height="24" viewBox="0 0 32 32" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.0947 2.29511L6.1347 11.2551C5.90154 11.4965 5.77252 11.8199 5.77544 12.1555C5.77835 12.4911 5.91297 12.8121 6.15029 13.0494C6.38762 13.2868 6.70866 13.4214 7.04427 13.4243C7.37988 13.4272 7.70321 13.2982 7.94462 13.065L14.7197 6.28999L14.7197 28.8001C14.7197 29.1396 14.8545 29.4651 15.0946 29.7052C15.3346 29.9452 15.6602 30.0801 15.9997 30.0801C16.3391 30.0801 16.6647 29.9452 16.9048 29.7052C17.1448 29.4651 17.2797 29.1396 17.2797 28.8001L17.2797 6.28999L24.0547 13.065C24.1728 13.1873 24.314 13.2848 24.4702 13.3519C24.6263 13.419 24.7943 13.4543 24.9643 13.4558C25.1342 13.4572 25.3028 13.4248 25.4601 13.3605C25.6174 13.2961 25.7603 13.2011 25.8805 13.0809C26.0007 12.9607 26.0957 12.8178 26.1601 12.6605C26.2244 12.5032 26.2568 12.3346 26.2553 12.1647C26.2539 11.9947 26.2186 11.8268 26.1515 11.6706C26.0844 11.5144 25.9869 11.3732 25.8646 11.2551L16.9046 2.29511C16.6646 2.05515 16.3391 1.92035 15.9997 1.92035C15.6603 1.92035 15.3347 2.05515 15.0947 2.29511Z"
                        fill="white" />
                </svg>

            </div>
        </div>
        <div class="copyright-card">
            <div class="text-center text-md-start">
                <p class="mb-0 text-white">
                    {{ siteSetting()->footer ?? '#' }}
                </p>
            </div>
            <div class="footer-social-icon d-flex align-items-center justify-content-center justify-content-md-end">
                <a target="_blank" href="{{ route('about-us') }}">
                    @lang('index.about_us')
                </a>
                <a target="_blank" href="{{ route('our-services') }}">
                    @lang('index.our_services')
                </a>
                <a target="_blank" href="{{ route('support-policy') }}">
                    @lang('index.support_policy')
                </a>
            </div>
        </div>
    </footer>

    @if (gdprSetting()->enable_gdpr == 'on' && gdprSetting()->view_cookie_notification_bar == 'on')
        <div class="cookies-area">
            <div class="w-50 text-sec">
                <p>{!! gdprSetting()->cookie_message ?? '' !!}</p>
            </div>
            <div class="cookies-btn">
                <a class="btn accept-btn btn-sm cookie-agreement" href="javascript:void(0)" data-text="accept">
                    @lang('index.accept_all')
                </a>
                <a class="btn reject-btn btn-sm cookie-agreement" href="javascript:void(0)" data-text="reject">
                    @lang('index.reject_all')
                </a>
            </div>
        </div>
    @endif
    @include('frontend.__offcanvas_header')
    <!-- All JavaScript Files -->
    <script src="{{ asset('assets/frontend/js/jquery.min.js?var=2.1') }}"></script>
    <script src="{{ asset('assets/frontend/js/set_browser_cookie.js?var=2.1') }}" defer></script>
    <script src="{{ asset('frequent_changing/sweetalert2/sweetalert.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/app.js?var=2.1') }}" defer></script>
    <script src="{{ asset('js/app.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/nice-select2.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/imagesloaded.pkgd.min.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/isotope.pkgd.min.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/slick.js') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/index.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/wow.min.js?var=2.1') }}" defer></script>
    <script src="{{ asset('frequent_changing/js/jquery.magnific-popup.min.js?var=2.2') }}"></script>
    <script src="{{ asset('assets/frontend/js/custom.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/js/global.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/owl.carousel.min.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/plugin/aos-master/dist/aos.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/chat.js?var=2.1') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/main.js?var=2.1') }}" defer></script>
    @stack('js')
</body>

</html>
