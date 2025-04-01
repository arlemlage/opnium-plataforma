@extends('layouts.app')
@push('css')
    <link rel='stylesheet' href="{{ asset('assets/calendar/main.css?var=2.2') }}" />
@endpush




@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
	<section class="alert-wrapper">
		{{ alertMessage() }}
	</section>
    <input type="hidden" class="datatable_name" data-title="Reason" data-id_name="datatable">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header  mt-2"> {{ __('index.task_calendar') }} </h2>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.task'), 'secondSection' => __('index.task_calendar')])
        </div>
    </section>
	<div class="box-wrapper">
        <div id="loading"></div>
        <div id="task-calendar"></div>
	</div>

    <div class="modal fade" id="task-details">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="task-details-modal-title"></h4>
                    <button type="button" class="close td_close_modal" data="task-details">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body  h-100-vh" id="task-details-modal-body">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger td_close_modal" data="task-details">@lang('index.close')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="task-edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="task-edit-modal-title"></h4>
                    <button type="button" class="btn bt-sm btn-close te_close_modal">&times;</button>
                </div>               
                <div class="modal-body" id="task-edit-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger te_close_modal">@lang('index.close')</button>
                    <button type="button" class="btn bg-blue-btn" id="task-update-button">@lang('index.update')</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
  <script src="{{ asset('frequent_changing/js/task_calendar.js?var=2.2') }}"></script>
  <!-- Full-Calendar -->
  <script src="{{ asset('assets/full-calendar/main.js?var=2.2') }}"></script>
  <script src="{{ asset('assets/full-calendar/locales-all.js?var=2.2') }}"></script>


@endpush
