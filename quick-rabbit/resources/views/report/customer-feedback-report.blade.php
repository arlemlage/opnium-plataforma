@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <input type="hidden" class="is_pagination" value="false">
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.customer_feedback_report')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.report'), 'secondSection' => __('index.customer_feedback_report')])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- Search -->
            <form action="{{ url('customer-feedback-report') }}" method="GET">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <select name="agent" class="form-control select2" id="agent">
                                <option value="">@lang('index.select_agent')</option>
                                @foreach($all_agents as $agent)
                                    <option value="{{ encrypt_decrypt($agent->id,'encrypt') }}" {{ isset($agent_id) && encrypt_decrypt($agent_id,'decrypt') == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            {!! Form::text('start_date', ($start_date ?? null), ['class' => 'form-control customDatepicker','placeholder'=>__('index.start_date'),'autocomplete'=>"off"]) !!}
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            {!! Form::text('end_date', ($end_date ?? null), ['class' => 'form-control customDatepicker','placeholder'=>__('index.end_date'),'autocomplete'=>"off"]) !!}
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <select name="order_by" class="form-control select2" id="order_by">
                                <option value="">@lang('index.order_by')</option>
                                <option {{ isset($order_by) && ($order_by) == 'ASC' ? 'selected' : '' }} value="ASC">@lang('index.order_asc')</option>
                                <option {{ isset($order_by) && ($order_by) == 'DESC' ? 'selected' : '' }} value="DESC">@lang('index.order_desc')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <button type="submit" class="btn bg-blue-btn w-100" id="go">@lang('index.search')</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <!-- End Search -->
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="ir_w_6">@lang('index.ticket_no')</th>
                            <th class="ir_w_7">@lang('index.title')</th>
                            <th class="ir_w_7">@lang('index.customer_name')</th>
                            <th class="ir_w_5">@lang('index.rating')</th>
                            <th class="ir_w_7">@lang('index.customer_comment')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj);?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $count-- }}</td>
                                <td>
                                    {{ $value->ticket_no ?? "" }}
                                </td>
                                <td title="{{  $value->title ?? "" }}">
                                    {!! Str::limit($value->title ?? "", 50) !!}
                                </td>
                                <td>{{ $value->getCreatedBy->full_name ?? "" }}</td>
                                <td>
                                    {{ $value->rating ?? "" }}
                                </td>
                                <td class="text-left">
                                    {{ $value->review ?? "" }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
