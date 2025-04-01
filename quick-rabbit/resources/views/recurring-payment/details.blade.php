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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header  mt-2">@lang('index.recurring_payment')</h2>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.recurring_payment'), 'secondSection' => __('index.recurring_payment') ])
            </div>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1">@lang('index.sn')</th>
                                <th class="ir_w_12">@lang('index.date')</th>
                                <th class="ir_w_12">@lang('index.amount')</th>
                                <th class="ir_w_12">@lang('index.payment_status')</th>
                                <th class="ir_w_12">@lang('index.payment_method')</th>
                                <th class="ir_w_12">@lang('index.transaction_id')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $data)
                                <tr>
                                    <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->recurring_payment_date }}</td>
                                    <td>{{ $data->recurring_payment->amount ?? 0 }}</td>
                                    <td>{{ $data->payment_status }}</td>
                                    <td>{{ $data->payment_method ?? "N/A" }}</td>
                                    <td>{{ $data->transaction_id ?? "N/A" }}</td>
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
    @include('layouts.data_table_script')
@endpush
