@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.calendar') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.calendar')])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- Calendar -->
            <div id='calendar'></div>
            <!-- End Calendar -->
        </div>
        <input type="hidden" class="allVacations" value="{{ $allVacations }}">
    </section>
@endsection

@push('js')
    <script src="{{ asset('frequent_changing/js/calendar.js?var=2.2') }}"></script>
      <!-- Full-Calendar -->
      <script src="{{ asset('assets/full-calendar/main.js?var=2.2') }}"></script>
      <script src="{{ asset('assets/full-calendar/locales-all.js?var=2.2') }}"></script>
@endpush
