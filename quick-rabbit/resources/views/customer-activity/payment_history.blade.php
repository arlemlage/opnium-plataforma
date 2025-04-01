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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header  mt-2">@lang('index.payment_history')</h2>
                        <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.payment_history')])
            </div>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1"></th>
                                <th class="ir_w_12">@lang('index.ticket_no')</th>
                                <th class="w-30">@lang('index.title')</th>
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
                                        <a target="_blank" class="ds_anchor" href="{{ route('ticket.show',encrypt_decrypt($data->ticket_id,'encrypt')) }}">
                                            {{ $data->ticket->ticket_no ?? "" }}
                                        </a>
                                    </td>
                                    <td>
                                        <a target="_blank" class="ds_anchor" href="{{ route('ticket.show',encrypt_decrypt($data->ticket_id,'encrypt')) }}">
                                            <span class="text-short">{{ $data->ticket->title ?? "" }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $data->payment_amount ?? 0 }}</td>
                                    <td>{{ ucfirst($data->payment_method) ?? 0 }}</td>
                                    <td>{{ $data->transaction_id ?? "N/A" }}</td>
                                    <td>
                                        <span class="text-{{ $data->payment_status == 'Paid' ? 'success' : 'danger' }}">{{ $data->payment_status ?? 'N/A' }}</span>
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
