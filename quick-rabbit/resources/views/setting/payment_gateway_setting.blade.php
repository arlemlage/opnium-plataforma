@extends('layouts.app')
@section('content')
    <section class="main-content-wrapper">
        <h2 class="d-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 class="top-left-header mb-0 mt-2">
                        {{ __('index.payment_gateway_setting') }}
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.payment_gateway_setting')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                {!! Form::model(isset($data) && $data?$data:'', ['method' => isset($data) && $data ? 'PUT' : 'POST','id' => 'common-form','route' => 'update-payment-gateway-setting']) !!}
                @csrf
                <div>
                    <!-- Paypal Setting -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                    <input name="paypal_active" value="Active" class="form-check-input" type="checkbox"
                                       {{ $data->paypal_active == "Active" ? "checked" : '' }} id="paypal_active">
                                    <label for="paypal_active"> @lang('index.Paypal')</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div>
                                    <label for="paypal_active"> @lang('index.type') : &nbsp;</label>
                                <input name="paypal_active_mode" value="sandbox" class="form-check-input" type="radio"
                                       {{ $data->paypal_active_mode == "sandbox" ? "checked" : '' }} id="paypal_sandbox">
                                <label for="paypal_sandbox">@lang('index.Sandbox')</label>
                                &nbsp;
                                <input name="paypal_active_mode" value="live" class="form-check-input" type="radio"
                                       {{ $data->paypal_active_mode == "live" ? "checked" : '' }} id="paypal_live">
                                <label for="paypal_live">@lang('index.Live')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.client_id')
                                </label>
                                {!! Form::text('paypal_client_id', appMode() == "demo" ? demoPaypal()['paypal_client_id'] : null, ['class' => 'form-control','id'=>"paypal_client_id",'placeholder'=>"Client Id"]) !!}
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.client_secret')
                                </label>
                                {!! Form::text('paypal_client_secret', appMode() == "demo" ? demoPaypal()['paypal_client_secret'] : null, ['class' => 'form-control','id'=>"paypal_client_secret",'placeholder'=>"Client Secret"]) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Stripe Setting -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                <input name="stripe_active" value="Active" class="form-check-input" type="checkbox"
                                       {{ $data->stripe_active == 'Active' ? "checked" : '' }} id="stripe_active">
                                <label for="stripe_active"> @lang('index.Stripe')</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div>
                                    <label for="stripe_active"> @lang('index.type') : &nbsp;</label>
                                <input name="stripe_active_mode" value="sandbox" class="form-check-input" type="radio"
                                       {{ $data->stripe_active_mode == "sandbox" ? "checked" : '' }} id="stripe_sandbox">
                                <label for="stripe_sandbox">@lang('index.Sandbox')</label>
                                &nbsp;
                                <input name="stripe_active_mode" value="live" class="form-check-input" type="radio"
                                       {{ $data->stripe_active_mode == "live" ? "checked" : '' }} id="stripe_live">
                                <label for="stripe_live">@lang('index.Live')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.api_key')
                                </label>
                                {!! Form::text('stripe_key', appMode() == "demo" ? demoStripe()['stripe_key'] : null, ['class' => 'form-control','id'=>"stripe_key",'placeholder'=>"API Key"]) !!}
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.api_secret')
                                </label>
                                {!! Form::text('stripe_secret', appMode() == "demo" ? demoStripe()['stripe_secret'] : null, ['class' => 'form-control','id'=>"stripe_secret",'placeholder'=>"Secret"]) !!}
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
                            <a class="btn bg-blue-btn w-100 custom_header_btn" href="{{ route('dashboard') }}">
                                @lang('index.back')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop

