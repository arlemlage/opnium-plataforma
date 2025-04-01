@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('frequent_changing/css/feedback.css?var=2.2') }}">
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
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.send_your_feedback') }}</h3>
                <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.ticket'), 'secondSection' => __('index.send_your_feedback')])
        </div>
    </section>
    <div class="box-wrapper">
        <div class="row">
            <div class="col-md-12">
                <span class="fs-1 text-info"><iconify-icon icon="octicon:thumbsup-16" width="22"></iconify-icon></span>
                    <h3>@lang('index.thank_feedback')</h3>
                    <p>@lang('index.this_will_help_better')</p>
            </div>
        </div>
    </div>

</section>

@endsection


