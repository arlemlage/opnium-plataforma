@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/dashboard.css?var=2.2') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/ticket_index.css?var=2.2') }}">
@endpush

@section('content')

    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="alert-wrapper">
            {{ alertMessage() }}
        </div>

        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">@lang('index.dashboard')</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.dashboard')])
            </div>
        </section>
        <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
        @if (authUserRole() == 1)
            <div class="row pb-2">
                <div class="col-m-12">
                    @if (authUserRole() == 1 && showUndoneWork())
                        <div class="accordion" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed warning_need_action"
                                        data-bs-toggle="collapse" data-bs-target="#undoneWork" aria-expanded="false"
                                        aria-controls="undoneWork">
                                        @lang('index.need_action')
                                    </button>
                                </h2>
                                <div id="undoneWork" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @if (configInfo()->google_login == 0 && configInfo()->inerest_google_login == 1)
                                            <div class="alert alert-warning alert-dismissible p-0" role="alert">
                                                <span class="margin-left-10">
                                                    @lang('index.not_configure_google_login_setting') <a href="{{ route('social-login-setting') }}"
                                                        class="alert-link text-decoration-none">@lang('index.click_here')</a>
                                                    @lang('index.configure_google_login')
                                                </span>
                                                <button type="button" class="btn-close config-alert" data-id="google_login"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (configInfo()->github_login == 0 && configInfo()->inerest_github_login == 1)
                                            <div class="alert alert-warning alert-dismissible p-0" role="alert">
                                                <span class="margin-left-10">
                                                    @lang('index.not_configure_github_login_setting') <a href="{{ route('social-login-setting') }}"
                                                        class="alert-link text-decoration-none">@lang('index.click_here')</a>
                                                    @lang('index.configure_github_login')
                                                </span>
                                                <button type="button" class="btn-close config-alert" data-id="github_login"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if (configInfo()->envato_login == 0 && configInfo()->inerest_envato_login == 1)
                                            <div class="alert alert-warning alert-dismissible p-0" role="alert">
                                                <span class="margin-left-10">
                                                    @lang('index.not_configure_envato_login_setting') <a href="{{ route('social-login-setting') }}"
                                                        class="alert-link text-decoration-none">@lang('index.click_here')</a>
                                                    @lang('index.configure_envato_login')
                                                </span>
                                                <button type="button" class="btn-close config-alert" data-id="envato_login"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (configInfo()->chat_setting == 0 && configInfo()->inerest_chat_setting == 1)
                                            <div class="alert alert-warning alert-dismissible p-0" role="alert">
                                                <span class="margin-left-10">
                                                    @lang('index.not_configure_chat_setting') <a href="{{ route('chat-setting') }}"
                                                        class="alert-link text-decoration-none">@lang('index.click_here')</a>
                                                    @lang('index.configure_chat_setting')
                                                </span>
                                                <button type="button" class="btn-close config-alert" data-id="chat_setting"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (configInfo()->notification_setting == 0 && configInfo()->inerest_notification_setting == 1)
                                            <div class="alert alert-warning alert-dismissible p-0" role="alert">
                                                <span class="margin-left-10">
                                                    @lang('index.not_configure_notification_setting') <a href="{{ route('notification-setting') }}"
                                                        class="alert-link text-decoration-none">@lang('index.click_here')</a>
                                                    @lang('index.configure_notification_setting')
                                                </span>
                                                <button type="button" class="btn-close config-alert"
                                                    data-id="notification_setting" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (configInfo()->mail_setting == 0 && configInfo()->inerest_mail_setting == 1)
                                            <div class="alert alert-warning alert-dismissible p-0" role="alert">
                                                <span class="margin-left-10">
                                                    @lang('index.not_configure_mail_setting') <a href="{{ route('mail-setting') }}"
                                                        class="alert-link text-decoration-none">@lang('index.click_here')</a>
                                                    @lang('index.configure_mail_setting')
                                                </span>
                                                <button type="button" class="btn-close config-alert" data-id="mail_setting"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (configInfo()->payment_gateway_setting == 0 && configInfo()->inerest_payment_gateway_setting == 1)
                                            <div class="alert alert-warning alert-dismissible p-0" role="alert">
                                                <span class="margin-left-10">
                                                    @lang('index.not_configure_payment_gateway_setting')
                                                    <a href="{{ route('payment-gateway-setting') }}"
                                                        class="alert-link text-decoration-none">@lang('index.click_here')</a>
                                                    @lang('index.configure_payment_gateway_setting')
                                                </span>
                                                <button type="button" class="btn-close config-alert"
                                                    data-id="payment_gateway_setting" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mb-3 card-row">
                <div class="col-lg-3 col-xs-6">
                    <a class="text-dec-none" href="{{ url('ticket?key=open') }}">
                        <div class="small-box box4column">
                            <div class="inner">
                                <p>@lang('index.open_tickets')</p>
                                <h3>{{ $all_t_open }}</h3>
                            </div>
                            <p class="d-flex justify-content-between">
                                @if ($percentage_open_ticket < 0)
                                    @lang('index.since_last_month')
                                    <span class="text-danger d-flex align-items-center gap4">{{ $percentage_open_ticket }}%<iconify-icon icon="teenyicons:down-solid"
                                            width="16"></iconify-icon></span>
                                   
                                @else
                                    @lang('index.since_last_month')
                                    <span class="text-success d-flex align-items-center gap4">+{{ $percentage_open_ticket }}%<iconify-icon icon="teenyicons:up-solid"
                                            width="16"></iconify-icon></span>
                                    
                                @endif

                            </p>
                            <div class="icon primary_icon">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M28.4648 16.3672C28.5891 16.3668 28.7081 16.3173 28.7959 16.2295C28.8837 16.1416 28.9332 16.0226 28.9336 15.8984V13.0484C28.9336 12.4181 28.6832 11.8136 28.2375 11.3679C27.7918 10.9222 27.1873 10.6718 26.557 10.6718H11.1961V12.7625C11.1961 12.8868 11.1467 13.006 11.0588 13.0939C10.9709 13.1818 10.8517 13.2312 10.7273 13.2312C10.603 13.2312 10.4838 13.1818 10.3959 13.0939C10.308 13.006 10.2586 12.8868 10.2586 12.7625V10.6718H5.06016C4.42985 10.6718 3.82537 10.9222 3.37967 11.3679C2.93398 11.8136 2.6836 12.4181 2.6836 13.0484V15.8984C2.68397 16.0226 2.73347 16.1416 2.8213 16.2295C2.90913 16.3173 3.02814 16.3668 3.15235 16.3672C4.79297 16.3672 6.18047 17.2953 6.18047 18.3922C6.23391 19.5631 4.83328 20.502 3.15235 20.5109C3.09074 20.5107 3.0297 20.5227 2.97274 20.5462C2.91579 20.5697 2.86404 20.6042 2.82048 20.6478C2.77691 20.6914 2.74239 20.7431 2.7189 20.8001C2.69541 20.857 2.68341 20.9181 2.6836 20.9797V23.8297C2.68459 24.4592 2.93545 25.0627 3.38106 25.5074C3.82667 25.9521 4.43059 26.2018 5.06016 26.2015H10.2586C10.2572 25.6939 10.2595 24.6284 10.2586 24.1156C10.2586 23.9913 10.308 23.8721 10.3959 23.7841C10.4838 23.6962 10.603 23.6469 10.7273 23.6469C10.8517 23.6469 10.9709 23.6962 11.0588 23.7841C11.1467 23.8721 11.1961 23.9913 11.1961 24.1156C11.1994 24.6237 11.1938 25.6958 11.1961 26.2015H26.557C27.1866 26.2018 27.7905 25.9521 28.2361 25.5074C28.6817 25.0627 28.9326 24.4592 28.9336 23.8297V20.9797C28.9338 20.9181 28.9218 20.857 28.8983 20.8001C28.8748 20.7431 28.8403 20.6914 28.7967 20.6478C28.7532 20.6042 28.7014 20.5697 28.6444 20.5462C28.5875 20.5227 28.5265 20.5107 28.4648 20.5109C24.4359 20.3876 24.4486 16.4853 28.4648 16.3672ZM10.7273 14.6187C10.8516 14.6191 10.9706 14.6686 11.0584 14.7564C11.1462 14.8443 11.1957 14.9633 11.1961 15.0875V16.7093C11.1961 16.8337 11.1467 16.9529 11.0588 17.0408C10.9709 17.1287 10.8517 17.1781 10.7273 17.1781C10.603 17.1781 10.4838 17.1287 10.3959 17.0408C10.308 16.9529 10.2586 16.8337 10.2586 16.7093V15.0875C10.259 14.9633 10.3085 14.8443 10.3963 14.7564C10.4841 14.6686 10.6031 14.6191 10.7273 14.6187ZM10.7273 22.2547C10.6657 22.2548 10.6047 22.2428 10.5477 22.2194C10.4908 22.1959 10.439 22.1613 10.3955 22.1178C10.3519 22.0742 10.3174 22.0225 10.2939 21.9655C10.2704 21.9086 10.2584 21.8475 10.2586 21.7859V20.1687C10.2586 20.0444 10.308 19.9252 10.3959 19.8373C10.4838 19.7494 10.603 19.7 10.7273 19.7C10.8517 19.7 10.9709 19.7494 11.0588 19.8373C11.1467 19.9252 11.1961 20.0444 11.1961 20.1687V21.7859C11.1963 21.8475 11.1843 21.9086 11.1608 21.9655C11.1373 22.0225 11.1028 22.0742 11.0592 22.1178C11.0157 22.1613 10.9639 22.1959 10.9069 22.2194C10.85 22.2428 10.789 22.2548 10.7273 22.2547ZM25.2305 9.73435L23.2383 5.75466C23.0456 5.36873 22.716 5.06846 22.3138 4.91245C21.9117 4.75644 21.4658 4.75589 21.0633 4.91091L8.39297 9.73435H25.2305Z" fill="#5065E2"/>
                                    </svg>
                                    
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <a class="text-dec-none" href="{{ url('ticket?key=closed') }}">
                        <div class="small-box box4column">
                            <div class="inner">
                                <p>@lang('index.closed_tickets')</p>
                                <h3>{{ $closed_tickets }}</h3>
                            </div>
                            <p class="d-flex justify-content-between">
                                @if ($percentage_closed_ticket < 0)
                                    @lang('index.since_last_month')
                                    <span class="text-danger d-flex align-items-center gap4">{{ $percentage_closed_ticket }}%<iconify-icon icon="teenyicons:down-solid"
                                            width="16"></iconify-icon> </span>                                    
                                @else
                                    @lang('index.since_last_month')
                                    <span class="text-success d-flex align-items-center gap4">+{{ $percentage_closed_ticket }}%<iconify-icon icon="teenyicons:up-solid"
                                            width="16"></iconify-icon> </span>                                    
                                @endif
                            </p>
                            <div class="icon warning_icon">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_561_1012)">
                                    <path d="M28.6769 8.06827C27.1764 9.56871 25.3427 8.96824 23.8408 7.4678C22.3418 5.96736 21.7399 4.13365 23.2418 2.63321L21.1086 0.5L16.7937 4.81634L17.3751 5.39919L16.7365 6.03783L16.1536 5.45498L0.808594 20.7985L2.9418 22.9332C4.44224 21.4328 6.27448 22.0303 7.77492 23.5307C9.27536 25.0312 9.87583 26.8649 8.37539 28.3653L10.5101 30.5L13.5623 27.4477C13.5609 27.4169 13.555 27.3861 13.555 27.3552C13.5591 27.178 13.5989 27.0035 13.672 26.842C13.7452 26.6806 13.8502 26.5355 13.9808 26.4156C14.8616 25.6096 15.7261 24.7858 16.5735 23.9447C15.727 23.1027 14.8626 22.2788 13.9808 21.4739C13.8508 21.3541 13.7463 21.2093 13.6736 21.0481C13.601 20.887 13.5616 20.7128 13.5579 20.5361C13.5542 20.3594 13.5862 20.1837 13.6521 20.0197C13.7179 19.8556 13.8162 19.7066 13.9411 19.5814L15.9598 17.5583C16.2057 17.314 16.538 17.1763 16.8847 17.1751C17.0639 17.1759 17.241 17.2129 17.4054 17.2838C17.5699 17.3546 17.7184 17.458 17.842 17.5877C18.6549 18.4571 19.4811 19.3142 20.3202 20.1584C21.1597 19.3146 21.9859 18.4576 22.7984 17.5877C22.9189 17.4601 23.0638 17.3578 23.2244 17.287C23.385 17.2161 23.5581 17.1781 23.7336 17.1751H23.7351C23.7659 17.1751 23.7923 17.181 23.8246 17.184L25.8536 15.1535L25.6862 14.9876L26.3264 14.3475L26.4923 14.5149L30.8086 10.1985L28.6769 8.06827ZM19.294 8.59533L18.0152 7.31658L18.6539 6.67647L19.9341 7.95522L19.294 8.59533ZM21.8515 11.1528L20.5727 9.87408L21.2128 9.23397L22.4916 10.5142L21.8515 11.1528ZM24.4075 13.7103L23.1302 12.4316L23.7703 11.7929L25.0476 13.0717L24.4075 13.7103Z" fill="#E58A00"/>
                                    <path d="M26.0667 20.7868C26.1132 20.7437 26.1505 20.6917 26.1764 20.6339C26.2022 20.576 26.2162 20.5135 26.2173 20.4501C26.2183 20.3868 26.2066 20.3238 26.1828 20.2651C26.1589 20.2064 26.1234 20.1531 26.0784 20.1085L24.0553 18.0869C24.0108 18.042 23.9577 18.0066 23.8992 17.9827C23.8406 17.9589 23.7779 17.9471 23.7147 17.9481C23.6515 17.949 23.5892 17.9627 23.5314 17.9883C23.4736 18.0139 23.4216 18.051 23.3785 18.0971C22.179 19.3759 20.8283 20.7648 20.2881 21.261C19.7463 20.7648 18.3986 19.3759 17.1991 18.0971C17.156 18.051 17.1039 18.0139 17.0462 17.9883C16.9884 17.9627 16.9261 17.949 16.8629 17.9481C16.7997 17.9471 16.7369 17.9589 16.6784 17.9827C16.6199 18.0066 16.5668 18.042 16.5223 18.0869L14.5021 20.11C14.4569 20.1546 14.4213 20.208 14.3975 20.2668C14.3736 20.3257 14.362 20.3888 14.3634 20.4523C14.3648 20.5158 14.3791 20.5783 14.4055 20.6361C14.4318 20.6938 14.4697 20.7456 14.5168 20.7882C15.819 21.9848 17.2387 23.3501 17.6983 23.8772C17.2387 24.4043 15.8176 25.7682 14.5168 26.9647C14.4703 27.008 14.433 27.0603 14.407 27.1183C14.3811 27.1763 14.3671 27.239 14.3659 27.3025C14.3646 27.3661 14.3762 27.4292 14.3999 27.4882C14.4235 27.5472 14.4588 27.6008 14.5036 27.6459L16.5237 29.6632C16.6155 29.7521 16.7381 29.802 16.8658 29.8026C16.9291 29.8012 16.9915 29.7871 17.0493 29.7611C17.107 29.7352 17.159 29.6979 17.202 29.6514C18.4015 28.3653 19.7566 26.9647 20.2925 26.4817C20.8269 26.9647 22.182 28.3653 23.3814 29.6514C23.4247 29.6976 23.4767 29.7347 23.5344 29.7607C23.5921 29.7866 23.6544 29.8009 23.7176 29.8026H23.725C23.8503 29.8019 23.9703 29.7524 24.0597 29.6646L26.0828 27.6459C26.1277 27.6011 26.1632 27.5477 26.1871 27.489C26.2111 27.4302 26.223 27.3673 26.2223 27.3039C26.2209 27.2403 26.2068 27.1777 26.1808 27.1197C26.1549 27.0617 26.1175 27.0095 26.0711 26.9662C24.785 25.7696 23.3829 24.4146 22.8969 23.8772C23.377 23.3413 24.7791 21.9848 26.0667 20.7868Z" fill="#E58A00"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_561_1012">
                                    <rect width="30" height="30" fill="white" transform="translate(0.808594 0.5)"/>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                    
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <a class="text-dec-none" href="{{ route('live-chat') }}">
                        <div class="small-box box4column">
                            <div class="inner">
                                <p>@lang('index.open_chats')</p>
                                <h3>{{ App\Model\ChatGroup::where('status', 'Active')->where('user_type', 'customer')->count() ?? 0 }}
                                </h3>
                            </div>
                            <p class="d-flex justify-content-between">
                                @if ($percentage_open_chat < 0)
                                @lang('index.since_last_month')
                                    <span class="text-danger d-flex align-items-center gap4">{{ $percentage_open_chat }}%<iconify-icon icon="teenyicons:down-solid"
                                            width="16"></iconify-icon> </span>
                                    
                                @else
                                @lang('index.since_last_month')
                                    <span class="text-success d-flex align-items-center gap4">+{{ $percentage_open_chat }}%<iconify-icon icon="teenyicons:up-solid"
                                            width="16"></iconify-icon> </span>
                                    
                                @endif
                            </p>
                            <div class="icon success_icon">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_561_1021)">
                                    <path d="M26.3965 23.8262C29.1211 21.418 30.8086 18.0781 30.8086 14.3926C30.8086 7.04492 24.0938 1.08594 15.8086 1.08594C7.52344 1.08594 0.808594 7.04492 0.808594 14.3926C0.808594 21.7402 7.52344 27.7051 15.8086 27.7051C17.2617 27.7051 18.7148 27.5176 20.1211 27.1484L28.4883 29.8672C29.3613 30.1543 30.0938 29.1641 29.5723 28.4082L26.3965 23.8262ZM9.72656 16.1738C8.70117 16.1738 7.86914 15.3418 7.86914 14.3105C7.86914 13.2793 8.70117 12.4531 9.73242 12.4531C10.7578 12.4531 11.5898 13.2852 11.5898 14.3105C11.5898 15.3418 10.7578 16.1738 9.72656 16.1738ZM15.8086 16.1738C14.7832 16.1738 13.9512 15.3418 13.9512 14.3164C13.9512 13.291 14.7832 12.459 15.8086 12.459C16.834 12.459 17.666 13.291 17.666 14.3164C17.666 15.3418 16.834 16.1738 15.8086 16.1738ZM21.8906 16.1738C20.8652 16.1738 20.0332 15.3418 20.0332 14.3164C20.0332 13.291 20.8652 12.459 21.8906 12.459C22.916 12.459 23.748 13.291 23.748 14.3164C23.748 15.3418 22.916 16.1738 21.8906 16.1738Z" fill="#2CA87F"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_561_1021">
                                    <rect width="30" height="30" fill="white" transform="translate(0.808594 0.5)"/>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                    
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <a class="text-dec-none" href="{{ route('agent.index') }}">
                        <div class="small-box box4column">
                            <div class="inner">
                                <p>@lang('index.total_agents')</p>
                                <h3>{{ $total_agents }}</h3>
                            </div>
                            <p class="d-flex justify-content-between">
                                @if ($percentage_agents < 0)
                                    @lang('index.since_last_month')
                                    <span class="text-danger d-flex align-items-center gap4">{{ $percentage_agents }}%<iconify-icon icon="teenyicons:down-solid"
                                            width="16"></iconify-icon> </span>                                    
                                @else
                                    @lang('index.since_last_month')
                                    <span class="text-success d-flex align-items-center gap4">+{{ $percentage_agents }}%<iconify-icon icon="teenyicons:up-solid"
                                            width="16"></iconify-icon> </span>                                    
                                @endif
                            </p>
                            <div class="icon red_icon">
                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_561_1025)">
                                    <path d="M15.8117 16.0783C20.0974 16.0783 23.6008 12.5749 23.6008 8.28913C23.6008 4.00339 20.0974 0.5 15.8117 0.5C11.5259 0.5 8.02261 4.00339 8.02261 8.28913C8.02261 12.5749 11.526 16.0783 15.8117 16.0783ZM29.1791 22.3027C28.975 21.7925 28.7029 21.3163 28.3968 20.8742C26.8321 18.5612 24.4172 17.0306 21.6961 16.6564C21.356 16.6225 20.9819 16.6904 20.7097 16.8945C19.2811 17.949 17.5805 18.4932 15.8117 18.4932C14.043 18.4932 12.3423 17.949 10.9138 16.8945C10.6416 16.6904 10.2675 16.5884 9.92736 16.6564C7.20627 17.0306 4.75731 18.5612 3.22671 20.8742C2.92059 21.3163 2.64846 21.8266 2.44442 22.3027C2.3424 22.5068 2.37639 22.7449 2.4784 22.949C2.75054 23.4252 3.09064 23.9014 3.39676 24.3096C3.87293 24.9559 4.38316 25.534 4.96141 26.0783C5.43758 26.5544 5.98179 26.9966 6.52606 27.4388C9.2131 29.4456 12.4444 30.5 15.7778 30.5C19.1111 30.5 22.3424 29.4456 25.0294 27.4388C25.5737 27.0307 26.1179 26.5544 26.5941 26.0783C27.1383 25.534 27.6825 24.9558 28.1587 24.3096C28.4988 23.8674 28.805 23.4252 29.0771 22.949C29.2471 22.7449 29.2811 22.5068 29.1791 22.3027Z" fill="#DC2626"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_561_1025">
                                    <rect width="30" height="30" fill="white" transform="translate(0.808594 0.5)"/>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                    
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
        <input type="hidden" name="six_month" id="six_month_value" value="@lang('index.last_six_months')">
        <input type="hidden" name="one_year" id="one_year_value" value="@lang('index.last_one_year')">
        <!-- Chart -->
        <div class="row grap-row">
            <div class="col-md-8 col-xs-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h3 class="top-left-header">@lang('index.ticket') (<span
                                id="month_span">@lang('index.last_six_months')</span>)

                        </h3>
                        <div class= w-25 mt-2">
                            <select name="filter_chart_name" id="filter_chart_month" class="form-control me-2">
                                <option value="6">@lang('index.last_six_months')</option>
                                <option value="12">@lang('index.last_one_year')</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive responsive-table">
                            <canvas height="130px" id="dashboardGraph"></canvas>
                        </div>
                    </div>
                </div>
                <!--table-responsive-->
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        @if (appTheme() == 'multiple')
                            <h3 class="top-left-header">@lang('index.ticket_by_category')
                            </h3>
                        @else
                            <h3 class="top-left-header">@lang('index.ticket_by_department')
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive responsive-table">
                            <canvas height="130px" id="ticketByCategory"></canvas>
                        </div>
                    </div>
                </div>
                <!--table-responsive-->
            </div>
        </div>

        <!-- Ticket need Attention -->
        <div class="row my-3">
            <div class="col-md-12">
                <div class="box-wrapper">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header">
                        @lang('index.ticket_need_action')</h3>
                    <!-- Search -->
                    <form action="{{ url('dashboard') }}" method="GET">
                        <div class="row" id="custom-button-group">
                            <div class="col-xl-12 col-12 mt-2">
                                <div dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="d-flex p-t-btn"
                                    id="ticket_index_search_btn">
                                    <a data-key="n_action"
                                        class="btn custom_header_btn {{ !isset($key) || (isset($key) && $key == 'n_action') ? 'ticket-btn-active' : '' }} ticket-list-btn "
                                        href="{{ url('dashboard?key=n_action') }}"><span
                                            class="badge_c">{{ count(needActionTicketIds()) }}</span>
                                        @lang('index.need_action')</a>
                                    <a data-key="open_seven_plus_d"
                                        class="btn custom_header_btn {{ isset($key) && $key == 'open_seven_plus_d' ? 'ticket-btn-active' : '' }} ticket-list-btn "
                                        href="{{ url('dashboard?key=open_seven_plus_d') }}"><span
                                            class="badge_c">{{ $open_for_seven_d }}</span> @lang('index.open_for_seven_d')</a>
                                    <a data-key="open"
                                        class="btn custom_header_btn {{ isset($key) && $key == 'open' ? 'ticket-btn-active' : '' }} ticket-list-btn "
                                        href="{{ url('dashboard?key=open') }}"><span
                                            class="badge_c">{{ $all_t_open }}</span> @lang('index.open')</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="table-box">
                        <div class="table-responsive">
                            <table id="dashboard_datatable_ticket" class="table">
                                <thead>
                                    <tr>
                                        <th class="w-5">@lang('index.ticket_id')</th>
                                        <th class="w-25">@lang('index.title')</th>
                                        @if (appTheme() == 'multiple')
                                            <th class="w-10">@lang('index.product_category')</th>
                                        @endif
                                        @if (appTheme() == 'single')
                                            <th class="w-10">@lang('index.department')</th>
                                        @endif
                                        <th class="w-10">@lang('index.customer')</th>
                                        <th class="w-10">@lang('index.created_at')</th>
                                        <th class="w-10">@lang('index.updated_at')</th>
                                        <th class="w-15">@lang('index.last_commented_by')</th>
                                        <th class="w-10">@lang('index.action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    @include('layouts.data_table_script')
    <script src="{{ asset('assets/chart/chart.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/dashboard.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/admin_agent_dashboard.js?var=2.2') }}"></script>
@endpush
