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
                <h2 class="mb-0">@lang('index.reset_password')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (urlPrefix() == 'reset-password-step-one')
                            @lang('index.step_1')
                        @elseif(urlPrefix() == 'reset-password-step-two')
                            @lang('index.step_2')
                        @elseif(urlPrefix() == 'reset-password-step-three')
                            @lang('index.step_3')
                        @elseif(urlPrefix() == 'reset-password-success')
                            @lang('index.success')
                        @endif
                    </li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    <div class="register-wrapper forgot_password_wrapper  @if (urlPrefix() == 'reset-password-success') forgot_success_wrapper @endif"
        id="focused-div">
        <input type="hidden" id="active_page" value="Forgot">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div class="form_card">
                        <div class="text-center top_text {{ urlPrefix() == 'reset-password-step-two' ? 'step-two' : '' }} {{ urlPrefix() == 'reset-password-success' ? 'd-none' : '' }}">
                            <h2 class="display-6">
                                @if (urlPrefix() == 'reset-password-step-one')
                                    @lang('index.confirm_email')
                                @elseif(urlPrefix() == 'reset-password-step-two')
                                    @lang('index.security_question_answer')
                                @elseif(urlPrefix() == 'reset-password-step-three')
                                    @lang('index.step_3')
                                @endif
                            </h2>
                            <p class="mb-0">
                                @if (urlPrefix() == 'reset-password-step-one')
                                    @lang('index.step_one_quoto')
                                @elseif(urlPrefix() == 'reset-password-step-two')
                                    @lang('index.step_two_quoto')
                                @elseif(urlPrefix() == 'reset-password-step-three')
                                    @lang('index.step_three_quoto')
                                @endif
                            </p>

                        </div>
                        <div>
                            <!-- Step One -->
                            @if (urlPrefix() == 'reset-password-step-one')
                                <form action="{{ route('check-email') }}" class="forgot-password-form" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email">@lang('index.email')</label>
                                        <div>
                                            <div class="position-relative">
                                                <input name="email" type="email"
                                                    value="{{ old('email') ?? (session()->get('rp_email') ?? '') }}"
                                                    class="form-control @if (Session::has('message')) is-invalid @endif"
                                                    placeholder="@lang('index.email')">
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
                                            @if (Session::has('message'))
                                                <p class="text-danger"><i
                                                        class="bi bi-info-circle"></i>&nbsp;{{ Session::get('message') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 submit_btn"
                                        disabled>@lang('index.continue')
                                    </button>
                                </form>
                            @endif

                            <!-- Step Two -->
                            @if (urlPrefix() == 'reset-password-step-two')
                                <form action="{{ route('check-question-answer') }}"
                                    class="forgot-password-form forgot-password-form-step-2" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <div>
                                        <label for="forgetPassSelect">@lang('index.select_question')</label>
                                        <div class="position-relative">
                                            <select name="question" id="forgetPassSelect"
                                                class="hero-form-select @error('question') is-invalid @enderror"
                                                aria-label="Default select example">
                                                <option value="">@lang('index.select_security_question')</option>
                                                @foreach ($questions as $question)
                                                    <option value="{{ $question }}"
                                                        {{ old('question') == $question || session()->get('rp_question') == $question ? 'selected' : '' }}>
                                                        {{ $question }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="question_icon" width="16" height="16" viewBox="0 0 16 16"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_443_2515)">
                                                    <path
                                                        d="M8 15C6.14348 15 4.36301 14.2625 3.05025 12.9497C1.7375 11.637 1 9.85652 1 8C1 6.14348 1.7375 4.36301 3.05025 3.05025C4.36301 1.7375 6.14348 1 8 1C9.85652 1 11.637 1.7375 12.9497 3.05025C14.2625 4.36301 15 6.14348 15 8C15 9.85652 14.2625 11.637 12.9497 12.9497C11.637 14.2625 9.85652 15 8 15ZM8 16C10.1217 16 12.1566 15.1571 13.6569 13.6569C15.1571 12.1566 16 10.1217 16 8C16 5.87827 15.1571 3.84344 13.6569 2.34315C12.1566 0.842855 10.1217 0 8 0C5.87827 0 3.84344 0.842855 2.34315 2.34315C0.842855 3.84344 0 5.87827 0 8C0 10.1217 0.842855 12.1566 2.34315 13.6569C3.84344 15.1571 5.87827 16 8 16Z"
                                                        fill="#727272" />
                                                    <path
                                                        d="M5.25412 5.786C5.25275 5.81829 5.258 5.85053 5.26955 5.88072C5.2811 5.91091 5.2987 5.93841 5.32127 5.96155C5.34385 5.98468 5.37091 6.00296 5.40081 6.01524C5.43071 6.02753 5.4628 6.03357 5.49512 6.033H6.32012C6.45812 6.033 6.56812 5.92 6.58612 5.783C6.67612 5.127 7.12612 4.649 7.92812 4.649C8.61412 4.649 9.24212 4.992 9.24212 5.817C9.24212 6.452 8.86812 6.744 8.27712 7.188C7.60412 7.677 7.07112 8.248 7.10912 9.175L7.11212 9.392C7.11317 9.45761 7.13997 9.52017 7.18674 9.5662C7.23351 9.61222 7.2965 9.63801 7.36212 9.638H8.17312C8.23942 9.638 8.30301 9.61166 8.3499 9.56478C8.39678 9.51789 8.42312 9.4543 8.42312 9.388V9.283C8.42312 8.565 8.69612 8.356 9.43312 7.797C10.0421 7.334 10.6771 6.82 10.6771 5.741C10.6771 4.23 9.40112 3.5 8.00412 3.5C6.73712 3.5 5.34912 4.09 5.25412 5.786ZM6.81112 11.549C6.81112 12.082 7.23612 12.476 7.82112 12.476C8.43012 12.476 8.84912 12.082 8.84912 11.549C8.84912 10.997 8.42912 10.609 7.82012 10.609C7.23612 10.609 6.81112 10.997 6.81112 11.549Z"
                                                        fill="#727272" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_443_2515">
                                                        <rect width="16" height="16" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="answer">@lang('index.answer')</label>
                                        <div>
                                            <div class="position-relative">
                                                <input name="answer"
                                                    value="{{ old('answer') ?? session()->get('rp_answer') }}"
                                                    type="answer"
                                                    class="form-control answer @if (Session::has('message')) is-invalid @endif"
                                                    placeholder="@lang('index.answer')">
                                                <svg class="answer_icon" width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_443_2525)">
                                                        <path
                                                            d="M10.8125 9.96875C10.6399 9.96875 10.5 10.1087 10.5 10.2812V12.4375C10.5 13.2991 9.79906 14 8.9375 14H5.5635C5.39097 14 5.25112 14.1398 5.251 14.3123L5.25056 14.9336L4.50469 14.1877C4.48038 14.132 4.44031 14.0845 4.3894 14.0511C4.33849 14.0178 4.27896 14 4.21809 14H2.1875C1.32594 14 0.625 13.2991 0.625 12.4375V7.625C0.625 6.76344 1.32594 6.0625 2.1875 6.0625H5.34375C5.51631 6.0625 5.65625 5.92259 5.65625 5.75C5.65625 5.57741 5.51631 5.4375 5.34375 5.4375H2.1875C0.981313 5.4375 0 6.41881 0 7.625V12.4375C0 13.6437 0.981313 14.625 2.1875 14.625H4.05806L5.34153 15.9085C5.38521 15.9522 5.44087 15.9819 5.50147 15.994C5.56207 16.0061 5.62488 15.9999 5.68197 15.9762C5.73906 15.9526 5.78788 15.9126 5.82223 15.8613C5.85659 15.8099 5.87495 15.7495 5.875 15.6877L5.87575 14.625H8.9375C10.1437 14.625 11.125 13.6437 11.125 12.4375V10.2812C11.125 10.1087 10.9851 9.96875 10.8125 9.96875Z"
                                                            fill="#727272" />
                                                        <path
                                                            d="M11.458 0H10.6671C8.16256 0 6.125 2.03756 6.125 4.54206C6.125 7.04656 8.16256 9.08409 10.667 9.08409H11.4579C11.8488 9.08409 12.2358 9.03444 12.6108 8.93631L13.7791 10.104C13.8228 10.1477 13.8785 10.1774 13.9391 10.1895C13.9997 10.2015 14.0625 10.1953 14.1196 10.1717C14.1767 10.148 14.2255 10.108 14.2598 10.0566C14.2942 10.0052 14.3125 9.94477 14.3125 9.88297V8.07497C14.8072 7.67437 15.2181 7.16834 15.5064 6.60303C15.834 5.96097 16 5.26756 16 4.54206C16 2.03756 13.9624 0 11.458 0ZM13.812 7.67297C13.7733 7.7021 13.7419 7.73981 13.7203 7.78313C13.6987 7.82645 13.6875 7.87419 13.6875 7.92259V9.12884L12.9228 8.36453C12.8826 8.32442 12.8323 8.296 12.7772 8.28232C12.7221 8.26863 12.6644 8.27021 12.6101 8.28687C12.2381 8.40119 11.8505 8.45912 11.458 8.45912H10.6671C8.50716 8.45912 6.75 6.70194 6.75 4.54206C6.75 2.38219 8.50719 0.625 10.6671 0.625H11.458C13.6178 0.625 15.375 2.38219 15.375 4.54206C15.375 5.78366 14.8053 6.92484 13.812 7.67297Z"
                                                            fill="#727272" />
                                                        <path
                                                            d="M12.4698 3.41939C12.4247 2.76517 11.8973 2.23779 11.2431 2.1927C10.8722 2.16723 10.5183 2.29232 10.2473 2.54523C9.98016 2.79464 9.82694 3.1472 9.82694 3.51254C9.82694 3.68514 9.96688 3.82504 10.1394 3.82504C10.312 3.82504 10.4519 3.68514 10.4519 3.51254C10.4519 3.31695 10.5308 3.13567 10.6738 3.00214C10.8168 2.86873 11.0036 2.8027 11.2001 2.81626C11.5448 2.84001 11.8225 3.11779 11.8463 3.46239C11.8703 3.81042 11.6419 4.11798 11.3034 4.19373C11.0291 4.2551 10.8375 4.49348 10.8375 4.77339V5.52417C10.8375 5.69676 10.9774 5.83667 11.15 5.83667C11.3226 5.83667 11.4625 5.69676 11.4625 5.52417V4.79835C12.0922 4.64623 12.5146 4.07004 12.4698 3.41939ZM11.3709 6.53935C11.3128 6.48123 11.2322 6.44779 11.15 6.44779C11.0678 6.44779 10.9872 6.48123 10.9291 6.53935C10.8707 6.59809 10.8378 6.67747 10.8375 6.76029C10.8375 6.84279 10.871 6.92342 10.9291 6.98154C10.9872 7.03967 11.0678 7.07279 11.15 7.07279C11.2322 7.07279 11.3128 7.03967 11.3709 6.98154C11.4293 6.92268 11.4622 6.84321 11.4625 6.76029C11.4625 6.6781 11.429 6.59748 11.3709 6.53935ZM8.59375 9.68748H2C1.82744 9.68748 1.6875 9.82739 1.6875 9.99998C1.6875 10.1726 1.82744 10.3125 2 10.3125H8.59375C8.76634 10.3125 8.90625 10.1726 8.90625 9.99998C8.90625 9.82739 8.76631 9.68748 8.59375 9.68748ZM8.81466 11.529C8.75656 11.4709 8.67594 11.4375 8.59375 11.4375C8.51156 11.4375 8.43094 11.4709 8.37281 11.529C8.31466 11.5872 8.28125 11.6678 8.28125 11.75C8.28125 11.8322 8.31469 11.9128 8.37281 11.9709C8.43094 12.029 8.51156 12.0625 8.59375 12.0625C8.67594 12.0625 8.75656 12.029 8.81466 11.9709C8.87312 11.9122 8.90604 11.8328 8.90625 11.75C8.90625 11.6678 8.87278 11.5872 8.81466 11.529ZM7.36459 11.4375H2C1.82744 11.4375 1.6875 11.5774 1.6875 11.75C1.6875 11.9226 1.82744 12.0625 2 12.0625H7.36459C7.53719 12.0625 7.67709 11.9226 7.67709 11.75C7.67709 11.5774 7.53716 11.4375 7.36459 11.4375ZM6.5625 7.93748H2C1.82744 7.93748 1.6875 8.07739 1.6875 8.24998C1.6875 8.42257 1.82744 8.56248 2 8.56248H6.5625C6.73509 8.56248 6.875 8.42257 6.875 8.24998C6.875 8.07739 6.73506 7.93748 6.5625 7.93748Z"
                                                            fill="#727272" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_443_2525">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                            </div>
                                            @if (Session::has('message'))
                                                <p class="text-danger"><i
                                                        class="bi bi-info-circle"></i>&nbsp;{{ Session::get('message') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>



                                    <button type="submit" class="btn btn-primary w-100">@lang('index.continue')
                                    </button>
                                </form>
                            @endif

                            <!-- Step Three -->
                            @if (urlPrefix() == 'reset-password-step-three')
                                <form action="{{ route('reset-password') }}" class="forgot-password-form" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">

                                    <div class="form-group password-sec">
                                        <label for="password">@lang('index.password')</label>
                                        <div>
                                            <div class="position-relative">
                                                <input name="new_password" type="password"
                                                    class="form-control f_pass password-field-for-js @if (Session::has('message')) is-invalid @endif"
                                                    placeholder="@lang('index.new_password')">
                                                <svg class="lock_icon" width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.99862 0.470581C5.64568 0.470581 3.76333 2.35293 3.76333 4.70588V6.58823C2.96333 6.58823 2.35156 7.19999 2.35156 7.99999V14.1176C2.35156 14.9176 2.96333 15.5294 3.76333 15.5294H12.2339C13.0339 15.5294 13.6457 14.9176 13.6457 14.1176V7.99999C13.6457 7.19999 13.0339 6.58823 12.2339 6.58823V4.70588C12.2339 2.35293 10.3516 0.470581 7.99862 0.470581ZM12.7045 7.99999V14.1176C12.7045 14.4 12.5163 14.5882 12.2339 14.5882H3.76333C3.48097 14.5882 3.29274 14.4 3.29274 14.1176V7.99999C3.29274 7.71764 3.48097 7.5294 3.76333 7.5294H12.2339C12.5163 7.5294 12.7045 7.71764 12.7045 7.99999ZM4.7045 6.58823V4.70588C4.7045 2.87058 6.16333 1.41176 7.99862 1.41176C9.83392 1.41176 11.2927 2.87058 11.2927 4.70588V6.58823H4.7045Z"
                                                        fill="#727272" />
                                                    <path
                                                        d="M7.9977 8.94116C7.1977 8.94116 6.58594 9.55293 6.58594 10.3529C6.58594 10.9647 6.96241 11.4823 7.52711 11.6706V12.7059C7.52711 12.9882 7.71535 13.1765 7.9977 13.1765C8.28006 13.1765 8.46829 12.9882 8.46829 12.7059V11.6706C9.033 11.4823 9.40947 10.9647 9.40947 10.3529C9.40947 9.55293 8.7977 8.94116 7.9977 8.94116ZM7.9977 10.8235C7.71535 10.8235 7.52711 10.6353 7.52711 10.3529C7.52711 10.0706 7.71535 9.88234 7.9977 9.88234C8.28006 9.88234 8.46829 10.0706 8.46829 10.3529C8.46829 10.6353 8.28006 10.8235 7.9977 10.8235Z"
                                                        fill="#727272" />
                                                </svg>
                                            </div>
                                            <img src="{{ asset('assets/frontend/img/core-img/password.svg') }}"
                                                alt="" class="password-icon" width="22">
                                            @if (Session::has('message'))
                                                <p class="text-danger"><i
                                                        class="bi bi-info-circle"></i>&nbsp;{{ Session::get('message') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group password-sec">
                                        <label for="confirm_password">@lang('index.confirm_password')</label>
                                        <div>
                                            <div class="position-relative">
                                            <input name="confirm_password" type="password"
                                                class="form-control f_cpass password-field-for-js @error('confirm_password') is-invalid @enderror"
                                                placeholder="@lang('index.confirm_password')">
                                                <svg class="lock_icon" width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.99862 0.470581C5.64568 0.470581 3.76333 2.35293 3.76333 4.70588V6.58823C2.96333 6.58823 2.35156 7.19999 2.35156 7.99999V14.1176C2.35156 14.9176 2.96333 15.5294 3.76333 15.5294H12.2339C13.0339 15.5294 13.6457 14.9176 13.6457 14.1176V7.99999C13.6457 7.19999 13.0339 6.58823 12.2339 6.58823V4.70588C12.2339 2.35293 10.3516 0.470581 7.99862 0.470581ZM12.7045 7.99999V14.1176C12.7045 14.4 12.5163 14.5882 12.2339 14.5882H3.76333C3.48097 14.5882 3.29274 14.4 3.29274 14.1176V7.99999C3.29274 7.71764 3.48097 7.5294 3.76333 7.5294H12.2339C12.5163 7.5294 12.7045 7.71764 12.7045 7.99999ZM4.7045 6.58823V4.70588C4.7045 2.87058 6.16333 1.41176 7.99862 1.41176C9.83392 1.41176 11.2927 2.87058 11.2927 4.70588V6.58823H4.7045Z"
                                                        fill="#727272" />
                                                    <path
                                                        d="M7.9977 8.94116C7.1977 8.94116 6.58594 9.55293 6.58594 10.3529C6.58594 10.9647 6.96241 11.4823 7.52711 11.6706V12.7059C7.52711 12.9882 7.71535 13.1765 7.9977 13.1765C8.28006 13.1765 8.46829 12.9882 8.46829 12.7059V11.6706C9.033 11.4823 9.40947 10.9647 9.40947 10.3529C9.40947 9.55293 8.7977 8.94116 7.9977 8.94116ZM7.9977 10.8235C7.71535 10.8235 7.52711 10.6353 7.52711 10.3529C7.52711 10.0706 7.71535 9.88234 7.9977 9.88234C8.28006 9.88234 8.46829 10.0706 8.46829 10.3529C8.46829 10.6353 8.28006 10.8235 7.9977 10.8235Z"
                                                        fill="#727272" />
                                                </svg>
                                            </div>
                                            <img src="{{ asset('assets/frontend/img/core-img/password.svg') }}"
                                                alt="" class="password-icon" width="22">
                                            @error('confirm_password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            @if (Session::has('message'))
                                                <p class="text-danger">{{ Session::get('message') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 padding-16 submit_button"
                                        disabled>@lang('index.submit')</button>
                                </form>
                            @endif
                            <!-- Success Step -->
                            @if (urlPrefix() == 'reset-password-success')
                                <div class="reset-success-col">
                                    <svg width="77" height="77" viewBox="0 0 77 77" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M38.5 0.5C48.5782 0.5 58.2437 4.50356 65.3701 11.6299C72.4964 18.7563 76.5 28.4218 76.5 38.5C76.5 48.5782 72.4964 58.2437 65.3701 65.3701C58.2437 72.4964 48.5782 76.5 38.5 76.5C28.4218 76.5 18.7563 72.4964 11.6299 65.3701C4.50356 58.2437 0.5 48.5782 0.5 38.5C0.5 28.4218 4.50356 18.7563 11.6299 11.6299C18.7563 4.50356 28.4218 0.5 38.5 0.5ZM54.4505 27.3185C54.0572 26.927 53.5393 26.6856 52.9866 26.6361C52.4339 26.5866 51.8813 26.7323 51.4248 27.0478L51.0923 27.3185L33.75 44.6655L25.9315 36.8423L25.599 36.5668C25.1415 36.2516 24.588 36.1068 24.0348 36.1575C23.4815 36.2082 22.9636 36.4513 22.571 36.8444C22.1785 37.2375 21.9362 37.7558 21.8862 38.3091C21.8363 38.8624 21.9819 39.4157 22.2978 39.8728L22.5685 40.2053L32.0685 49.7053L32.401 49.976C32.7976 50.2497 33.2681 50.3963 33.75 50.3963C34.2319 50.3963 34.7024 50.2497 35.099 49.976L35.4315 49.7005L54.4505 30.6815L54.726 30.349C55.0421 29.8915 55.1877 29.3376 55.1373 28.7838C55.087 28.23 54.8439 27.7115 54.4505 27.3185Z"
                                            fill="#5ABF35" />
                                    </svg>

                                    <div>
                                        <h4>@lang('index.password_has_been_change')</h4>
                                        <p>@lang('index.password_success_subtitle')</p>
                                        @php
                                            $route = route('customer.login');
                                            if (session('login_route') == 'Admin') {
                                                $route = route('admin.login');
                                            }

                                            if (session('login_route') == 'Customer') {
                                                $route = route('customer.login');
                                            }

                                            if (session('login_route') == 'Agent') {
                                                $route = route('agent.login');
                                            }
                                        @endphp
                                        <a href="{{ $route }}"
                                            class="btn btn-primary w-100">@lang('index.go_back_to_login')</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
