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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.support_history_report')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.report'), 'secondSection' =>  __('index.support_history_report')])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- Search -->
            <form action="{{ url('support-history-report') }}" method="GET">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <input type="text" name="purchase_code" class="form-control" value="{{ $purchase_code ?? '' }}" placeholder="@lang('index.purchase_code')">
                            
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <select name="customer" class="form-control select2" id="customer">
                                <option value="">@lang('index.select_customer')</option>
                                @foreach($all_customers as $customer)
                                    <option value="{{ encrypt_decrypt($customer->id,'encrypt') }}" {{ isset($customer_id) && encrypt_decrypt($customer_id,'decrypt') == $customer->id ? 'selected' : '' }}>{{ $customer->full_name }}{{ $customer->mobile != null ? '('.$customer->mobile.')' : null }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <select name="agent" class="form-control select2" id="agent">
                                <option value="">@lang('index.select_agent')</option>
                                @foreach($all_agents as $agent)
                                    <option value="{{ encrypt_decrypt($agent->id,'encrypt') }}" {{ isset($agent_id) && encrypt_decrypt($agent_id,'decrypt') == $agent->id ? 'selected' : '' }}>{{ $agent->full_name }}</option>
                                @endforeach
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
                            <th class="ir_w_7">@lang('index.envato_p_code')</th>
                            <th class="ir_w_7">@lang('index.ticket_no')</th>
                            <th class="ir_w_7">@lang('index.title')</th>
                            <th class="ir_w_7">@lang('index.customer_name')</th>
                            <th class="ir_w_7">@lang('index.opening_date')</th>
                            <th class="ir_w_7">@lang('index.closing_date')</th>
                            <th class="ir_w_7">@lang('index.status')</th>
                            <th class="ir_w_7">@lang('index.close_duration')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>{{ $value->envato_p_code ?? "N/A" }}</td>
                                <td>
                                    {{ $value->ticket_no ?? "" }}
                                </td>
                                <td title="{{ $value->title ?? "" }}">
                                    {!! Str::limit($value->title ?? "" , 50) !!}
                                </td>
                                <td>
                                    {{ $value->getCustomer->full_name ?? "" }}
                                </td>
                                <td>
                                    {{ isset($value->created_at)? date(siteSetting()->date_format, strtotime($value->created_at)) :"" }}
                                    
                                    {{ isset($value->created_at)? date('h:i:s a', strtotime($value->created_at)) :"" }}
                                </td>
                                <td>
                                    {{ isset($value->closing_date)? date(siteSetting()->date_format, strtotime($value->closing_date)) :"" }}
                                    
                                    {{ isset($value->closing_date)? date('h:i:s a', strtotime($value->closing_date)) :"" }}
                                </td>
                                <td>
                                    @if($value->status == 1)
                                        <span class="">@lang('index.open')</span>
                                    @elseif($value->status == 2)
                                        <span class="">@lang('index.close')</span>
                                    @elseif($value->status == 3)
                                        <span class="">@lang('index.reopen')</span>
                                    @endif
                                </td>
                                <td>
                                    {{ !empty($value->ticket_duration)? $value->ticket_duration.' Hours':"" }}
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
