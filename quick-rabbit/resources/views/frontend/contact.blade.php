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
                <h2 class="mb-0">@lang('index.contact_us')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.pages')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    <div class="contact_page_wrapper">
        <div class="container contact_page" data-aos="fade-up" data-aos-duration="3000">
            <div class="d-flex contact_page_top">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-6 form_section">
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="">
                                    <h4 class="section-title text-left">@lang('index.get_in_touch_with_us')</h4>
                                    <p class="section-subtitle text-left">@lang('index.contact_us_quote')</p>
                                </div>
                            </div>
                        </div>
                        <div class="card p-0">
                            <div class="card-body p-0">
                                <form action="{{ route('store-message') }}" id="formContact" method="POST" class="form_contact">
                                    @csrf
                                    <div class="row contact-form">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group form_contact_group_name">
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name') }}"
                                                    class="form-control contact_name @error('name') is-invalid @enderror"
                                                    placeholder="@lang('index.full_name')">
                                                <span class="text-danger contact_name_r required_symbol">*</span>
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group form_contact_group_email">
                                                <input type="email" value="{{ old('email') }}" name="email"
                                                    id="email"
                                                    class="form-control contact_email @error('email') is-invalid @enderror"
                                                    placeholder="@lang('index.email')">
                                                <span class="text-danger contact_email_r required_symbol">*</span>
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <div class="form-group form_contact_group_subject">
                                                <input type="text" value="{{ old('subject') }}" name="subject"
                                                    id="subject"
                                                    class="form-control contact_subject @error('subject') is-invalid @enderror"
                                                    placeholder="@lang('index.subject')">
                                                <span class="text-danger contact_subject_r required_symbol">*</span>
                                                @error('subject')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea name="message" class="form-control contact-message @error('message') is-invalid @enderror"
                                                    placeholder="@lang('index.type_your_message_here')" id="message" name="message" cols="30" rows="20" maxlength="1000"></textarea>
                                                @error('message')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" id="isCaptchaEnable" value="{{ isCaptchaEnable() }}">
                                        @if (isCaptchaEnable())
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="captcha-box d-flex align-items-center mb-3">
                                                    <canvas id="canvas"></canvas>
                                                    <a href="javascript:void(0)" id="change-code" class="reset-btn">
                                                        <img src="{{ asset('assets/frontend/img/core-img/repeat.svg') }}"
                                                            alt="">
                                                    </a>
                                                </div>

                                                <input name="code" class="form-control col-md-3 code-input-control"
                                                    id="code" placeholder="@lang('index.captcha_code')">
                                                <span id="captcha-error" class="text-danger d-none">@lang('index.invalid_captcha_code')</span>
                                            </div>
                                        </div>                                      
                                        @endif
                                        <div class="col-12">
                                            <button class="gt-btn send_message_btn comment-submit-button" type="submit">
                                                @lang('index.send_msg')
                                                <span class="icon">
                                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.545 1.40324L10.4939 12.695C10.4649 12.9031 10.3694 13.0963 10.2218 13.2457C10.0741 13.3952 9.88214 13.493 9.67442 13.5245C9.4667 13.5561 9.25435 13.5198 9.06896 13.4209C8.88357 13.322 8.73505 13.166 8.64551 12.9759L6.39267 8.24091C6.38365 8.22375 6.37131 8.20854 6.35638 8.19618C6.34145 8.18381 6.32421 8.17453 6.30567 8.16886L1.37227 6.92424C1.17401 6.87371 0.995994 6.76365 0.862173 6.60889C0.728352 6.45413 0.645151 6.26209 0.623768 6.05861L0.620648 6.03291C0.596232 5.82634 0.637613 5.61733 0.738897 5.43565C0.840183 5.25396 0.996208 5.10887 1.18476 5.02102L11.1587 0.297653C11.3186 0.22318 11.4957 0.193633 11.671 0.212179C11.8464 0.230725 12.0133 0.296667 12.1541 0.402927C12.3063 0.516355 12.4237 0.670247 12.4928 0.847091C12.5619 1.02393 12.58 1.21663 12.545 1.40324Z" fill="#5065E2"/>
                                                        </svg>  
                                                </span>                                               
                                            </button>
                                        </div>
                                        @if (Session::has('message'))
                                            <div class="col-12">
                                                <div
                                                    class="alert alert-{{ Session::get('type') ?? 'info' }} alert-dismissible fade show">
                                                    <div class="alert-body">
                                                        <span><i class="m-right bi bi-check"></i>
                                                            {{ Session::get('message') }}</span>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 contact_info">
                        <div class="row g-4">
                            <div class="col-12 col-sm-12 col-lg-12 col-xl-12 inside_contact">
                                <div class="section_wrapper">
                                    <div class="header">

                                        <h4>@lang('index.call_to_us')</h4>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <i class="bi bi-telephone"></i>
                                            <a href="tel:{{ siteSetting()->phone ?? '' }}">@lang('index.phone'):
                                                &nbsp;{{ siteSetting()->phone ?? '' }}</a>
                                        </div>
                                        <div class="content">
                                            <i class="bi bi-whatsapp"></i>
                                            <a href="https://wa.me/{{ siteSetting()->phone ?? '' }}">@lang('index.whats_app'):
                                                &nbsp;{{ siteSetting()->phone ?? '' }}</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="section_wrapper">
                                    <div class="header">
                                        <h4>@lang('index.write_to_us')</h4>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <i class="bi bi-envelope"></i>
                                            <a
                                                href="mailto:{{ siteSetting()->email ?? '' }}">{{ siteSetting()->email ?? '' }}</a>
                                        </div>
                                        <div class="content">
                                            <i class="bi bi-skype"></i>
                                            <a
                                                href="skype:{{ siteSetting()->skype ?? '' }}?chat">{{ siteSetting()->skype ?? '' }}</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="section_wrapper">
                                    <div class="header">
                                        <h4>@lang('index.visit_us')</h4>
                                    </div>
                                    <div class="body">
                                        <div class="content d-flex align-items-baseline">
                                            <i class="bi bi-building"></i>
                                            <p> {{ siteSetting()->address ?? '' }}</p>
                                        </div>
                                        <div class="content d-flex align-items-baseline">
                                            <i class="bi bi-clock"></i>
                                            <p>
                                                @foreach (chatSchedules() ?? [] as $schedule)
                                                    @if ($loop->first)
                                                        {{ $schedule }} -
                                                    @endif
                                                    @if ($loop->last)
                                                        {{ $schedule }}
                                                    @endif
                                                @endforeach
                                                :
                                                <br>
                                                <span>{{ chatScheduleTime()['start_time'] . ' - ' . chatScheduleTime()['end_time'] }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5"></div>
        @if (siteSetting()->g_map_url != null)            
        <!-- Google Maps -->
        <div class="t-container cp-container map_section" data-aos="fade-up" data-aos-duration="3000">
            <div class="gm-wrap mt-5">
                <iframe src="{{ asset(siteSetting()->g_map_url) }}"></iframe>
            </div>
        </div>        
        @endif
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/jquery-captcha/jquery-captcha.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/contact.js') }}"></script>
@endpush