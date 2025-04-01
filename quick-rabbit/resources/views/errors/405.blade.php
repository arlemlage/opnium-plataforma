@extends('frontend.app')
@section('content')
@section('menu')
    @include('errors.menu_others')
@endsection
@section('footer_menu')
    @include('errors.others_footer')
@endsection
<!-- Not Wrapper -->
<div class="not-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <img src="{{ asset('assets/frontend/img/core-img/405.png') }}" alt="">
                <div class="text-center">
                    <h2>@lang('index.not_allowed')</h2>
                    <div class="d-flex justify-content-center">
                        <a class="gt-btn w-lg-25" href="{{ URL::previous() }}">
                            @lang('index.go_to_back') <i class="bi bi-arrow-return-left ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


