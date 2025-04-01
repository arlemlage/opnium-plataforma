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
                <h2 class="mb-0">@lang('index.forum')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.forum')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    <div class="forum-question-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <h1 class="title" id="forumModalLabel">@lang('index.ask_a_question')</h1>
                    <form action="{{ route('post-forum') }}" method="POST" id="submit-question">
                        @csrf
                        <div class="ask-question-form top-search-form">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <input name="subject" id="subject" type="text" class="form-control"
                                        placeholder="@lang('index.subject')">
                                    @error('subject')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @if (appTheme() == 'multiple')
                                    <div class="col-12 col-md-6">
                                        <select id="heroSelect" name="product_id" class="hero-form-select product-id"
                                            aria-label="Default select example">
                                            <option value="">@lang('index.select_product_category')</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->title ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="col-12 col-md-6">
                                        <select id="heroSelect" name="department_id" class="hero-form-select product-id"
                                            aria-label="Default select example">
                                            <option value="">@lang('index.department')</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"
                                        placeholder="@lang('index.write_your_question')"></textarea>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <input type="hidden" id="isCaptchaEnable" value="{{ isCaptchaEnable() }}">
                                @if (isCaptchaEnable())
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
                                @endif
                                <div class="col-12">
                                    <button class="gt-btn send_message_btn comment-submit-button" type="submit">
                                        @lang('index.ask_question')
                                        <span class="icon">
                                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.545 1.40324L10.4939 12.695C10.4649 12.9031 10.3694 13.0963 10.2218 13.2457C10.0741 13.3952 9.88214 13.493 9.67442 13.5245C9.4667 13.5561 9.25435 13.5198 9.06896 13.4209C8.88357 13.322 8.73505 13.166 8.64551 12.9759L6.39267 8.24091C6.38365 8.22375 6.37131 8.20854 6.35638 8.19618C6.34145 8.18381 6.32421 8.17453 6.30567 8.16886L1.37227 6.92424C1.17401 6.87371 0.995994 6.76365 0.862173 6.60889C0.728352 6.45413 0.645151 6.26209 0.623768 6.05861L0.620648 6.03291C0.596232 5.82634 0.637613 5.61733 0.738897 5.43565C0.840183 5.25396 0.996208 5.10887 1.18476 5.02102L11.1587 0.297653C11.3186 0.22318 11.4957 0.193633 11.671 0.212179C11.8464 0.230725 12.0133 0.296667 12.1541 0.402927C12.3063 0.516355 12.4237 0.670247 12.4928 0.847091C12.5619 1.02393 12.58 1.21663 12.545 1.40324Z"
                                                    fill="#5065E2" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/jquery-captcha/jquery-captcha.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/ask-question.js') }}"></script>
@endpush
