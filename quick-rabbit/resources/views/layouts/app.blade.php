<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ siteSetting()->title ?? '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset(siteSetting()->icon) ?? '' }}" type="image/x-icon">
    <!-- jQuery 3.7.1 -->
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js?var=2.3') }}"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css?var=2.3') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/custom_admin_panel.css?var=2.3') }}">
    <!-- Sweet alert -->
    <script src="{{ asset('frequent_changing/sweetalert2/sweetalert.js?var=2.3') }}"></script>
    <!-- Iconify -->
    <script src="{{ asset('frequent_changing/js/iconify-icon.min.js?var=2.3') }}"></script>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-new/bootstrap.min.css?var=2.3') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/frontend/plugin/bootstrap-icons/font/bootstrap-icons.css?var=2.3') }}">

    <!-- New Admin Panel Design -->
    <link rel="stylesheet" href="{{ asset('frequent_changing/newDesign/style_v1.css?var=2.3') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css?var=2.3') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bower_components/perfect-scrollbar/dist/perfect-scrollbar.css?var=2.3') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.css?var=2.3') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/userHome.css?var=2.3') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/common_v1.css?var=2.3') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/custom_tooltip.css?var=2.3') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/timepicker/timepicker.min.css?var=2.3') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/toastr.css?var=2.3') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datepicker/datepicker.css?var=2.3') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/custom_v1.css?var=2.3') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/notification_drawer.css?var=2.3') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/responsive_v1.css?var=2.3') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/core.css?var=2.3') }}">
    <!-- pusher, firebase compilar file    -->
    <script src="{{ asset('js/app.js?var=2.3') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom/dashboard.css?var=2.3') }}">
    @stack('css')
</head>

@php
    $is_collapse = session()->get('is_collapse');
    $sidebar_collapse = '';
    $route_name = \Request::route()->getName();
    if ($route_name == 'ticket.show') {
        $sidebar_collapse = 'Yes';
    } elseif (!empty($is_collapse) && $is_collapse == 'Yes') {
        $sidebar_collapse = 'Yes';
    }

@endphp

