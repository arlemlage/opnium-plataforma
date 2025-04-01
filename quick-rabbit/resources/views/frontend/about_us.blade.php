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
                <h2 class="mb-0">@lang('index.about_us')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.pages')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    </div>
    <!-- About Area -->
    <div class="about-area-top" data-aos="fade-up" data-aos-duration="3000">
        <div class="container">
            <div class="row align-items-start justify-content-between about-area-row">
                <div class="col-12 col-md-6 p-0">
                    <div class="rounded-4">
                        <img class="rounded-4 img-about-us"
                            src="{{ isset(aboutUs()['about_us_image']) && aboutUs()['about_us_image'] != '' ? asset('uploads/settings/' . aboutUs()['about_us_image']) : asset('assets/frontend/img/core-img/about-us1.svg') }}"
                            alt="">
                    </div>
                </div>

                <div class="col-12 col-md-6 p-0">
                    <div class="aboutUs-content">
                        <div class="top-content">
                            <h2 class="section-title text-left">{!! aboutUs()['title'] ?? '' !!}
                            </h2>
                        </div>
                        <p>{!! aboutUs()['about_us_content'] ?? '' !!}</p>
                        <div class="what_we_offer">
                        <h4>@lang('index.what_we_offer')</h4>
                        <ul class="list-unstyled we_offer_list">
                            @foreach (aboutUs()['offer'] as $key => $vl)
                                <li><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_303_1390)">
                                            <path
                                                d="M8 15C6.14348 15 4.36301 14.2625 3.05025 12.9497C1.7375 11.637 1 9.85652 1 8C1 6.14348 1.7375 4.36301 3.05025 3.05025C4.36301 1.7375 6.14348 1 8 1C9.85652 1 11.637 1.7375 12.9497 3.05025C14.2625 4.36301 15 6.14348 15 8C15 9.85652 14.2625 11.637 12.9497 12.9497C11.637 14.2625 9.85652 15 8 15ZM8 16C10.1217 16 12.1566 15.1571 13.6569 13.6569C15.1571 12.1566 16 10.1217 16 8C16 5.87827 15.1571 3.84344 13.6569 2.34315C12.1566 0.842855 10.1217 0 8 0C5.87827 0 3.84344 0.842855 2.34315 2.34315C0.842855 3.84344 0 5.87827 0 8C0 10.1217 0.842855 12.1566 2.34315 13.6569C3.84344 15.1571 5.87827 16 8 16Z"
                                                fill="#727272" />
                                            <path
                                                d="M10.9699 4.96997L10.9499 4.99198L7.47685 9.41698L5.38385 7.32298C5.24168 7.1905 5.05363 7.11837 4.85933 7.1218C4.66503 7.12523 4.47964 7.20394 4.34223 7.34135C4.20482 7.47877 4.1261 7.66415 4.12268 7.85845C4.11925 8.05275 4.19137 8.2408 4.32385 8.38298L6.96985 11.03C7.04113 11.1011 7.12601 11.1572 7.21943 11.1948C7.31285 11.2325 7.4129 11.2509 7.5136 11.249C7.61429 11.2472 7.71359 11.225 7.80555 11.184C7.89751 11.1429 7.98025 11.0837 8.04885 11.01L12.0409 6.01998C12.1768 5.87731 12.2511 5.68687 12.2477 5.48984C12.2444 5.29282 12.1636 5.10502 12.0229 4.96707C11.8822 4.82912 11.6928 4.75208 11.4958 4.75263C11.2987 4.75317 11.1098 4.83125 10.9699 4.96997Z"
                                                fill="#727272" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_303_1390">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    {{ $vl }}</li>
                            @endforeach
                        </ul>
                        </div>
                        <a href="{{ route('contact') }}" class="gt-btn">
                            @lang('index.contact_us') <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="milestone-card-wrap">
                <div class="fun-fact-card">
                    <div class="counter-col">
                        <div class="counter-card">
                            <h2 class="mb-2 counter">{{ aboutUs()['card_label_three_quantity'] ?? '' }}<span>+</span></h2>
                            <h5 class="mb-0">{{ aboutUs()['card_label_three'] ?? '' }}</h5>
                        </div>
                    </div>
                    <div class="counter-col">
                        <div class="counter-card">
                            <h2 class="mb-2 counter">{{ aboutUs()['card_label_one_quantity'] ?? '' }}<span>+</span></h2>
                            <h5 class="mb-0">{{ aboutUs()['card_label_one'] ?? '' }}</h5>
                        </div>
                    </div>
                    <div class="counter-col">
                        <div class="counter-card">
                            <h2 class="mb-2 counter">{{ aboutUs()['card_label_two_quantity'] ?? '' }}<span>+</span></h2>
                            <h5 class="mb-0">{{ aboutUs()['card_label_two'] ?? '' }}</h5>
                        </div>
                    </div>
                    <div class="counter-col">
                        <div class="counter-card">
                            <h2 class="mb-2 counter">{{ aboutUs()['card_label_four_quantity'] ?? '' }}<span>+</span></h2>
                            <h5 class="mb-0">{{ aboutUs()['card_label_four'] ?? '' }}</h5>
                        </div>
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
            <div data-aos="fade-up" data-aos-duration="1000">
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

    <div class="about-area">
        <div class="container">
            <div class="row align-items-start">
                <!-- About Us Thumbnail -->
                <div class="col-12 col-md-6">
                    <div class="aboutUs-thumbnail">
                        <img class="rounded-4 w-100"
                            src="{{ isset(aboutUs()['about_us_image_bottom']) && aboutUs()['about_us_image_bottom'] != '' ? asset('uploads/settings/' . aboutUs()['about_us_image_bottom']) : asset('assets/frontend/img/core-img/about-img2.svg') }}"
                            alt="">
                    </div>
                </div>

                <!-- About Us Content -->
                <div class="col-12 col-md-6">
                    <div class="aboutus-content">
                        <div class="">
                            <p class="text-uppercase text-secondary section_header text-size-20 m-0">
                                @include('frontend.svg.star')
                                @lang('index.the_support_portal')
                            </p>
                            <h2 class="section-title text-left">@lang('index.how_it_works')</h2>
                        </div>

                        <div class="work-step-wrapper">
                            <!-- Single Work -->
                            <?php
                            $counter = 1;
                            $counter_tmp = 1;
                            $our_work_steps = aboutUs()['our_work_steps'] ?? '';
                            $our_work_descriptions = aboutUs()['our_work_descriptions'] ?? '';
                            $icon = aboutUs()['icon'] ?? '';
                            $our_work_steps = explode('|||', $our_work_steps);
                            $our_work_descriptions = explode('|||', $our_work_descriptions);
                            $icon = explode('|||', $icon);
                            ?>
                            @foreach ($our_work_steps as $key => $vl)
                                <?php
                                $image = ['work-1.svg', 'work-2.svg', 'work-3.svg'];
                                ?>
                                <div class="single-work-step d-flex align-items-start">
                                    <div class="work-step-icon">
                                        <span>{{ str_pad($counter++, 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div class="work-step-text">
                                        <h5>{{ $vl }}</h5>
                                        <p class="mb-0">{{ $our_work_descriptions[$key] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
