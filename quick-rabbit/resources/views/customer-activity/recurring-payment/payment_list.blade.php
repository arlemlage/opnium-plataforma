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
                @include('layouts.breadcrumbs', ['firstSection' => __('index.recurring_payment')])
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
                                <th class="w-20">@lang('index.title')</th>
                                <th>@lang('index.product_category')</th>
                                <th class="ir_w_12">@lang('index.date')</th>
                                <th class="ir_w_12">@lang('index.amount')</th>
                                <th class="ir_w_12">@lang('index.payment_status')</th>
                                <th class="ir_w_1_txt_center">@lang('index.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $data)
                                <tr>
                                    <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <span class="text-short">{{ $data->recurring_payment->title ?? '' }}</span>
                                    </td>
                                    <td>
                                        {{ $data->recurring_payment->products ?? "N/A" }}
                                    </td>
                                    <td>{{ $data->recurring_payment_date }}</td>
                                    <td>{{ $data->recurring_payment->amount ?? 0 }}</td>
                                    <td>
                                        <span class="text-{{ $data->payment_status == 'Paid' ? 'success' : 'danger' }}">{{ $data->payment_status }}</span>
                                    </td>
                                    <td class="ir_txt_center">
                                        <div class="d-flex gap8">
                                            @if(today()->format('Y-m-d') >= $data->recurring_payment_date)
                                                <a href="{{ route('select-payment-method', encrypt_decrypt($data->id, 'encrypt'))}}"
                                                   class="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-original-title="@lang('index.pay_now')">
                                                    <iconify-icon icon="f7:creditcard-fill" width="22"></iconify-icon>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
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
