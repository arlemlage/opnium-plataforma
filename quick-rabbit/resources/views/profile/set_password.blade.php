@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <div class="alert-wrapper">
        {{ alertMessage() }}
    </div>
    <section class="content-header">
        <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
            @lang('index.set_password')
        </h3>
    </section>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    @lang('index.set_password')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.profile'), 'secondSection' => __('index.set_password')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- Catch different route for user role -->
            <!-- form start -->
           <form action="{{ $route }}" method="POST">
           	@csrf
           	@method('PUT')
            <div>
                <div class="row">

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.password') {!! starSign() !!}</label>
                            <input tabindex="2" type="password" name="password" class="form-control" placeholder="@lang('index.password')" value="">
                        </div>
                        @if ($errors->has('password'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.confirm_password') {!! starSign() !!}</label>
                            <input tabindex="2" type="password" name="confirm_password" class="form-control" placeholder="@lang('index.confirm_password')" value="">
                        </div>
                        @if ($errors->has('confirm_password'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('confirm_password') }}
                            </span>
                        @endif
                    </div>


                <!-- /.box-body -->

                <div class="row mt-2">
                    <div class="col-sm-6 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100">@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('user-home') }}">
                                @lang('index.back')
                            </a>
                        </div>
                </div>
            </div>
                </div>
           </form>
        </div>
    </div>
</section>
@endsection

@push('js')
@endpush
