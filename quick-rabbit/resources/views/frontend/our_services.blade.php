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
                <h2 class="mb-0">@lang('index.our_services')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.pages')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    <div class="service-content position-relative">
        <div class="container" data-aos="fade-up" data-aos-duration="3000">
            <div class="position-relative">
                <div class="row justify-content-center service-wrapper position-relatives">

                    <div class="col-12 col-md-4">
                        <div class="service-card">
                            <div class="card-body">
                                <div class="service-icon">
                                    <img src="{{ isset(ourService()['section_one_image']) && ourService()['section_one_image'] != '' ? asset('uploads/settings/' . ourService()['section_one_image']) : asset('assets/frontend/img/core-img/service-1.svg') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h5>{{ ourService()['sr_section_one_text'] ?? '' }}</h5>
                                    <p>{{ ourService()['sr_section_one_content'] ?? '' }}</p>
                                </div>
                                <div class="service-arrow service_read_more" data-title="{{ ourService()['sr_section_one_text'] ?? '' }}" data-content="{{ ourService()['sr_section_one_content'] ?? '' }}" dat data-bs-toggle="modal" data-bs-target="#serviceModal">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="service-card">
                            <div class="card-body">
                                <div class="service-icon">
                                    <img src="{{ isset(ourService()['section_two_image']) && ourService()['section_two_image'] != '' ? asset('uploads/settings/' . ourService()['section_two_image']) : asset('assets/frontend/img/core-img/service-2.svg') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h5>{{ ourService()['sr_section_two_text'] ?? '' }}</h5>
                                    <p>{{ ourService()['sr_section_two_content'] ?? '' }}</p>
                                </div>
                                <div class="service-arrow service_read_more" data-title="{{ ourService()['sr_section_two_text'] ?? '' }}" data-content="{{ ourService()['sr_section_two_content'] ?? '' }}" dat data-bs-toggle="modal" data-bs-target="#serviceModal">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="service-card">
                            <div class="card-body">
                                <div class="service-icon">
                                    <img src="{{ isset(ourService()['section_five_image']) && ourService()['section_five_image'] != '' ? asset('uploads/settings/' . ourService()['section_five_image']) : asset('assets/frontend/img/core-img/service-5.svg') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h5>{{ ourService()['sr_section_five_text'] ?? '' }}</h5>
                                    <p>{{ ourService()['sr_section_five_content'] ?? '' }}</p>
                                </div>
                                <div class="service-arrow service_read_more" data-title="{{ ourService()['sr_section_five_text'] ?? '' }}" data-content="{{ ourService()['sr_section_five_content'] ?? '' }}" dat data-bs-toggle="modal" data-bs-target="#serviceModal">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="service-card">
                            <div class="card-body">
                                <div class="service-icon">
                                    <img src="{{ isset(ourService()['section_three_image']) && ourService()['section_three_image'] != '' ? asset('uploads/settings/' . ourService()['section_three_image']) : asset('assets/frontend/img/core-img/service-4.svg') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h5>{{ ourService()['sr_section_three_text'] ?? '' }}</h5>
                                    <p>{{ ourService()['sr_section_three_content'] ?? '' }}</p>
                                </div>
                                <div class="service-arrow service_read_more" data-title="{{ ourService()['sr_section_three_text'] ?? '' }}" data-content="{{ ourService()['sr_section_three_content'] ?? '' }}" dat data-bs-toggle="modal" data-bs-target="#serviceModal">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="service-card">
                            <div class="card-body">
                                <div class="service-icon">
                                    <img src="{{ isset(ourService()['section_four_image']) && ourService()['section_four_image'] != '' ? asset('uploads/settings/' . ourService()['section_four_image']) : asset('assets/frontend/img/core-img/service-3.svg') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h5>{{ ourService()['sr_section_four_text'] ?? '' }}</h5>
                                    <p>{{ ourService()['sr_section_four_content'] ?? '' }}</p>
                                </div>
                                <div class="service-arrow service_read_more" data-title="{{ ourService()['sr_section_four_text'] ?? '' }}" data-content="{{ ourService()['sr_section_four_content'] ?? '' }}" dat data-bs-toggle="modal" data-bs-target="#serviceModal">
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
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-12 col-md-4">
                        <div class="service-card">
                            <div class="card-body">
                                <div class="service-icon">
                                    <img src="{{ isset(ourService()['section_six_image']) && ourService()['section_six_image'] != '' ? asset('uploads/settings/' . ourService()['section_six_image']) : asset('assets/frontend/img/core-img/service-6.svg') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h5>{{ ourService()['sr_section_six_text'] ?? '' }}</h5>
                                    <p>{{ ourService()['sr_section_six_content'] ?? '' }}</p>
                                </div>
                                <div class="service-arrow service_read_more" data-title="{{ ourService()['sr_section_six_text'] ?? '' }}" data-content="{{ ourService()['sr_section_six_content'] ?? '' }}" dat data-bs-toggle="modal" data-bs-target="#serviceModal">
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
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="our_feature_sec">
        <div class="container" data-aos="fade-up" data-aos-duration="3000">
            <div class="row justify-content-between our_feature_row">
                <div class="col-12 col-xl-4">
                    <div class="about-left-sec">
                        <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                            @include('frontend.svg.star')
                            @lang('index.core_feature')
                        </p>
                        <h2 class="section-title text-left w-100">{!! sectionTitleSplit(ourService()['feature_section_title'] ?? '') !!}</h2>
                        
                    </div>
                </div>

                <div class="col-12 col-xl-8">
                    <div class="row about-card-wrapper">

                        <div class="col-12 col-sm-6">
                            <div class="card about-card">
                                <div class="card-body">
                                    <div class="icon">
                                        <img src="{{ isset(ourService()['box_one_icon']) && ourService()['box_one_icon'] != '' ? asset('uploads/settings/' . ourService()['box_one_icon']) : asset('assets/frontend/img/core-img/about-card1.svg') }}"
                                            alt="">                                        
                                    </div>
                                    <div>
                                        <h5 class="mb-3">{{ ourService()['sr_box_one_title'] ?? '' }}</h5>
                                        <p class="mb-0">{{ ourService()['sr_box_one_content'] ?? '' }}</p>
                                    </div>
                                    <div class="no_img_wrapper">
                                        <img src="{{ asset('assets/frontend/img/core-img/01.svg') }}" alt=""
                                            class="no_img">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="card about-card">
                                <div class="card-body">
                                    <div class="icon">
                                        <img src="{{ isset(ourService()['box_two_icon']) && ourService()['box_two_icon'] != '' ? asset('uploads/settings/' . ourService()['box_two_icon']) : asset('assets/frontend/img/core-img/about-card2.svg') }}"
                                            alt="">
                                        
                                    </div>
                                    <div>
                                        <h5 class="mb-3">{{ ourService()['sr_box_two_title'] ?? '' }}</h5>
                                        <p class="mb-0">{{ ourService()['sr_box_two_content'] ?? '' }}</p>
                                    </div>
                                    <div class="no_img_wrapper">
                                        <img src="{{ asset('assets/frontend/img/core-img/02.svg') }}" alt=""
                                            class="no_img">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="card about-card active">
                                <div class="card-body">
                                    <div class="icon">
                                        <img src="{{ isset(ourService()['box_three_icon']) && ourService()['box_three_icon'] != '' ? asset('uploads/settings/' . ourService()['box_three_icon']) : asset('assets/frontend/img/core-img/about-card3.svg') }}"
                                            alt="">
                                        
                                    </div>
                                    <div>
                                        <h5 class="mb-3">{{ ourService()['sr_box_three_title'] ?? '' }}</h5>
                                        <p class="mb-0">{{ ourService()['sr_box_three_content'] ?? '' }}</p>
                                    </div>
                                    <div class="no_img_wrapper">
                                        <img src="{{ asset('assets/frontend/img/core-img/03.svg') }}" alt=""
                                            class="no_img">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="card about-card">
                                <div class="card-body">
                                    <div class="icon">
                                        <img src="{{ isset(ourService()['box_four_icon']) && ourService()['box_four_icon'] != '' ? asset('uploads/settings/' . ourService()['box_four_icon']) : asset('assets/frontend/img/core-img/about-card4.svg') }}"
                                            alt="">
                                        
                                    </div>
                                    <div>
                                        <h5 class="mb-3">{{ ourService()['sr_box_four_title'] ?? '' }}</h5>
                                        <p class="mb-0">{{ ourService()['sr_box_four_content'] ?? '' }}</p>
                                    </div>
                                    <div class="no_img_wrapper">
                                        <img src="{{ asset('assets/frontend/img/core-img/04.svg') }}" alt=""
                                            class="no_img">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.__our_service_model')
@endsection
