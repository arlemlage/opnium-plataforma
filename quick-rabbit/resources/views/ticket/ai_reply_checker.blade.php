@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/addEditTicket.css?var=2.2') }}">
@endpush
@section('content')
<section class="main-content-wrapper">
    <input type="hidden" id="ticket_id" value="{{$ticket_id}}">
    <input type="hidden" id="p_id" value="{{$obj->product_category_id??""}}">
    <h2 class="display-none">&nbsp;</h2>
    <div class="alert-wrapper">
        {{ alertMessage() }}
    </div>
    <div class="alert-wrapper d-none ajax_data_alert_show_hide">
        <div class="alert alert-success alert-dismissible fade show">
            <div class="alert-body">
                <p><iconify-icon icon="{{ Session::get('sign') ?? 'material-symbols:check' }}" width="22"></iconify-icon><span class="ajax_data_alert"></span></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <div class="row">
                <div class="col-md-12 col-xs-12 text-center min-vh-100">
                         <h2 class="card-title card_title_h2">{{ __('index.ai_check_message') }}</h2>
                        <div class="lds-facebook loader-img">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <h2 class="card-title display-none-not-required ai_reply_success"></h2>
                </div>
             </div>
        </div>
    </div>
</section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/ai_reply_checker.js?var=2.2') }}"></script>
@endpush
