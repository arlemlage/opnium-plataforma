@extends('layouts.app')
@section('title','Edit Profile')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/ticket_index.css?var=2.2') }}">
@endpush

@section('content')
    <input type="hidden" id="key_hidden" value="{{request()->get('key')}}">
    <input type="hidden" id="email_hidden" value="{{request()->get('email')}}">
    <input type="hidden" id="customer_id_hidden" value="{{request()->get('customer_id')}}">
    <input type="hidden" id="agent_id_hidden" value="{{request()->get('agent_id')}}">
    <input type="hidden" id="purchase_code_hidden" value="{{request()->get('purchase_code')}}">
    <input type="hidden" id="ajax_datatable_url" value="{{url('getTickets')}}">
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.ticket_list') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.ticket'), 'secondSection' => __('index.ticket_list')])
            </div>
        </section>
        <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
        <div class="box-wrapper">
            <!-- Search -->
            <form action="{{ url('ticket') }}" method="GET">
                <div class="row" id="custom-button-group">

                    <?php
                        //<!-- active button checking variable -->
                        $is_active = isset($_GET['key'] && $_GET['key']?$_GET['key']:'');
                    ?>
                    <div class="col-xl-6 col-12 mt-2">
                        <div  class="d-flex p-t-btn" id="ticket_index_search_btn">
                            <button type="button" class="btn bg-blue-btn cus_css me-2">
                                <span class="badge_c">{{ $all_t }}</span>
                                <a href="{{ url('ticket?key=all') }}">@lang('index.all')</a>
                            </button>
                            <button type="button" class="btn bg-blue-btn cus_css me-2">
                                <span class="badge_c">{{ $all_t_open }}</span>
                                <a href="{{ url('ticket?key=open') }}">@lang('index.open')</a>
                            </button>
                            <button type="button" class="btn bg-blue-btn cus_css me-2">
                                <span class="badge_c">{{ $all_t_archived }}</span>
                                <a href="{{ url('ticket?key=archived') }}">@lang('index.archived')</a>
                            </button>
                            <button type="button" class="btn bg-blue-btn cus_css me-2">
                                <span class="badge_c">{{ $all_t_need_action }}</span>
                                <a href="{{ url('ticket?key=n_action') }}">@lang('index.need_action')</a>
                            </button>
                            <button type="button" class="btn bg-blue-btn cus_css me-2 open_p_code_modal">@lang('index.purchase_code')</button>
                            <button type="button" class="btn bg-blue-btn cus_css me-2">
                                <span class="badge_c">{{ $all_t_flag }}</span>
                                <a href="{{ url('ticket?key=flagged') }}">@lang('index.flagged')</a>
                            </button>
                            <button type="button" class="btn bg-blue-btn cus_css me-2">
                                <span class="badge_c">{{ $all_t_closed }}</span>
                                <a href="{{ url('ticket?key=closed') }}">@lang('index.closed')</a>
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12 mt-2">
                        <div class="row mt-xl-0 ms-2">
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="@lang('index.email')">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <select name="customer_id" class="form-control select2">
                                        <option value="">@lang('index.select_customer')</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->full_name }}{{ $customer->email != null ? '('.$customer->email.')' : null }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <select name="agent_id" class="form-control select2">
                                        <option value="">@lang('index.select_agent')</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-10 mb-2 search_inp_focus" >
                        <div class="form-group" id="search_wrap">
                            <input type="text" name="full_text_search" onfocus="select();" value="" id="full_text_search" class="form-control full_text_search" placeholder="@lang('index.full_text_search')" autocomplete="off">
                            <ul class="results d-none"></ul>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn bg-blue-btn w-100 " id="go">@lang('index.search')</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable_ticket" class="table">
                        <thead>
                            <tr>
                                <th class="w-15">@lang('index.ticket_id')</th>
                                <th class="w-25">@lang('index.title')</th>
                                <th class="w-10">@lang('index.product_category')</th>
                                <th class="w-10">@lang('index.customer')</th>
                                <th class="text-nowrap">@lang('index.created_at')</th>
                                <th class="w-10">@lang('index.updated_at')</th>
                                <th class="w-10">@lang('index.flag')</th>
                                <th>@lang('index.status')</th>
                                <th class="w-15">@lang('index.action')</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    <!-- Purchase code Modal-->
    <div class="modal fade" id="p_code_modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.p_code_search')</h4>
                    <button type="button" class="btn-close close_p_code_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <form action="{{ url('ticket') }}" method="GET" class='needs-validation' novalidate>
                            <div class="table-box">
                                <div>
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <div class="form-group">
                                                <label>@lang('index.purchase_code') {!! starSign() !!}</label>
                                                <input type="text" name="purchase_code" class="form-control has-validation ticket_note" value=""
                                                placeholder="@lang('index.enter_purchase_code')" required>
                                                <div class="invalid-feedback">
                                                    @lang('index.p_code_search_field_required')
                                                </div>
                                            </div>
                                            <span class="error_alert text-danger p_code_error" role="alert"></span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-3 mb-2">
                                            <button type="submit" class="btn btn-md bg-blue-btn">@lang('index.search')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<!-- DataTables -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/dataTable/jquery.dataTables.min.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/dataTable/dataTables.bootstrap5.min.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/dataTable/dataTables.buttons.min.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/dataTable/buttons.html5.min.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/dataTable/buttons.print.min.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/dataTable/pdfmake.min.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/dataTable/vfs_fonts.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/newDesign/js/forTable.js?var=2.2')}}"></script>
<script src="{{ asset('frequent_changing/js/ticket_index.js?var=2.2') }}"></script>
@endpush
