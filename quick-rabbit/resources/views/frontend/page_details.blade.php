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
                <h2 class="mb-0">{{ $page->title ?? '' }}</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.pages')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>
    <div class="support_policy_wrapper">
        <div class="container support_policy">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="support_policy_content">
                        {!! $page->page_content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
