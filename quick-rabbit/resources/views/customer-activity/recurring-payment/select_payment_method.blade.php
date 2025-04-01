@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
	 @if(\Session::has('error'))
        <div class="alert alert-danger">{{ \Session::get('error') }}</div>
        {{ \Session::forget('error') }}
     @endif
     @if(\Session::has('success'))
        <div class="alert alert-success">{{ \Session::get('success') }}</div>
        {{ \Session::forget('success') }}
    @endif
    <section class="content-header">
        <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
           @lang('index.select_payment')
        </h3>
    </section>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    @lang('index.select_payment')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.ticket'), 'secondSection' => isset($obj)? __('index.edit') : __('index.create')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('index.date')</th>
                            <th>@lang('index.amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $payment->recurring_payment_date ?? '' }}</td>

                            <td>
                                ${{ $payment->payment_amount ?? 0 }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="table-box">
            <form action="{{ route('process-payment',encrypt_decrypt($payment->id,'encrypt')) }}" method="POST">
                @csrf
                <input type="hidden" name="payment_from" value="recurring">
                <input type="hidden" name="payment_amount" value="{{ $payment->payment_amount ?? 0 }}">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <input type="radio" name="payment_method"  value="paypal" id="paypal">
                            <label for="paypal">
                                <img src="{{ asset('assets/images/paypal.jpg') }}" alt="" class="img-responsive ds_payment_logo">
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="payment_method"  value="stripe" id="stripe">
                            <label for="stripe">
                                <img src="{{ asset('assets/images/stripe.png') }}" alt="" class="img-responsive ds_payment_logo">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-2 mb-2">
                        <button type="submit" name="submit" value="submit"
                                class="btn bg-blue-btn w-100">@lang('index.continue')
                        </button>
                    </div>
                </div>
           </form>
        </div>
    </div>
</section>
@endsection

@push('js')
@endpush

