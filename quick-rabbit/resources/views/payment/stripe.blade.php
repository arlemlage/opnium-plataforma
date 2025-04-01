<!DOCTYPE html>
<html>
<head>
    <title>@lang('index.stripe_payment')</title>
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/twitter-bootstrap.css?var=2.2') }}" />
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js?var=2.2') }}"></script>
</head>
<body>
    
<div class="container">    
    <br>
    <div class="row mt-5">
        <div class="col-md-6 col-md-offset-3 mt-5">
            <h2 class="text-center">@lang('index.pay') ${{ Session::get('payment_amount') }} @lang('index.for_paid_support')</h2>

            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                        <h3 class="panel-title" >@lang('index.payment_details')</h3>
                </div>
                <div class="panel-body">
    
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
    
                    <form 
                            role="form" 
                            action="{{ route('stripe.post') }}" 
                            method="post" 
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ stripeInfo()['stripe_key'] }}"
                            id="payment-form">
                        @csrf
                        <input type="hidden" name="amount" value="{{ Session::get('payment_amount') }}">
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>@lang('index.name_on_card')</label> <input
                                    class='form-control' size='4' type='text' placeholder="Name on Card">
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>@lang('index.card_number')</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text' placeholder="Card Number">
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>@lang('index.cvc')</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>@lang('index.expiration_month')</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>@lang('index.expiration_year')</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>@lang('index.please_correct_error')</div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary  btn-block" type="submit" >@lang('index.pay_now')</button>
                            </div>
                        </div>
                            
                    </form>
                </div>
            </div>        
        </div>
    </div>
        
</div>
    
</body>
    
<!-- we used stripe api file here-->
<script type="text/javascript" src="{{ asset('frequent_changing/js/stripe_library.js?var=2.2') }}"></script>
<script src="{{ asset('frequent_changing/js/stripe_payment.js?var=2.2') }}"></script>
</html>