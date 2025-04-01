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
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    @lang('index.integrations')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.integrations')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            {!! Form::model(isset($data) && $data?$data:'', ['method' => 'POST','id' => 'common-form', 'enctype'=>'multipart/form-data', 'url' => ['update-integration-setting'], 'class'=>'needs-validation', 'novalidate']) !!}
            @csrf
            @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="mb-0">@lang('index.envato_purchase_verification')</p>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="switch_ticketly pull-right">
                                            <input type="checkbox" name="envato_set_up" class="form-check-input envato_set_up" {{ (isset($data) && $data->envato_set_up=='on')? 'checked':''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-2 col-md-7 mt-2 envato_set_up_input_field {{ (isset($data) && $data->envato_set_up=='on')? '':'d-none'}}">
                        <div class="form-group">
                            <label>@lang('index.envato_api_key') {!! starSign() !!}</label>
                            {!! Form::text('envato_api_key', appMode() == "demo" ? 'XXXXXXXXX' : null, ['class' => 'form-control has-validation envato_api_key ','placeholder'=>__('index.envato_api_key'), ((isset($data) && $data->envato_set_up=='on')? 'required':'')]) !!}
                            <div class="invalid-feedback">
                                @lang('index.envato_api_key_required')
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="mb-0">{{ __('index.allow_submit_support')  }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="switch_ticketly pull-right">
                                            <input type="checkbox" name="ticket_submit_on_support_period_expired" class="form-check-input" {{ (isset($data) && $data->ticket_submit_on_support_period_expired=='Yes')? 'checked':''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100" id="submit-btn">
                                        {!! commonSpinner() !!}@lang ('index.submit')
                                    </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>

    </div>
</section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/integration.js?var=2.2') }}"></script>
@endpush
