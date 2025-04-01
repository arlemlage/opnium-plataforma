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
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    @lang('index.ticket_setting')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.ticket_setting')])
        </div>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            {!! Form::model(isset($obj) && $obj?$obj:'', ['method' => 'POST','id' => 'common-form', 'enctype'=>'multipart/form-data', 'url' => ['update-ticket-setting'], 'class'=>'needs-validation', 'novalidate']) !!}
            @csrf
            @method('PUT')
                <div class="row">
                    

                    <p class="pt-0">
                        <span class="allow_s_ticket">{{ __('index.closed_ticket_rating') }}</span>
                        <label class="switch_ticketly pl-5">
                            <input type="checkbox" name="closed_ticket_rating" class="closed_ticket_rating" {{ (isset($obj) && $obj->closed_ticket_rating == 'on')? 'checked':''}}>
                            <span class="slider round"></span>
                        </label>
                    </p>

                    <hr class="hr ml-4">

                    <p class="pt-0">
                        <span class="allow_s_ticket">{{ __('index.auto_email_reply') }}</span>
                        <label class="switch_ticketly pl-5">
                            <input type="checkbox" name="auto_email_reply" class="auto_email_reply" {{ (isset($obj) && $obj->auto_email_reply == 'on')? 'checked':''}}>
                            <span class="slider round"></span>
                        </label>
                    </p>

                    <hr class="hr ml-4">

                    <div class="my-2">
                        <div class="col-md-3 mb-2"><span>{{ __('index.default_sign') }}</span></div>
                        <div class="col-md-12">
                            {!! Form::textarea('default_sign', (!empty($obj) && $obj->default_sign !=null)? $obj->default_sign:'', ['class' => 'form-control', 'rows'=>'3', 'cols'=>'30','placeholder' => 'Regards,&#13;&#10;'.siteSetting()->title ?? 'Your company name'.' support']) !!}
                            @if ($errors->has('default_sign'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('default_sign') }}
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
                </div>
            {!! Form::close() !!}
        </div>

    </div>
</section>
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/ticket-setting.js?var=2.2') }}"></script>
@endpush
