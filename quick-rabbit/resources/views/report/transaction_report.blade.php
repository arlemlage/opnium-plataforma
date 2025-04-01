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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header  mt-2">@lang('index.transaction_report')</h2>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.report'), 'secondSection' => __('index.transaction_report')])
            </div>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <form action="{{ route('transaction-report') }}" method="GET">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="ticket_id">@lang('index.ticket') (@lang('index.paid_status_ticket_only'))</label>
                                <select name="ticket_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($tickets as $ticket)
                                        <option value="{{ encrypt_decrypt($ticket->id,'encrypt') }}" @if((isset($ticket_id)) AND (encrypt_decrypt($ticket_id,'decrypt') == $ticket->id)) {{ "selected" }} @endif>
                                            {{ $ticket->title ?? "" }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="customer_id">@lang('index.customer_phone')</label>
                                <select name="customer_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ encrypt_decrypt($customer->id,'encrypt') }}" @if((isset($customer_id)) AND (encrypt_decrypt($customer_id,'decrypt') == $customer->id)) {{ "selected" }} @endif>
                                            {{ $customer->full_name ?? "" }}{{ $customer->email != null ? '('.$customer->email.')' : null }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="from_date">@lang('index.from_date')</label>
                                <input type="text" name="from_date" class="form-control customDatepicker" autocomplete="off" value="{{ $from_date ?? "" }}" placeholder="@lang('index.from_date')" >
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="to_date">@lang('index.to_date')</label>
                                <input type="text" name="to_date" class="form-control customDatepicker" autocomplete="off" value="{{ $to_date ?? "" }}" placeholder="@lang('index.to_date')" >
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="transaction_id">@lang('index.transaction_id')</label>
                                <input type="text" name="transaction_id" class="form-control" autocomplete="off" value="{{ $transaction_id ?? '' }}" placeholder="@lang('index.transaction_id')">
                            </div>
                        </div>


                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="gateway">@lang('index.payment_method')</label>
                                <select name="gateway" class="form-control select2" id="gateway">
                                    <option value="">@lang('index.select')</option>
                                    <option value="paypal" @if((isset($gateway)) AND ($gateway === "paypal")) {{ "selected" }} @endif>@lang('index.Paypal')</option>
                                    <option value="stripe" @if((isset($gateway)) AND ($gateway === "stripe")) {{ "selected" }} @endif>@lang('index.Stripe')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <button type="submit"
                                    class="btn bg-blue-btn w-100 top" id="go">@lang('index.search')</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1">@lang('index.sn')</th>
                                <th class="ir_w_12">@lang('index.ticket_no')</th>
                                <th class="ir_w_12">@lang('index.transaction_date')</th>
                                <th class="ir_w_7">@lang('index.title')</th>
                                <th class="ir_w_12">@lang('index.customer')</th>
                                <th class="ir_w_12">@lang('index.amount')</th>
                                <th class="ir_w_12">@lang('index.payment_method')</th>
                                <th class="ir_w_12">@lang('index.transaction_id')</th>
                                 <th class="ir_w_12">@lang('index.payment_status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $data)
                                <tr>
                                    <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        {{ $data->ticket->ticket_no ?? "" }}
                                    </td>
                                    <td> {{ isset($data->transaction_time)? date(siteSetting()->date_format, strtotime($data->transaction_time)) :"" }}</td>
                                    <td title="{{ $data->ticket->title ?? "" }}">
                                        {{ Str::limit($data->ticket->title ?? "", 50) }}
                                    </td>
                                    <td>
                                        {{ $data->customer->full_name ?? "" }}
                                        <br>
                                        {{ isset($data->customer->mobile) ? '('.$data->customer->mobile.')' : "" }}
                                    </td>
                                    <td>{{ $data->payment_amount ?? 0 }}</td>
                                    <td>{{ ucfirst($data->payment_method) ?? 0 }}</td>
                                    <td>{{ $data->transaction_id ?? "N/A" }}</td>
                                    <td>{{ $data->payment_status ?? "N/A" }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script src="{{ asset('frequent_changing/js/print_invoice.js?var=2.2') }}"></script>
    @include('layouts.data_table_script')
@endpush
