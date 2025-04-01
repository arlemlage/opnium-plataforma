@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <div class="alert-wrapper">
        @if(appMode() == "demo")
        <div class="alert alert-warning alert-dismissible fade show">
            <div class="alert-body">
                <p><iconify-icon icon="bi:exclamation-triangle-fill" width="22"></iconify-icon>{{ __('index.demo_restriction_msg') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        {{ alertMessage() }}
    </div>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <div class="row">
                    <div class="col-md-12">
                        <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                            {{ __('index.social_login_setting') }}
                        </h3>
                    </div>
                    <div class="col-md-12 justify-content-start">
                        <small class="text-bold">@lang('index.check_documentation_setting')</small>
                    </div>
                </div>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.social_login_setting')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
           <form action="{{ route('update-social-login-setting') }}" method="POST" id="common-form" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
               <!-- Google Login -->
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-flex gap-2">
                                <input name="google_login" value="Active" type="checkbox" class="form-check-input"
                                   {{ socialInfo()['google_login'] == "Active" ? "checked" : '' }} id="google_login">
                            <label for="google_login"> @lang('index.g_login')</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.google_client_id')</label>
                            <input type="text" name="google_client_id" id="google_client_id"
                                   class="form-control" value="{{ appMode() == "demo" ? demoSocial()['google_client_id'] : socialInfo()['google_client_id'] }}" placeholder="@lang('index.google_client_id')">
                                    @if ($errors->has('google_client_id'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('google_client_id') }}
                                    </span>
                                    @endif
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.google_client_secret')</label>
                            <input type="text" name="google_client_secret" id="google_client_secret"
                                   class="form-control" value="{{ appMode() == "demo" ? demoSocial()['google_client_secret'] : socialInfo()['google_client_secret'] }}" placeholder="@lang('index.google_client_secret')">
                                    @if ($errors->has('google_client_secret'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('google_client_secret') }}
                                    </span>
                                    @endif
                        </div>
                    </div>
                </div>


               <!-- Github Login -->
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-flex gap-2">
                            <input name="github_login" value="Active" type="checkbox" class="form-check-input"
                                   {{ socialInfo()['github_login'] == "Active" ? "checked" : '' }} id="github_login">
                            <label for="github_login"> @lang('index.github_login')</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.github_client_id')</label>
                            <input type="text" name="github_client_id" id="github_client_id"
                                   class="form-control" value="{{ appMode() == "demo" ? demoSocial()['github_client_id'] : socialInfo()['github_client_id'] }}" placeholder="@lang('index.github_client_id')">
                                    @if ($errors->has('github_client_id'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('github_client_id') }}
                                    </span>
                                    @endif
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.github_client_secret')</label>
                            <input type="text" name="github_client_secret" id="github_client_secret"
                                   class="form-control" value="{{ appMode() == "demo" ? demoSocial()['github_client_secret'] : socialInfo()['github_client_secret'] }}" placeholder="@lang('index.github_client_secret')">
                                    @if ($errors->has('github_client_secret'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('github_client_secret') }}
                                    </span>
                                    @endif
                        </div>
                    </div>
                </div>


               <!-- Envato Login -->
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-flex gap-2">
                            <input name="envato_login" value="Active" type="checkbox" class="form-check-input"
                                   {{ socialInfo()['envato_login'] == "Active" ? "checked" : '' }} id="envato_login">
                            <label for="envato_login"> @lang('index.envato_login')</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.envato_client_id')</label>
                            <input type="text" name="envato_client_id" id="envato_client_id"
                                   class="form-control" value="{{ appMode() == "demo" ? demoSocial()['envato_client_id'] : socialInfo()['envato_client_id'] }}" placeholder="@lang('index.envato_client_id')">
                                    @if ($errors->has('envato_client_id'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('envato_client_id') }}
                                    </span>
                                    @endif
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.envato_client_secret')</label>
                            <input type="text" name="envato_client_secret" id="envato_client_secret"
                                   class="form-control" value="{{ appMode() == "demo" ? demoSocial()['envato_client_secret'] : socialInfo()['envato_client_secret'] }}" placeholder="@lang('index.envato_client_secret')">
                                    @if ($errors->has('envato_client_secret'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('envato_client_secret') }}
                                    </span>
                                    @endif
                        </div>
                    </div>
                </div>


                  


                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100" id="submit-btn">
                                        {!! commonSpinner() !!}@lang ('index.submit')
                                    </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('dashboard') }}">
                            @lang('index.back')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    

</section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/social_login.js?var=2.2') }}"></script>
@endpush

