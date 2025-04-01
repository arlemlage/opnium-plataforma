<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Quick Rabbit">
    <!-- Title -->
    <title>{{ siteSetting()->title ?? 'Quick Rabbit' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(siteSetting()->icon ?? '') }}">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap-icons.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick-theme.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select2.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.min.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.theme.default.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/plugin/aos-master/dist/aos.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/simple-notify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/new-design.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/new-design_v1.css?var=2.5.1') }}">    
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/second_page.css?var=2.5') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css?var=2.5') }}">
    @stack('css')


<body class="second_page">

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
        class="top_hero_sec second_top_hero_sec {{ request()->url() == route('home') ? 'second_top_hero_home' : 'sh-640' }}">
        <!-- Top Header -->
        <div class="top-header {{ count(getNotice()) ? 'top-header-marque' : 'top-header-skip top_header_m_0' }}">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-3 col-sm-5 col-md-6 left-col">
                        <div class="contact-info d-flex align-items-center">
                            <a href="tel:{{ siteSetting()->phone ?? '' }}">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3.65398 1.32805C3.59495 1.25211 3.52043 1.1896 3.43538 1.14468C3.35034 1.09975 3.2567 1.07343 3.1607 1.06747C3.0647 1.06151 2.96853 1.07605 2.87858 1.11012C2.78863 1.14418 2.70695 1.19699 2.63898 1.26505L1.60498 2.30005C1.12198 2.78405 0.943983 3.46905 1.15498 4.07005C2.03171 6.55716 3.45614 8.81546 5.32298 10.6781C7.18557 12.5449 9.44387 13.9693 11.931 14.8461C12.532 15.0571 13.217 14.8791 13.701 14.3961L14.735 13.3621C14.803 13.2941 14.8559 13.2124 14.8899 13.1225C14.924 13.0325 14.9385 12.9363 14.9326 12.8403C14.9266 12.7443 14.9003 12.6507 14.8554 12.5656C14.8104 12.4806 14.7479 12.4061 14.672 12.3471L12.365 10.5531C12.2838 10.4903 12.1894 10.4467 12.089 10.4255C11.9885 10.4044 11.8846 10.4063 11.785 10.4311L9.59498 10.9781C9.30264 11.0506 8.99651 11.0465 8.70623 10.9661C8.41594 10.8857 8.15132 10.7317 7.93798 10.5191L5.48198 8.06205C5.26916 7.84881 5.115 7.58424 5.03441 7.29395C4.95382 7.00366 4.94954 6.69748 5.02198 6.40505L5.56998 4.21505C5.59474 4.11544 5.59663 4.01151 5.5755 3.91106C5.55437 3.81061 5.51078 3.71625 5.44798 3.63505L3.65398 1.32805ZM1.88398 0.511051C2.05898 0.336 2.26921 0.200181 2.50072 0.112612C2.73223 0.0250429 2.97973 -0.0122724 3.22676 0.00314389C3.4738 0.0185602 3.71474 0.0863553 3.93356 0.202028C4.15239 0.3177 4.34411 0.478602 4.49598 0.674051L6.28998 2.98005C6.61898 3.40305 6.73498 3.95405 6.60498 4.47405L6.05798 6.66405C6.0299 6.77749 6.03153 6.89625 6.0627 7.00888C6.09388 7.12151 6.15356 7.2242 6.23598 7.30705L8.69298 9.76405C8.77593 9.84664 8.87879 9.90642 8.99161 9.9376C9.10443 9.96878 9.2234 9.97032 9.33698 9.94205L11.526 9.39505C11.7826 9.33126 12.0504 9.32647 12.3091 9.38102C12.5679 9.43558 12.8109 9.54807 13.02 9.71005L15.326 11.5041C16.155 12.149 16.231 13.3741 15.489 14.1151L14.455 15.1491C13.715 15.8891 12.609 16.2141 11.578 15.8511C8.93865 14.9236 6.54252 13.4128 4.56798 11.4311C2.58636 9.4568 1.07553 7.06102 0.147983 4.42205C-0.214017 3.39205 0.110983 2.28505 0.850983 1.54505L1.88398 0.511051Z"
                                        fill="black" />
                                </svg>
                                <span class="d-none d-md-inline-block">
                                    {{ siteSetting()->phone ?? '' }}
                                </span>
                            </a>
                            <a href="mailto:{{ siteSetting()->email ?? '' }}">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0 4C0 3.46957 0.210714 2.96086 0.585786 2.58579C0.960859 2.21071 1.46957 2 2 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V12C16 12.5304 15.7893 13.0391 15.4142 13.4142C15.0391 13.7893 14.5304 14 14 14H2C1.46957 14 0.960859 13.7893 0.585786 13.4142C0.210714 13.0391 0 12.5304 0 12V4ZM2 3C1.73478 3 1.48043 3.10536 1.29289 3.29289C1.10536 3.48043 1 3.73478 1 4V4.217L8 8.417L15 4.217V4C15 3.73478 14.8946 3.48043 14.7071 3.29289C14.5196 3.10536 14.2652 3 14 3H2ZM15 5.383L10.292 8.208L15 11.105V5.383ZM14.966 12.259L9.326 8.788L8 9.583L6.674 8.788L1.034 12.258C1.09083 12.4708 1.21632 12.6589 1.39099 12.7931C1.56566 12.9272 1.77975 13 2 13H14C14.2201 13 14.4341 12.9274 14.6088 12.7934C14.7834 12.6595 14.909 12.4716 14.966 12.259ZM1 11.105L5.708 8.208L1 5.383V11.105Z"
                                        fill="black" />
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
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19.6917 4.92188H12.8906C12.2162 4.92262 11.5695 5.19088 11.0926 5.66779C10.6157 6.1447 10.3475 6.79132 10.3467 7.46578V8.87812H4.50796C3.8335 8.87887 3.18688 9.14713 2.70997 9.62404C2.23305 10.101 1.96479 10.7476 1.96405 11.422V15.2836C1.96483 15.8973 2.18706 16.4901 2.58991 16.953C2.99276 17.416 3.54916 17.718 4.15686 17.8036L4.16108 20.2819C4.16108 20.3448 4.17798 20.4065 4.21002 20.4607C4.24205 20.5148 4.28805 20.5594 4.34319 20.5896C4.39834 20.6199 4.4606 20.6348 4.52348 20.6328C4.58635 20.6308 4.64753 20.6119 4.70061 20.5781L9.04171 17.8275H11.31C11.9845 17.8269 12.6312 17.5587 13.1081 17.0817C13.5851 16.6048 13.8533 15.9581 13.8539 15.2836V13.875H15.158L19.5 16.6238C19.5531 16.6574 19.6142 16.6761 19.6771 16.6781C19.7399 16.68 19.8021 16.6651 19.8572 16.6348C19.9123 16.6046 19.9582 16.5601 19.9903 16.5061C20.0224 16.452 20.0394 16.3903 20.0395 16.3275L20.0433 13.8492C20.651 13.7637 21.2075 13.4617 21.6103 12.9988C22.0132 12.5358 22.2354 11.9429 22.2361 11.3292V7.46766C22.236 6.79275 21.9679 6.14551 21.4908 5.66815C21.0137 5.19079 20.3666 4.92237 19.6917 4.92188ZM13.1508 15.2812C13.1503 15.7693 12.9562 16.2372 12.6111 16.5823C12.266 16.9274 11.798 17.1215 11.31 17.122H8.93999C8.87357 17.1223 8.80858 17.1413 8.75249 17.1769L4.86186 19.6406L4.85858 17.4731C4.85846 17.38 4.82136 17.2907 4.75545 17.2248C4.68953 17.159 4.60018 17.122 4.50702 17.122C4.01953 17.1213 3.55221 16.9274 3.20737 16.5828C2.86253 16.2383 2.66829 15.7711 2.66718 15.2836V11.422C2.66767 10.934 2.86177 10.4661 3.20688 10.121C3.55198 9.77584 4.0199 9.58175 4.50796 9.58125H11.31C11.798 9.58175 12.266 9.77584 12.6111 10.121C12.9562 10.4661 13.1503 10.934 13.1508 11.422V15.2812ZM21.5325 11.3269C21.5328 11.5689 21.4854 11.8086 21.3931 12.0323C21.3007 12.256 21.1652 12.4594 20.9943 12.6307C20.8233 12.802 20.6203 12.938 20.3968 13.0308C20.1733 13.1237 19.9337 13.1716 19.6917 13.1719C19.5986 13.172 19.5093 13.209 19.4434 13.2748C19.3775 13.3406 19.3404 13.4298 19.3401 13.523L19.3369 15.6905L15.4462 13.2267C15.3902 13.1911 15.3252 13.1721 15.2587 13.1719H13.8525V11.422C13.8605 9.91125 12.5362 8.75672 11.0475 8.87812V7.46766C11.0476 6.97891 11.2419 6.51022 11.5875 6.16467C11.9331 5.81912 12.4019 5.625 12.8906 5.625H19.6917C20.1798 5.6255 20.6477 5.81959 20.9928 6.1647C21.3379 6.50981 21.532 6.97773 21.5325 7.46578V11.3269Z"
                                            fill="black" />
                                        <path
                                            d="M8.22234 11.018C8.10093 10.7653 7.71702 10.7644 7.59562 11.018L5.42624 15.2893C5.22983 15.7111 5.82702 16.0158 6.05296 15.6075L6.80296 14.1357H9.01968L9.76499 15.6094C9.9914 16.0177 10.5886 15.7116 10.3922 15.2911L8.22234 11.018ZM7.1578 13.4325L7.9078 11.9536L8.6578 13.4325H7.1578ZM18.3459 11.0503L16.9767 10.1293C17.2636 9.68008 17.5021 9.20179 17.6883 8.70238H18.1495C18.615 8.68644 18.615 8.01519 18.1495 7.99925H16.7269V7.26941C16.7269 7.17617 16.6898 7.08675 16.6239 7.02082C16.558 6.95489 16.4685 6.91785 16.3753 6.91785C16.2821 6.91785 16.1926 6.95489 16.1267 7.02082C16.0608 7.08675 16.0237 7.17617 16.0237 7.26941V7.99925H14.43C14.3368 7.99925 14.2473 8.03629 14.1814 8.10222C14.1155 8.16815 14.0784 8.25757 14.0784 8.35082C14.0784 8.44406 14.1155 8.53348 14.1814 8.59941C14.2473 8.66534 14.3368 8.70238 14.43 8.70238H16.9298C16.7801 9.06195 16.5999 9.40805 16.3912 9.73691L15.5067 9.14066C15.4293 9.08863 15.3344 9.06948 15.2429 9.08741C15.1514 9.10534 15.0708 9.15889 15.0187 9.23628C14.9667 9.31367 14.9476 9.40856 14.9655 9.50007C14.9834 9.59158 15.037 9.67222 15.1144 9.72425L15.9844 10.3125C15.7119 10.6573 15.4082 10.9763 15.0773 11.2655C15.0072 11.327 14.9643 11.4138 14.9581 11.5069C14.952 11.6 14.983 11.6917 15.0445 11.7619C15.106 11.8321 15.1928 11.875 15.2859 11.8811C15.379 11.8873 15.4707 11.8562 15.5409 11.7947C15.9175 11.4652 16.262 11.1008 16.5698 10.7063L17.9531 11.6335C18.0109 11.6727 18.0792 11.6936 18.1491 11.6935C18.4903 11.6963 18.6337 11.243 18.3459 11.0503Z"
                                            fill="black" />
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
                                            <path
                                                d="M6.66669 7.33337V5.33337L10 8.00004L6.66669 10.6667V8.66671H0.666687V7.33337H6.66669ZM1.63855 10H3.05437C3.84555 11.9546 5.76177 13.3334 8.00002 13.3334C10.9456 13.3334 13.3334 10.9456 13.3334 8.00004C13.3334 5.05452 10.9456 2.66671 8.00002 2.66671C5.76177 2.66671 3.84555 4.04549 3.05437 6.00004H1.63855C2.48807 3.2953 5.01493 1.33337 8.00002 1.33337C11.6819 1.33337 14.6667 4.31814 14.6667 8.00004C14.6667 11.6819 11.6819 14.6667 8.00002 14.6667C5.01493 14.6667 2.48807 12.7048 1.63855 10Z"
                                                fill="black" />
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
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.33335 9.50129V10.8942C8.91629 10.7468 8.46755 10.6666 8.00002 10.6666C5.79088 10.6666 4.00002 12.4575 4.00002 14.6666H2.66669C2.66669 11.7211 5.0545 9.33329 8.00002 9.33329C8.46042 9.33329 8.90722 9.39163 9.33335 9.50129ZM8.00002 8.66663C5.79002 8.66663 4.00002 6.87663 4.00002 4.66663C4.00002 2.45663 5.79002 0.666626 8.00002 0.666626C10.21 0.666626 12 2.45663 12 4.66663C12 6.87663 10.21 8.66663 8.00002 8.66663ZM8.00002 7.33329C9.47335 7.33329 10.6667 6.13996 10.6667 4.66663C10.6667 3.19329 9.47335 1.99996 8.00002 1.99996C6.52669 1.99996 5.33335 3.19329 5.33335 4.66663C5.33335 6.13996 6.52669 7.33329 8.00002 7.33329ZM12 11.3333V9.33329H13.3334V11.3333H15.3334V12.6666H13.3334V14.6666H12V12.6666H10V11.3333H12Z"
                                                fill="black" />
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
            class="header-area second-header-area {{ count(getNotice()) ? 'header-area-marque' : 'header-area-skip header_area_m_38' }}"
            id="header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center header-wrap w-100">
                    <div class="navbar-brand">
                        <button class="mobile-menu {{ request()->url() == route('home') ? '' : 'others_page_svg' }}"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop"
                            aria-controls="offcanvasWithBackdrop">
                            <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_54_1458)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.75 6C15.75 5.80109 15.671 5.61032 15.5303 5.46967C15.3897 5.32902 15.1989 5.25 15 5.25H1C0.801088 5.25 0.610322 5.32902 0.46967 5.46967C0.329018 5.61032 0.25 5.80109 0.25 6C0.25 6.19891 0.329018 6.38968 0.46967 6.53033C0.610322 6.67098 0.801088 6.75 1 6.75H15C15.1989 6.75 15.3897 6.67098 15.5303 6.53033C15.671 6.38968 15.75 6.19891 15.75 6ZM15.75 1C15.75 0.801088 15.671 0.610322 15.5303 0.46967C15.3897 0.329018 15.1989 0.25 15 0.25H1C0.801088 0.25 0.610322 0.329018 0.46967 0.46967C0.329018 0.610322 0.25 0.801088 0.25 1C0.25 1.19891 0.329018 1.38968 0.46967 1.53033C0.610322 1.67098 0.801088 2.15 1 2.15H15C15.1989 2.15 15.3897 1.67098 15.5303 1.53033C15.671 1.38968 15.75 1.19891 15.75 1ZM15.75 11C15.75 10.8011 15.671 10.6103 15.5303 10.4697C15.3897 10.329 15.1989 10.25 15 10.25H1C0.801088 10.25 0.610322 10.329 0.46967 10.4697C0.329018 10.6103 0.25 10.8011 0.25 11C0.25 11.1989 0.329018 11.3897 0.46967 11.5303C0.610322 11.671 0.801088 12.15 1 12.15H15C15.1989 12.15 15.3897 11.671 15.5303 11.5303C15.671 11.3897 15.75 11.1989 15.75 11Z"
                                        fill="#5065E2" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_54_1458">
                                        <rect width="16" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <div class="offcanvas offcanvas-start mobile-menu-off-canvas" tabindex="-1"
                            id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel"
                            data-bs-scroll="false">
                            <div class="offcanvas-header">
                                <img src="{{ asset(siteSetting()->logo) }}" alt="Logo">
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

                                    <a href="{{ route('open-ticket') }}"
                                        class="btn btn-primary w-100 mt-3 ticket_btn d-none responsive_ticket_btn">
                                        @lang('index.open_ticket')
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Navbar Brand -->
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset(siteSetting()->logo) }}" alt="Logo">
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
                            @lang('index.open_ticket')<i class="bi bi-arrow-right ms-2"></i>
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
        @yield('content')


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
                    <p>@lang('index.need_help')</p>
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
                class="chatbox-content set-chat-box {{ ipGroupMessage()['has_group'] ? 'trigger_to_large' : 'trigger_to_small' }}">
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
                                        <img src="{{ asset(ipGroupMessage()['agent_image']) }}" alt=""
                                            id="agent-photo">
                                    @else
                                        <img src="{{ asset('assets/frontend/img/bg-img/u4.png') }}" alt=""
                                            id="agent-photo">
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
                    <button class="start_new_conversation_btn">
                        @lang('index.start_new_conversation')
                    </button>
                    <input type="text" class="form-control guest-user-name mb-2" placeholder="@lang('index.name')"
                        maxlength="100">
                    <input type="text" class="form-control guest-user-email bottom_margin_chat mb-2"
                        placeholder="@lang('index.email')" maxlength="100">
                    <p class="text-danger invalid-email-error d-none"></p>
                    @if (appTheme() == 'multiple')
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
                    @endif
                    @if (appTheme() == 'single')
                        <input type="hidden" name="customer-product-categor" value="{{ getSingleProduct()->id }}"
                            class="is-empty chat-select mb-2 form-select-menu customer-product-category chat-box-product">
                        <select class="is-empty chat-select mb-2 form-select-menu department chat-box-product"
                            aria-label="Default select example">
                            <option value="">
                                @lang('index.department')
                            </option>
                            @foreach (getAllDepartment() as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    @endif
                    <!-- Sending Box -->
                    <div class="chatbox-sending-box">
                        <input type="text" class="form-control mb-2 message-box" placeholder="@lang('index.type_your_message_here')"
                            data-id={{ ipGroupMessage()['group_id'] }} maxlength="1000">
                        <div class="d-flex justify-content-between">
                            <div class="file-share d-flex align-items-center">

                            </div>
                            <button class="btn btn-primary send-btn customer-send-message" type="button">
                                @lang('index.submit')</button>
                        </div>
                    </div>
                @else
                    <!-- Sending Box -->
                    <div class="chatbox-sending-box chatbox-sending-box-non-group">
                        <input type="text" class="form-control mb-2 message-box group-message-box"
                            placeholder="@lang('index.type_your_message_here')" data-id={{ ipGroupMessage()['group_id'] }}
                            maxlength="1000">
                        <button type="button" class="send_btn_with_icon send-btn customer-send-message">
                            <img src="{{ asset('assets/frontend/img/core-img/send_chat.png') }}" alt=""
                                class="send_icon">
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
        <footer class="footer-wrap second-footer-wrap">
            <div class="container">
                <div class="row justify-content-between footer_first_row">
                    <div class="first_card">
                        <div class="">
                            <a class="mb-4 d-block footer-logo" href="{{ route('home') }}">
                                <img loading="lazy" src="{{ asset(siteSetting()->logo) }}" alt="">
                            </a>
                            <div class="footer-text-sec">

                                <p class="footer-text">{{ siteSetting()->footer_text ?? '' }}</p>
                                <div class="social-icons-off-canvas social_icons_footer">
                                    <a target="_blank" href="{{ siteSetting()->facebook_url ?? '#' }}">
                                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
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
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.3553 5.23856C14.3655 5.38069 14.3655 5.52284 14.3655 5.66497C14.3655 9.99997 11.066 14.9949 5.03553 14.9949C3.17766 14.9949 1.45178 14.4568 0 13.5228C0.263969 13.5533 0.51775 13.5634 0.791875 13.5634C2.32484 13.5634 3.73603 13.0457 4.86294 12.1624C3.42131 12.132 2.21319 11.1878 1.79694 9.88831C2 9.91875 2.20303 9.93906 2.41625 9.93906C2.71066 9.93906 3.00509 9.89844 3.27919 9.82741C1.77666 9.52281 0.649719 8.20303 0.649719 6.60913V6.56853C1.08625 6.81219 1.59391 6.96447 2.13194 6.98475C1.24869 6.39591 0.670031 5.39084 0.670031 4.25378C0.670031 3.64466 0.832437 3.08628 1.11672 2.59897C2.73094 4.58881 5.15734 5.88828 7.87812 6.03044C7.82737 5.78678 7.79691 5.533 7.79691 5.27919C7.79691 3.47206 9.25884 2 11.0761 2C12.0202 2 12.873 2.39594 13.472 3.03553C14.2131 2.89341 14.9238 2.61928 15.5532 2.24366C15.3096 3.00509 14.7918 3.64469 14.1116 4.05075C14.7715 3.97972 15.4111 3.79694 15.9999 3.54316C15.5533 4.19287 14.9949 4.77153 14.3553 5.23856Z"
                                                fill="#2D2C2B" />
                                        </svg>
                                    </a>
                                    <a target="_blank" href="{{ siteSetting()->instagram_url ?? '#' }}">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
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
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.375 0.203125C5.16875 0.203125 2 2.34063 2 5.8C2 8 3.2375 9.25 3.9875 9.25C4.29688 9.25 4.475 8.3875 4.475 8.14375C4.475 7.85313 3.73438 7.23438 3.73438 6.025C3.73438 3.5125 5.64687 1.73125 8.12187 1.73125C10.25 1.73125 11.825 2.94063 11.825 5.1625C11.825 6.82188 11.1594 9.93438 9.00313 9.93438C8.225 9.93438 7.55937 9.37188 7.55937 8.56563C7.55937 7.38438 8.38438 6.24063 8.38438 5.02188C8.38438 2.95313 5.45 3.32813 5.45 5.82813C5.45 6.35313 5.51562 6.93438 5.75 7.4125C5.31875 9.26875 4.4375 12.0344 4.4375 13.9469C4.4375 14.5375 4.52187 15.1188 4.57812 15.7094C4.68438 15.8281 4.63125 15.8156 4.79375 15.7563C6.36875 13.6 6.3125 13.1781 7.025 10.3563C7.40938 11.0875 8.40313 11.4813 9.19063 11.4813C12.5094 11.4813 14 8.24688 14 5.33125C14 2.22813 11.3188 0.203125 8.375 0.203125Z"
                                                fill="#2D2C2B" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
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
                    <div class="second_card">
                        <div class="quick-links-nav">
                            <h5 class="text-white footer-sec-title">
                                @lang('index.information')
                            </h5>
                            <ul class="footer-link">
                                <li>
                                    <p>
                                        <svg class="me-2" width="17" height="16" viewBox="0 0 17 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_139_184)">
                                                <path
                                                    d="M8.53943 16C8.53943 16 14.5394 10.314 14.5394 6C14.5394 4.4087 13.9073 2.88258 12.7821 1.75736C11.6569 0.632141 10.1307 0 8.53943 0C6.94813 0 5.42201 0.632141 4.29679 1.75736C3.17157 2.88258 2.53943 4.4087 2.53943 6C2.53943 10.314 8.53943 16 8.53943 16ZM8.53943 9C7.74378 9 6.98072 8.68393 6.41811 8.12132C5.8555 7.55871 5.53943 6.79565 5.53943 6C5.53943 5.20435 5.8555 4.44129 6.41811 3.87868C6.98072 3.31607 7.74378 3 8.53943 3C9.33508 3 10.0981 3.31607 10.6607 3.87868C11.2234 4.44129 11.5394 5.20435 11.5394 6C11.5394 6.79565 11.2234 7.55871 10.6607 8.12132C10.0981 8.68393 9.33508 9 8.53943 9Z"
                                                    fill="#B6B6B6" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_139_184">
                                                    <rect width="16" height="16" fill="white"
                                                        transform="translate(0.539429)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        {{ siteSetting()->address ?? '' }}
                                    </p>
                                </li>
                                <li>
                                    <a href="tel:{{ siteSetting()->phone ?? '' }}">
                                        <svg class="me-2" width="17" height="16" viewBox="0 0 17 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_139_188)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M2.42441 0.511147C2.59939 0.336436 2.80949 0.200905 3.04081 0.113537C3.27212 0.0261686 3.51937 -0.0110424 3.76615 0.00436978C4.01293 0.019782 4.25363 0.0874655 4.47227 0.202935C4.69092 0.318404 4.88253 0.479023 5.03441 0.674147L6.82941 2.98015C7.15841 3.40315 7.27441 3.95415 7.14441 4.47415L6.59741 6.66415C6.56933 6.77759 6.57095 6.89635 6.60213 7.00898C6.63331 7.12161 6.69299 7.2243 6.77541 7.30715L9.23241 9.76415C9.31536 9.84674 9.41822 9.90651 9.53104 9.9377C9.64386 9.96888 9.76282 9.97041 9.87641 9.94215L12.0654 9.39515C12.3221 9.33136 12.5898 9.32656 12.8486 9.38112C13.1073 9.43568 13.3504 9.54817 13.5594 9.71015L15.8654 11.5041C16.6944 12.1491 16.7704 13.3741 16.0284 14.1151L14.9944 15.1491C14.2544 15.8891 13.1484 16.2141 12.1174 15.8511C9.47808 14.9237 7.08195 13.4129 5.10741 11.4311C3.12578 9.4569 1.61496 7.06112 0.687411 4.42215C0.325411 3.39215 0.650411 2.28515 1.39041 1.54515L2.42441 0.511147Z"
                                                    fill="#B6B6B6" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_139_188">
                                                    <rect width="16" height="16" fill="white"
                                                        transform="translate(0.539429)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        {{ siteSetting()->phone ?? '' }}
                                    </a>
                                </li>
                                <li>
                                    <a href="tel:{{ siteSetting()->phone ?? '' }}">
                                        <svg class="me-2" width="17" height="16" viewBox="0 0 17 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_139_192)">
                                                <path
                                                    d="M8.54143 0H8.53743C4.12643 0 0.539429 3.588 0.539429 8C0.539429 9.75 1.10343 11.372 2.06243 12.689L1.06543 15.661L4.14043 14.678C5.40543 15.516 6.91443 16 8.54143 16C12.9524 16 16.5394 12.411 16.5394 8C16.5394 3.589 12.9524 0 8.54143 0ZM13.1964 11.297C13.0034 11.842 12.2374 12.294 11.6264 12.426C11.2084 12.515 10.6624 12.586 8.82443 11.824C6.47343 10.85 4.95943 8.461 4.84143 8.306C4.72843 8.151 3.89143 7.041 3.89143 5.893C3.89143 4.745 4.47443 4.186 4.70943 3.946C4.90243 3.749 5.22143 3.659 5.52743 3.659C5.62643 3.659 5.71543 3.664 5.79543 3.668C6.03043 3.678 6.14843 3.692 6.30343 4.063C6.49643 4.528 6.96643 5.676 7.02243 5.794C7.07943 5.912 7.13643 6.072 7.05643 6.227C6.98143 6.387 6.91543 6.458 6.79743 6.594C6.67943 6.73 6.56743 6.834 6.44943 6.98C6.34143 7.107 6.21943 7.243 6.35543 7.478C6.49143 7.708 6.96143 8.475 7.65343 9.091C8.54643 9.886 9.27043 10.14 9.52943 10.248C9.72243 10.328 9.95243 10.309 10.0934 10.159C10.2724 9.966 10.4934 9.646 10.7184 9.331C10.8784 9.105 11.0804 9.077 11.2924 9.157C11.5084 9.232 12.6514 9.797 12.8864 9.914C13.1214 10.032 13.2764 10.088 13.3334 10.187C13.3894 10.286 13.3894 10.751 13.1964 11.297Z"
                                                    fill="#B6B6B6" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_139_192">
                                                    <rect width="16" height="16" fill="white"
                                                        transform="translate(0.539429)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        {{ siteSetting()->phone ?? '' }}
                                    </a>
                                </li>

                                <li>
                                    <a href="mailto:{{ siteSetting()->email ?? '' }}">
                                        <svg class="me-2" width="17" height="16" viewBox="0 0 17 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_139_197)">
                                                <path
                                                    d="M0.589429 3.555C0.690247 3.11324 0.938084 2.71881 1.29235 2.43631C1.64662 2.1538 2.08631 1.99997 2.53943 2H14.5394C14.9925 1.99997 15.4322 2.1538 15.7865 2.43631C16.1408 2.71881 16.3886 3.11324 16.4894 3.555L8.53943 8.414L0.589429 3.555ZM0.539429 4.697V11.801L6.34243 8.243L0.539429 4.697ZM7.30043 8.83L0.730429 12.857C0.892755 13.1993 1.14896 13.4884 1.46921 13.6908C1.78947 13.8931 2.1606 14.0004 2.53943 14H14.5394C14.9182 14.0001 15.2892 13.8926 15.6093 13.6901C15.9293 13.4876 16.1853 13.1983 16.3474 12.856L9.77743 8.829L8.53943 9.586L7.30043 8.83ZM10.7364 8.244L16.5394 11.801V4.697L10.7364 8.244Z"
                                                    fill="#B6B6B6" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_139_197">
                                                    <rect width="16" height="16" fill="white"
                                                        transform="translate(0.539429)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        {{ siteSetting()->email ?? '' }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="fifth_card">
                        <div class="quick-links-nav footer-quick-links">
                            <h5 class="mb-3 text-white footer-sec-title">@lang('index.newsletter')</h5>
                            <form action="#" method="post" class="subscribe_form">
                                <input type="text" class="form-control email_subscribe"
                                    placeholder="@lang('index.enter_your_email')" aria-label="Enter your email">
                                <button class="gt-btn" type="submit">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.3828 10.8828C18.8711 10.3945 18.8711 9.60156 18.3828 9.11328L12.1328 2.86328C11.6445 2.375 10.8516 2.375 10.3633 2.86328C9.875 3.35156 9.875 4.14453 10.3633 4.63281L14.4844 8.75H2.5C1.80859 8.75 1.25 9.30859 1.25 10C1.25 10.6914 1.80859 11.25 2.5 11.25H14.4805L10.3672 15.3672C9.87891 15.8555 9.87891 16.6484 10.3672 17.1367C10.8555 17.625 11.6484 17.625 12.1367 17.1367L18.3867 10.8867L18.3828 10.8828Z"
                                            fill="white" />
                                    </svg>
                                </button>
                            </form>
                            <p>
                                Subscribe now to enhance your experience with our support portal and knowledgebase!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="copyright-card">                    
                    <div class="text-center text-md-start">
                        <p class="mb-0 text-white">
                            {{ siteSetting()->footer ?? '#' }}
                        </p>
                    </div>
                    <div
                        class="footer-social-icon d-flex align-items-center justify-content-center justify-content-md-end">
                        Back to Home
                        <div class="scroll-to-top scrolltop-show" id="scrollToTopButton">                            
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_b_140_146)">
                                    <rect x="0.5" y="0.5" width="59" height="59" rx="29.5"
                                        stroke="#5065E2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M30.0001 38.7501C30.1658 38.7501 30.3248 38.6843 30.442 38.5671C30.5592 38.4499 30.6251 38.2909 30.6251 38.1251V23.3839L34.5576 27.3176C34.6749 27.435 34.8341 27.5009 35.0001 27.5009C35.166 27.5009 35.3252 27.435 35.4426 27.3176C35.5599 27.2003 35.6258 27.0411 35.6258 26.8751C35.6258 26.7092 35.5599 26.55 35.4426 26.4326L30.4426 21.4326C30.3845 21.3744 30.3155 21.3283 30.2396 21.2967C30.1637 21.2652 30.0823 21.249 30.0001 21.249C29.9178 21.249 29.8364 21.2652 29.7605 21.2967C29.6846 21.3283 29.6156 21.3744 29.5576 21.4326L24.5576 26.4326C24.4994 26.4908 24.4534 26.5597 24.4219 26.6357C24.3905 26.7116 24.3743 26.793 24.3743 26.8751C24.3743 27.0411 24.4402 27.2003 24.5576 27.3176C24.6749 27.435 24.8341 27.5009 25.0001 27.5009C25.166 27.5009 25.3252 27.435 25.4426 27.3176L29.3751 23.3839V38.1251C29.3751 38.2909 29.4409 38.4499 29.5581 38.5671C29.6753 38.6843 29.8343 38.7501 30.0001 38.7501Z"
                                        fill="#5065E2" />
                                </g>
                                <defs>
                                    <filter id="filter0_b_140_146" x="-20" y="-20" width="100" height="100"
                                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feGaussianBlur in="BackgroundImageFix" stdDeviation="10" />
                                        <feComposite in2="SourceAlpha" operator="in"
                                            result="effect1_backgroundBlur_140_146" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_140_146"
                                            result="shape" />
                                    </filter>
                                </defs>
                            </svg>
                        </div>
                    </div>
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
        <script src="{{ asset('assets/frontend/js/jquery.min.js?var=2.5') }}"></script>
        <script src="{{ asset('assets/frontend/js/set_browser_cookie.js?var=2.5') }}" defer></script>
        <script src="{{ asset('frequent_changing/sweetalert2/sweetalert.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/app.js?var=2.5') }}" defer></script>
        <script src="{{ asset('js/app.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/nice-select2.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/imagesloaded.pkgd.min.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/isotope.pkgd.min.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/slick.js') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/simple-notify.min.js') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/index.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/wow.min.js?var=2.5') }}" defer></script>
        <script src="{{ asset('frequent_changing/js/jquery.magnific-popup.min.js?var=2.5') }}"></script>
        <script src="{{ asset('assets/js/global.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/owl.carousel.min.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/plugin/aos-master/dist/aos.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/chat.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/main.js?var=2.5') }}" defer></script>
        <script src="{{ asset('assets/frontend/js/custom.js?var=2.5') }}" defer></script>
        @stack('js')
</body>

</html>