<body class="hold-transition skin-blue sidebar-mini {{ $sidebar_collapse == 'Yes' ? 'sidebar-collapse' : '' }}">
    <input type="hidden" name="app-url" data-app_url="{!! url('/') !!}">
    <div id="preloader">
        <div class="spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Site wrapper -->
    @include('helper.language')

    <input type="hidden" id="site_logo" value="{{ asset(siteSetting()->logo) }}">
    <input type="hidden" id="has-browser-push" value="{{ siteSetting()->browser_notification }}">
    <input type="hidden" class="auth-user-id" value="{{ Auth::user()->id }}">
    <input type="hidden" class="auth-user-type" value="{{ Auth::user()->type }}">
    <input type="hidden" class="has-chat-sound" value="Yes">
    <input type="hidden" class="is_pagination" value="true">

    <div class="wrapper {{ isArabic() ? 'arabic-lang' : '' }}">
        <header dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="wrapper_up_wrapper">
                    <div class="hh_wrapper">
                        <div class="navbar-custom-menu navbar-menu-left">
                            <div class="menu-trigger-box">
                                <button data-toggle="push-menu" type="button" class="st new-btn"><iconify-icon
                                        icon="mingcute:grid-line" width="25"></iconify-icon></button>
                                <div class="navbar-custom-menu navbar-menu-right">
                                    <div class="d-inline-flex align-items-center">
                                        <!-- Language And Dropdown -->
                                        <div class="dropdown me-1 language-dropdown">
                                            <button class="btn dropdown-toggle top_5px_padding more-link-btn"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="link"></i>
                                            </button>
                                            <ul dir="ltr" class="dropdown-menu dropdown-menu-light">

                                                <li>
                                                    <a href="{{ route('ticket.create') }}" class="dropdown-item">
                                                        <svg width="14" height="14" viewBox="0 0 14 14"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_550_1286)">
                                                                <path
                                                                    d="M1.75 0C1.28587 0 0.840752 0.184374 0.512563 0.512563C0.184374 0.840752 0 1.28587 0 1.75L0 12.25C0 12.7141 0.184374 13.1592 0.512563 13.4874C0.840752 13.8156 1.28587 14 1.75 14H12.25C12.7141 14 13.1592 13.8156 13.4874 13.4874C13.8156 13.1592 14 12.7141 14 12.25V1.75C14 1.28587 13.8156 0.840752 13.4874 0.512563C13.1592 0.184374 12.7141 0 12.25 0L1.75 0ZM7.4375 3.9375V6.5625H10.0625C10.1785 6.5625 10.2898 6.60859 10.3719 6.69064C10.4539 6.77269 10.5 6.88397 10.5 7C10.5 7.11603 10.4539 7.22731 10.3719 7.30936C10.2898 7.39141 10.1785 7.4375 10.0625 7.4375H7.4375V10.0625C7.4375 10.1785 7.39141 10.2898 7.30936 10.3719C7.22731 10.4539 7.11603 10.5 7 10.5C6.88397 10.5 6.77269 10.4539 6.69064 10.3719C6.60859 10.2898 6.5625 10.1785 6.5625 10.0625V7.4375H3.9375C3.82147 7.4375 3.71019 7.39141 3.62814 7.30936C3.54609 7.22731 3.5 7.11603 3.5 7C3.5 6.88397 3.54609 6.77269 3.62814 6.69064C3.71019 6.60859 3.82147 6.5625 3.9375 6.5625H6.5625V3.9375C6.5625 3.82147 6.60859 3.71019 6.69064 3.62814C6.77269 3.54609 6.88397 3.5 7 3.5C7.11603 3.5 7.22731 3.54609 7.30936 3.62814C7.39141 3.71019 7.4375 3.82147 7.4375 3.9375Z"
                                                                    fill="#5B6B79" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_550_1286">
                                                                    <rect width="14" height="14"
                                                                        fill="white" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg>

                                                        @lang('index.create_ticket')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('ticket.index') }}" class="dropdown-item">
                                                        <iconify-icon icon="material-symbols:list"
                                                            width="22"></iconify-icon>&nbsp;
                                                        @lang('index.ticket_list')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('ticket?key=n_action') }}" class="dropdown-item">
                                                        <iconify-icon icon="solar:round-arrow-right-up-broken"
                                                            width="22"></iconify-icon>&nbsp;
                                                        @lang('index.need_action')
                                                    </a>
                                                </li>
                                                @if (authUserRole() != 3)
                                                    <li>
                                                        <a href="{{ route('check-in-out') }}" class="dropdown-item">
                                                            <iconify-icon icon="mdi:clock"
                                                                width="22"></iconify-icon>&nbsp;
                                                            @lang('index.check_in_out')
                                                        </a>
                                                    </li>
                                                @endif

                                                @php
                                                    $route_name = \Request::route()->getName();
                                                @endphp
                                                @if ($route_name == 'ticket.show')
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            class="open_keyboard_shortcut_modal dropdown-item"><span><iconify-icon
                                                                    icon="material-symbols:keyboard-outline"
                                                                    width="22"></iconify-icon>
                                                                @lang('index.keyboard_shortcut')</span></a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="keyboard-short-cut">
                                <a href="{{ route('ticket.create') }}" class="new-btn">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_550_1286)">
                                            <path
                                                d="M1.75 0C1.28587 0 0.840752 0.184374 0.512563 0.512563C0.184374 0.840752 0 1.28587 0 1.75L0 12.25C0 12.7141 0.184374 13.1592 0.512563 13.4874C0.840752 13.8156 1.28587 14 1.75 14H12.25C12.7141 14 13.1592 13.8156 13.4874 13.4874C13.8156 13.1592 14 12.7141 14 12.25V1.75C14 1.28587 13.8156 0.840752 13.4874 0.512563C13.1592 0.184374 12.7141 0 12.25 0L1.75 0ZM7.4375 3.9375V6.5625H10.0625C10.1785 6.5625 10.2898 6.60859 10.3719 6.69064C10.4539 6.77269 10.5 6.88397 10.5 7C10.5 7.11603 10.4539 7.22731 10.3719 7.30936C10.2898 7.39141 10.1785 7.4375 10.0625 7.4375H7.4375V10.0625C7.4375 10.1785 7.39141 10.2898 7.30936 10.3719C7.22731 10.4539 7.11603 10.5 7 10.5C6.88397 10.5 6.77269 10.4539 6.69064 10.3719C6.60859 10.2898 6.5625 10.1785 6.5625 10.0625V7.4375H3.9375C3.82147 7.4375 3.71019 7.39141 3.62814 7.30936C3.54609 7.22731 3.5 7.11603 3.5 7C3.5 6.88397 3.54609 6.77269 3.62814 6.69064C3.71019 6.60859 3.82147 6.5625 3.9375 6.5625H6.5625V3.9375C6.5625 3.82147 6.60859 3.71019 6.69064 3.62814C6.77269 3.54609 6.88397 3.5 7 3.5C7.11603 3.5 7.22731 3.54609 7.30936 3.62814C7.39141 3.71019 7.4375 3.82147 7.4375 3.9375Z"
                                                fill="#5B6B79" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_550_1286">
                                                <rect width="14" height="14" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <span>@lang('index.create_ticket')</span>
                                </a>
                                <a href="{{ route('ticket.index') }}" class="new-btn">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0 4.5C0 4.10218 0.158035 3.72064 0.43934 3.43934C0.720644 3.15804 1.10218 3 1.5 3H14.5C14.8978 3 15.2794 3.15804 15.5607 3.43934C15.842 3.72064 16 4.10218 16 4.5V6C16 6.13261 15.9473 6.25979 15.8536 6.35355C15.7598 6.44732 15.6326 6.5 15.5 6.5C15.1022 6.5 14.7206 6.65804 14.4393 6.93934C14.158 7.22064 14 7.60218 14 8C14 8.39782 14.158 8.77936 14.4393 9.06066C14.7206 9.34196 15.1022 9.5 15.5 9.5C15.6326 9.5 15.7598 9.55268 15.8536 9.64645C15.9473 9.74021 16 9.86739 16 10V11.5C16 11.8978 15.842 12.2794 15.5607 12.5607C15.2794 12.842 14.8978 13 14.5 13H1.5C1.10218 13 0.720644 12.842 0.43934 12.5607C0.158035 12.2794 0 11.8978 0 11.5L0 10C0 9.86739 0.0526784 9.74021 0.146447 9.64645C0.240215 9.55268 0.367392 9.5 0.5 9.5C0.897825 9.5 1.27936 9.34196 1.56066 9.06066C1.84196 8.77936 2 8.39782 2 8C2 7.60218 1.84196 7.22064 1.56066 6.93934C1.27936 6.65804 0.897825 6.5 0.5 6.5C0.367392 6.5 0.240215 6.44732 0.146447 6.35355C0.0526784 6.25979 0 6.13261 0 6V4.5ZM4 3.5V4.5H5V3.5H4ZM5 6.5V5.5H4V6.5H5ZM12 6.5V5.5H11V6.5H12ZM11 4.5H12V3.5H11V4.5ZM5 7.5H4V8.5H5V7.5ZM12 8.5V7.5H11V8.5H12ZM5 9.5H4V10.5H5V9.5ZM12 10.5V9.5H11V10.5H12ZM4 11.5V12.5H5V11.5H4ZM11 12.5H12V11.5H11V12.5Z"
                                            fill="#5B6B79" />
                                    </svg>

                                    <span>@lang('index.ticket_list')</span>
                                </a>
                                 @php
                                    $route_name = \Request::route()->getName();
                                @endphp
                                @if ($route_name != 'ticket.show')
                                <a href="{{ url('ticket?key=n_action') }}" class="new-btn">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_550_1279)">
                                            <path
                                                d="M0 7C0 8.85652 0.737498 10.637 2.05025 11.9497C3.36301 13.2625 5.14348 14 7 14C8.85652 14 10.637 13.2625 11.9497 11.9497C13.2625 10.637 14 8.85652 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85652 0 7 0C5.14348 0 3.36301 0.737498 2.05025 2.05025C0.737498 3.36301 0 5.14348 0 7ZM5.166 9.45263C5.12564 9.49441 5.07737 9.52774 5.02399 9.55067C4.97061 9.5736 4.9132 9.58567 4.85511 9.58617C4.79702 9.58668 4.73941 9.57561 4.68565 9.55361C4.63188 9.53161 4.58303 9.49913 4.54195 9.45805C4.50087 9.41697 4.46839 9.36812 4.44639 9.31435C4.42439 9.26059 4.41332 9.20298 4.41383 9.14489C4.41433 9.0868 4.4264 9.02939 4.44933 8.97601C4.47226 8.92263 4.50559 8.87436 4.54738 8.834L8.13138 5.25H5.70937C5.59334 5.25 5.48206 5.20391 5.40002 5.12186C5.31797 5.03981 5.27187 4.92853 5.27187 4.8125C5.27187 4.69647 5.31797 4.58519 5.40002 4.50314C5.48206 4.42109 5.59334 4.375 5.70937 4.375H9.1875C9.30353 4.375 9.41481 4.42109 9.49686 4.50314C9.57891 4.58519 9.625 4.69647 9.625 4.8125V8.29063C9.625 8.40666 9.57891 8.51794 9.49686 8.59998C9.41481 8.68203 9.30353 8.72813 9.1875 8.72813C9.07147 8.72813 8.96019 8.68203 8.87814 8.59998C8.79609 8.51794 8.75 8.40666 8.75 8.29063V5.86862L5.166 9.45263Z"
                                                fill="#5B6B79" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_550_1279">
                                                <rect width="14" height="14" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <span>@lang('index.need_action')</span>
                                </a>
                                @endif
                                @if (authUserRole() != 3)
                                    <a href="{{ route('check-in-out') }}" class="new-btn">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_550_1282)">
                                                <path
                                                    d="M5.6875 0C5.3394 0 5.00556 0.138281 4.75942 0.384422C4.51328 0.630564 4.375 0.964403 4.375 1.3125V2.1875C4.375 2.5356 4.51328 2.86944 4.75942 3.11558C5.00556 3.36172 5.3394 3.5 5.6875 3.5H8.3125C8.6606 3.5 8.99444 3.36172 9.24058 3.11558C9.48672 2.86944 9.625 2.5356 9.625 2.1875V1.3125C9.625 0.964403 9.48672 0.630564 9.24058 0.384422C8.99444 0.138281 8.6606 0 8.3125 0L5.6875 0ZM8.3125 0.875C8.42853 0.875 8.53981 0.921094 8.62186 1.00314C8.70391 1.08519 8.75 1.19647 8.75 1.3125V2.1875C8.75 2.30353 8.70391 2.41481 8.62186 2.49686C8.53981 2.57891 8.42853 2.625 8.3125 2.625H5.6875C5.57147 2.625 5.46019 2.57891 5.37814 2.49686C5.29609 2.41481 5.25 2.30353 5.25 2.1875V1.3125C5.25 1.19647 5.29609 1.08519 5.37814 1.00314C5.46019 0.921094 5.57147 0.875 5.6875 0.875H8.3125Z"
                                                    fill="#5B6B79" />
                                                <path
                                                    d="M3.5 1.3125H2.625C2.16087 1.3125 1.71575 1.49687 1.38756 1.82506C1.05937 2.15325 0.875 2.59837 0.875 3.0625V12.25C0.875 12.7141 1.05937 13.1592 1.38756 13.4874C1.71575 13.8156 2.16087 14 2.625 14H11.375C11.8391 14 12.2842 13.8156 12.6124 13.4874C12.9406 13.1592 13.125 12.7141 13.125 12.25V3.0625C13.125 2.59837 12.9406 2.15325 12.6124 1.82506C12.2842 1.49687 11.8391 1.3125 11.375 1.3125H10.5V2.1875C10.5 2.47477 10.4434 2.75922 10.3335 3.02462C10.2236 3.29002 10.0624 3.53117 9.8593 3.7343C9.65617 3.93742 9.41502 4.09855 9.14962 4.20849C8.88422 4.31842 8.59977 4.375 8.3125 4.375H5.6875C5.10734 4.375 4.55094 4.14453 4.1407 3.7343C3.73047 3.32406 3.5 2.76766 3.5 2.1875V1.3125ZM9.49725 7.74725L6.87225 10.3722C6.83161 10.413 6.78333 10.4453 6.73018 10.4674C6.67703 10.4894 6.62005 10.5008 6.5625 10.5008C6.50495 10.5008 6.44797 10.4894 6.39482 10.4674C6.34167 10.4453 6.29339 10.413 6.25275 10.3722L4.94025 9.05975C4.8581 8.9776 4.81195 8.86618 4.81195 8.75C4.81195 8.63382 4.8581 8.5224 4.94025 8.44025C5.0224 8.3581 5.13382 8.31195 5.25 8.31195C5.36618 8.31195 5.4776 8.3581 5.55975 8.44025L6.5625 9.44388L8.87775 7.12775C8.9599 7.0456 9.07132 6.99945 9.1875 6.99945C9.30368 6.99945 9.4151 7.0456 9.49725 7.12775C9.5794 7.2099 9.62555 7.32132 9.62555 7.4375C9.62555 7.55368 9.5794 7.6651 9.49725 7.74725Z"
                                                    fill="#5B6B79" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_550_1282">
                                                    <rect width="14" height="14" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <span>@lang('index.check_in_out')</span>
                                    </a>
                                @endif
                               
                                @if ($route_name == 'ticket.show')
                                    <button class="open_keyboard_shortcut_modal new-btn">
                                        <iconify-icon icon="solar:keyboard-outline" width="22"></iconify-icon>
                                        <span>
                                            @lang('index.keyboard_shortcuts')
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="navbar-custom-menu navbar-menu-right">
                            <div class="d-inline-flex align-items-center custom_gap_2">
                                <!-- Language And Dropdown -->
                                <div class="dropdown language-dropdown me-2">

                                    <button class="dropdown-toggle new-btn language_btn_sec" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        @if (Auth::user()->language != null)
                                        <img src="{{ asset('assets/flag/'.Auth::user()->language.'.svg') }}" class="flag_image" alt="">
                                            <span
                                                class="mobile-d-ln-none">{{ lanFullName(Auth::user()->language) }}</span>
                                        @else
                                            <img src="{{ asset('assets/flag/en.svg') }}" class="flag_image" alt="">
                                            <span class="mobile-d-ln-none">@lang('index.english')</span>
                                        @endif
                                    </button>

                                    <ul dir="ltr" class="dropdown-menu dropdown-menu-light dropdown-menu-lang">
                                        @foreach (languageFolders() as $dir)
                                            <li class="lang_list">
                                                <a class="dropdown-item"
                                                    href="{{ url('set-locale/' . $dir) }}">{{ lanFullName($dir) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!--Bell notification -->
                                <div class="dropdown notification-bell me-2" id="notification_wrap">
                                    <button
                                        class="btn-none dropdown-toggle notification_bell_icon_  position-relative icon-button"
                                        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                        aria-controls="offcanvasRight">
                                        <!-- <i  data-feather="bell" aria-hidden="true"></i> -->
                                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_550_1221)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29306 0.64375C8.29306 0.473017 8.36089 0.309277 8.48161 0.18855C8.60234 0.0678235 8.76608 0 8.93681 0C9.10755 0 9.27129 0.0678235 9.39201 0.18855C9.51274 0.309277 9.58056 0.473017 9.58056 0.64375V0.973031C9.15288 0.922497 8.72074 0.922497 8.29306 0.973031V0.64375ZM10.1534 14.7832C10.1542 14.9435 10.1233 15.1024 10.0625 15.2507C10.0018 15.399 9.9123 15.5338 9.79925 15.6475C9.68621 15.7611 9.55183 15.8512 9.40383 15.9128C9.25583 15.9743 9.09714 16.0059 8.93686 16.0059C8.77658 16.0059 8.61789 15.9743 8.46989 15.9128C8.32189 15.8512 8.18751 15.7611 8.07446 15.6475C7.96142 15.5338 7.87194 15.399 7.81117 15.2507C7.7504 15.1024 7.71953 14.9435 7.72034 14.7832V14.4193H10.1534V14.7833V14.7832ZM15.6009 13.5917H2.27344L4.05594 11.7672H13.8179L15.6009 13.5917ZM13.5781 6.404V10.9396H4.29541V6.404C4.29541 3.84462 6.37759 1.76275 8.93688 1.76275C11.4962 1.76275 13.5781 3.84475 13.5781 6.404Z" fill="#5B6B79"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_550_1221">
                                            <rect width="16" height="16" fill="white" transform="translate(0.9375)"/>
                                            </clipPath>
                                            </defs>
                                            </svg>
                                            
                                        @if (Auth::check())
                                            <span id="notification-bell-count"
                                                class="b-badge user-notification_{{ Auth::user()->id }}">
                                                {{ showTotalNotification() ?? 0 }}
                                            </span>
                                        @endif
                                    </button>

                                    <!-- Chat box -->
                                </div>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                                    aria-labelledby="offcanvasRightLabel">
                                    <div class="offcanvas-header">
                                        <div class="d-sm-block d-md-flex  justify-content-between">
                                            <h5 id="offcanvasRightLabel" class="notification_heading">
                                                @lang('index.notifications')</h5>
                                            <div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input notification-check" type="checkbox"
                                                        id="flexSwitchCheckChecked">
                                                    <label class="form-check-label notification-check-label"
                                                        for="flexSwitchCheckChecked">@lang('index.show_unread')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn notification-close-btn text-reset"
                                            data-bs-dismiss="offcanvas" aria-label="Close">
                                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_728_2329)">
                                                <path d="M20 37.5C15.3587 37.5 10.9075 35.6563 7.62563 32.3744C4.34374 29.0925 2.5 24.6413 2.5 20C2.5 15.3587 4.34374 10.9075 7.62563 7.62563C10.9075 4.34374 15.3587 2.5 20 2.5C24.6413 2.5 29.0925 4.34374 32.3744 7.62563C35.6563 10.9075 37.5 15.3587 37.5 20C37.5 24.6413 35.6563 29.0925 32.3744 32.3744C29.0925 35.6563 24.6413 37.5 20 37.5ZM20 40C25.3043 40 30.3914 37.8929 34.1421 34.1421C37.8929 30.3914 40 25.3043 40 20C40 14.6957 37.8929 9.60859 34.1421 5.85786C30.3914 2.10714 25.3043 0 20 0C14.6957 0 9.60859 2.10714 5.85786 5.85786C2.10714 9.60859 0 14.6957 0 20C0 25.3043 2.10714 30.3914 5.85786 34.1421C9.60859 37.8929 14.6957 40 20 40Z" fill="white"/>
                                                <path d="M11.6133 11.615C11.7294 11.4986 11.8674 11.4063 12.0192 11.3433C12.1711 11.2802 12.3339 11.2478 12.4983 11.2478C12.6627 11.2478 12.8255 11.2802 12.9774 11.3433C13.1293 11.4063 13.2672 11.4986 13.3833 11.615L19.9983 18.2325L26.6133 11.615C26.7295 11.4988 26.8675 11.4066 27.0194 11.3437C27.1712 11.2808 27.334 11.2485 27.4983 11.2485C27.6627 11.2485 27.8254 11.2808 27.9773 11.3437C28.1291 11.4066 28.2671 11.4988 28.3833 11.615C28.4995 11.7313 28.5917 11.8692 28.6546 12.0211C28.7175 12.1729 28.7499 12.3357 28.7499 12.5C28.7499 12.6644 28.7175 12.8271 28.6546 12.979C28.5917 13.1308 28.4995 13.2688 28.3833 13.385L21.7658 20L28.3833 26.615C28.4995 26.7313 28.5917 26.8692 28.6546 27.0211C28.7175 27.1729 28.7499 27.3357 28.7499 27.5C28.7499 27.6644 28.7175 27.8271 28.6546 27.979C28.5917 28.1308 28.4995 28.2688 28.3833 28.385C28.2671 28.5013 28.1291 28.5934 27.9773 28.6563C27.8254 28.7192 27.6627 28.7516 27.4983 28.7516C27.334 28.7516 27.1712 28.7192 27.0194 28.6563C26.8675 28.5934 26.7295 28.5013 26.6133 28.385L19.9983 21.7675L13.3833 28.385C13.2671 28.5013 13.1291 28.5934 12.9773 28.6563C12.8254 28.7192 12.6627 28.7516 12.4983 28.7516C12.334 28.7516 12.1712 28.7192 12.0194 28.6563C11.8675 28.5934 11.7295 28.5013 11.6133 28.385C11.4971 28.2688 11.4049 28.1308 11.342 27.979C11.2791 27.8271 11.2467 27.6644 11.2467 27.5C11.2467 27.3357 11.2791 27.1729 11.342 27.0211C11.4049 26.8692 11.4971 26.7313 11.6133 26.615L18.2308 20L11.6133 13.385C11.4969 13.2689 11.4046 13.131 11.3415 12.9791C11.2785 12.8273 11.2461 12.6645 11.2461 12.5C11.2461 12.3356 11.2785 12.1728 11.3415 12.021C11.4046 11.8691 11.4969 11.7312 11.6133 11.615Z" fill="white"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_728_2329">
                                                <rect width="40" height="40" fill="white"/>
                                                </clipPath>
                                                </defs>
                                                </svg>
                                                
                                        </button>                                        
                                    </div>
                                    <div class="offcanvas-body">
                                        <div class="d-flex justify-content-between btn_sec">
                                            <button
                                                class="mark_as_read_btn mark-all-as-read">@lang('index.mark_all_as_read')</button>
                                            <button class="mark_as_read_btn delete_all_notifications"
                                                id="delete_all">@lang('index.delete_all')</button>
                                        </div>
                                        <div class="loader_notification_div">&nbsp;</div>
                                        <ul class="list-group list-group-flush" id="all_notifications_show_div">

                                        </ul>
                                        <div class="offcanvas-footer-sec">
                                            <a href="javascript:void(0);"
                                                class="custom_header_btn notification_footer_button load-more-notification font_width_500">
                                                @lang('index.load_more')
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.668 7.33333C14.4912 7.33333 14.3216 7.40357 14.1966 7.5286C14.0715 7.65362 14.0013 7.82319 14.0013 8C14.0013 9.18669 13.6494 10.3467 12.9901 11.3334C12.3308 12.3201 11.3938 13.0892 10.2974 13.5433C9.20105 13.9974 7.99465 14.1162 6.83076 13.8847C5.66688 13.6532 4.59778 13.0818 3.75866 12.2426C2.91955 11.4035 2.34811 10.3344 2.11659 9.17054C1.88508 8.00666 2.0039 6.80026 2.45803 5.7039C2.91215 4.60754 3.68119 3.67047 4.66788 3.01118C5.65458 2.35189 6.81462 2 8.00131 2C9.03445 1.99815 10.0502 2.2661 10.948 2.77733L10.1966 3.52867C10.1034 3.6219 10.04 3.74068 10.0142 3.86998C9.98854 3.99928 10.0017 4.1333 10.0522 4.2551C10.1026 4.3769 10.1881 4.48101 10.2977 4.55427C10.4073 4.62752 10.5361 4.66664 10.668 4.66667H13.3346C13.5115 4.66667 13.681 4.59643 13.806 4.4714C13.9311 4.34638 14.0013 4.17681 14.0013 4V1.33333C14.0013 1.2015 13.9622 1.07263 13.8889 0.963028C13.8157 0.853421 13.7115 0.767995 13.5897 0.717548C13.4679 0.667101 13.3339 0.653899 13.2046 0.679611C13.0753 0.705323 12.9565 0.768794 12.8633 0.862L11.9226 1.8C10.7507 1.05533 9.38985 0.66203 8.00131 0.666666C6.55091 0.666666 5.13308 1.09676 3.92712 1.90256C2.72116 2.70835 1.78123 3.85366 1.22619 5.19365C0.671146 6.53365 0.525922 8.00813 0.80888 9.43066C1.09184 10.8532 1.79027 12.1599 2.81586 13.1855C3.84144 14.211 5.14812 14.9095 6.57064 15.1924C7.99317 15.4754 9.46766 15.3302 10.8077 14.7751C12.1476 14.2201 13.293 13.2801 14.0988 12.0742C14.9045 10.8682 15.3346 9.4504 15.3346 8C15.3346 7.82319 15.2644 7.65362 15.1394 7.5286C15.0144 7.40357 14.8448 7.33333 14.668 7.33333Z" fill="#5065E2"/>
                                                </svg>                                                    
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <a class="icon-button chatting_wrap position-relative"
                                    href="{{ route('live-chat') }}">
                                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.688 1.51648H4.20655C3.61118 1.51714 3.04038 1.75394 2.61939 2.17493C2.1984 2.59593 1.9616 3.16672 1.96094 3.76209V9.7504C1.96159 10.3458 2.19839 10.9166 2.61938 11.3376C3.04038 11.7586 3.61118 11.9954 4.20655 11.996H4.95509V13.9921C4.95508 14.087 4.98211 14.1799 5.03302 14.26C5.08393 14.34 5.15661 14.4039 5.24254 14.4442C5.32846 14.4844 5.42408 14.4993 5.51817 14.4871C5.61227 14.4749 5.70094 14.4362 5.7738 14.3754L8.62729 11.996H13.688C14.2834 11.9954 14.8542 11.7585 15.2752 11.3376C15.6962 10.9166 15.933 10.3458 15.9336 9.7504V3.76209C15.933 3.16672 15.6962 2.59593 15.2752 2.17493C14.8542 1.75394 14.2834 1.51714 13.688 1.51648ZM5.95314 7.7543C5.68844 7.7543 5.43458 7.64914 5.24741 7.46197C5.06024 7.2748 4.95509 7.02095 4.95509 6.75625C4.95509 6.49155 5.06024 6.23769 5.24741 6.05052C5.43458 5.86335 5.68844 5.75819 5.95314 5.75819C6.21784 5.75819 6.4717 5.86335 6.65887 6.05052C6.84604 6.23769 6.95119 6.49155 6.95119 6.75625C6.95119 7.02095 6.84604 7.2748 6.65887 7.46197C6.4717 7.64914 6.21784 7.7543 5.95314 7.7543ZM8.94729 7.7543C8.68259 7.7543 8.42873 7.64914 8.24156 7.46197C8.05439 7.2748 7.94924 7.02095 7.94924 6.75625C7.94924 6.49155 8.05439 6.23769 8.24156 6.05052C8.42873 5.86335 8.68259 5.75819 8.94729 5.75819C9.21199 5.75819 9.46585 5.86335 9.65302 6.05052C9.84019 6.23769 9.94534 6.49155 9.94534 6.75625C9.94534 7.02095 9.84019 7.2748 9.65302 7.46197C9.46585 7.64914 9.21199 7.7543 8.94729 7.7543ZM11.9414 7.7543C11.6767 7.7543 11.4229 7.64914 11.2357 7.46197C11.0485 7.2748 10.9434 7.02095 10.9434 6.75625C10.9434 6.49155 11.0485 6.23769 11.2357 6.05052C11.4229 5.86335 11.6767 5.75819 11.9414 5.75819C12.2061 5.75819 12.46 5.86335 12.6472 6.05052C12.8343 6.23769 12.9395 6.49155 12.9395 6.75625C12.9395 7.02095 12.8343 7.2748 12.6472 7.46197C12.46 7.64914 12.2061 7.7543 11.9414 7.7543Z" fill="#5B6B79"/>
                                    </svg>
                                        
                                    <span id="message-bell-count"
                                        class="b-badge user-unseen_{{ Auth::user()->id }}">{{ userUnseen() ?? 0 }}</span>
                                </a>

                                <!-- User Image And Dropdown -->
                                <ul class="menu-list">
                                    <!-- User Profile And Dropdown -->
                                    <li class="user-info-box">
                                        <div class="c-dropdown-menu">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('edit-profile') }}">
                                                        <i data-feather="user"></i>
                                                        @lang('index.change_profile')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('change-password') }}">
                                                        <i data-feather="key"></i>
                                                        @lang('index.change_password')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('set-security-question') }}">
                                                        <i data-feather="help-circle"></i>
                                                        @lang('index.set_security_question')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('logout') }}">
                                                        <i data-feather="log-out"></i>
                                                        @lang('index.logout')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="user-profile">

                                            @if (Auth::user()->image != null and file_exists(Auth::user()->image))
                                                <img class="user-avatar" src="{{ asset(Auth::user()->image) }}"
                                                    alt="">
                                            @else
                                                <img class="user-avatar"
                                                    src="{{ asset('frequent_changing/images/user-avatar.jpg') }}"
                                                    alt="">
                                            @endif

                                            <div class="user-info">
                                                <p class="user-name">
                                                    <span class="user-m-hide">
                                                        {{ Auth::check() ? Auth::user()->full_name : 'Admin' }}
                                                    </span>
                                                </p>
                                                @if (authUserRole() == 2)
                                                    <span class="user-role">
                                                        {{ Auth::user()->role_name }} <iconify-icon
                                                            icon="uil:angle-down" width="22"></iconify-icon>
                                                    </span>
                                                @else
                                                    <span class="user-role">
                                                        {{ Auth::check() ? Auth::user()->type : 'Admin' }}
                                                        <iconify-icon icon="uil:angle-down"
                                                            width="22"></iconify-icon>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        @if (!isArabic())
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar {{ Auth::check() ? '' : 'displayNone' }}">
                <a href="#" class="sidebar-toggle set_collapse" data-toggle="push-menu" role="button"
                    data-status="{{ isset($is_collapse) && $is_collapse == 'Yes' ? 'Yes' : 'No' }}">
                    <svg width="24" height="17" viewBox="0 0 24 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <line x1="1.125" y1="0.5" x2="23.5" y2="0.5" stroke="black"
                            stroke-linecap="round" />
                        <line x1="1.125" y1="16.5" x2="23.5" y2="16.5" stroke="black"
                            stroke-linecap="round" />
                        <line x1="8" y1="8.5" x2="23.5" y2="8.5" stroke="black"
                            stroke-linecap="round" />
                    </svg>
                </a>
                <!-- Sidebar toggle button-->
                <a href="{{ route('home') }}" class="logo-wrapper" target="_blank">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">
                        {{ shortName(siteSetting()->company_name) ?? 'TI' }}
                    </span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
                        <img src="{{ asset(siteSetting()->logo ?? '') }}" alt="Logo">
                    </span>
                </a>

                @include('layouts.sidebar')
            </aside>
        @endif
        @if (isArabic())
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="main-sidebar2 {{ Auth::check() ? '' : 'displayNone' }}">
                <a href="#" class="sidebar-toggle set_collapse" data-toggle="push-menu" role="button"
                    data-status="{{ isset($is_collapse) && $is_collapse == 'Yes' ? 'Yes' : 'No' }}">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="inner-circle"></span>
                </a>
                <!-- Sidebar toggle button-->
                <a href="{{ route('home') }}" class="logo-wrapper" target="_blank">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">
                        {{ substr(siteSetting()->company_name, 0, 1) ?? 'AD' }}
                    </span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
                        <img src="{{ asset(siteSetting()->logo ?? '') }}" alt="Logo">
                    </span>
                </a>

                @include('layouts.sidebar')
            </aside>
            <!-- Content Wrapper. Contains page content -->
        @endif
        <!-- /.sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="{{ isArabic() ? 'margin-left:0' : '' }}">
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="row">
                <div class="col-md-12 ir_txt_center">
                    <span class="footer_bottom_text">

                        {{ siteSetting()->footer ?? '' }}
                    </span>
                    <div class="hidden-lg"></div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('frequent_changing/js/loader.js?var=2.3') }}"></script>
    <script src="{{ asset('assets/bootstrap-new/bootstrap.bundle.min.js?var=2.3') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/bower_components/perfect-scrollbar/dist/perfect-scrollbar.min.js?var=2.3') }}"></script>

    <script src="{{ asset('assets/dist/js/adminlte.min.js?var=2.3') }}"></script>

    <!-- material icon -->
    <script src="{{ asset('assets/dist/js/feather.min.js?var=2.3') }}"></script>
    <script src="{{ asset('frequent_changing/js/user_home_buttom.js?var=2.3') }}"></script>
    <script src="{{ asset('frequent_changing/newDesign/js/new-script.js?var=2.3') }}"></script>
    <script src="{{ asset('frequent_changing/js/helper.js?var=2.3') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('frequent_changing/js/toastr.js?var=2.3') }}"></script>

    <!-- Howl audio play plugin -->
    <script src="{{ asset('frequent_changing/js/howl-audio-v2.js?var=2.3') }}"></script>
    <!-- Axios -->
    <script src="{{ asset('frequent_changing/js/axios.js?var=2.3') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js?var=2.3') }}"></script>
    <script src="{{ asset('assets/bower_components/timepicker/timepicker.min.js?var=2.3') }}"></script>
    <script src="{{ asset('assets/bower_components/datepicker/bootstrap-datepicker.js?var=2.3') }}"></script>
    <!-- Common js and (Bootstrap Tooltip & others) -->
    <script src="{{ asset('frequent_changing/js/user_home_v1.js?var=2.3') }}"></script>

    <script src="{{ asset('frequent_changing/js/initialize.js?var=2.3') }}"></script>
    <script src="{{ asset('assets/js/global.js?var=2.3') }}"></script>
    <script src="{{ asset('frequent_changing/js/common_script.js?var=2.3') }}"></script>
    <script src="{{ asset('frequent_changing/js/notification.js?var=2.3') }}"></script>
    <script src="{{ asset('frequent_changing/js/sounds.js?var=2.3') }}"></script>
    <script src="{{ asset('frequent_changing/js/set_user_info.js?var=2.3') }}"></script>
    @stack('js')
</body>

</html>
