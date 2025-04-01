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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}"
                        class="top-left-header  mt-2">@lang('index.recurring_payment')</h2>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.recurring_payment')])
            </div>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <form action="{{ route('recurring-payments.index') }}" method="GET">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="customer_id">@lang('index.customer_phone')</label>
                                <select name="customer_id" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ encrypt_decrypt($customer->id,'encrypt') }}" @if((isset($customer_id)) AND (encrypt_decrypt($customer_id,'decrypt') == $customer->id))
                                            {{ "selected" }}
                                                @endif>
                                            {{ $customer->full_name ?? "" }}{{ $customer->email != null ? '('.$customer->email.')' : null }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="from_date">@lang('index.start_date')</label>
                                <input type="text" name="start_date" class="form-control customDatepicker"
                                       autocomplete="off" value="{{ $start_date ?? "" }}"
                                       placeholder="@lang('index.start_date')">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="to_date">@lang('index.end_date')</label>
                                <input type="text" name="end_date" class="form-control customDatepicker"
                                       autocomplete="off" value="{{ $end_date ?? "" }}"
                                       placeholder="@lang('index.end_date')">
                            </div>
                        </div>


                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
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
                            <th class="w-20">@lang('index.title')</th>
                            <th class="w-20">@lang('index.product_category')</th>
                            <th class="ir_w_12">@lang('index.customer')</th>
                            <th class="ir_w_12">@lang('index.start_date')</th>
                            <th class="ir_w_12">@lang('index.end_date')</th>
                            <th class="ir_w_12">@lang('index.payment_period_in_days')</th>
                            <th class="ir_w_12">@lang('index.amount')</th>
                            <th class="ir_w_12">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $data)
                            <tr>
                                <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>
                                    <span class="text-short">{{ $data->title ?? '' }}</span>
                                </td>
                                <td>{{ $data->products ?? "" }}</td>
                                <td class="text-nowrap">
                                    {{ $data->customer->full_name ?? "" }}
                                    <br>
                                    {{ isset($data->customer->mobile) ? '('.$data->customer->mobile.')' : "" }}
                                </td>
                                <td>{{ $data->start_date ?? '' }}</td>
                                <td>{{ $data->end_date ?? '' }}</td>
                                <td>{{ $data->payment_period_in_days ?? '' }}</td>
                                <td>{{ $data->amount ?? 0 }}</td>
                                <td class="">
                                    <div class="d-flex gap8">
                                        @if(routePermission('recurring-payments.show'))
                                            <a href="{{ route('recurring-payments.show', encrypt_decrypt($data->id, 'encrypt'))}}"
                                               class="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.details')">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('recurring-payments.edit'))
                                            <a href="{{ route('recurring-payments.edit', encrypt_decrypt($data->id, 'encrypt'))}}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('recurring-payments.destroy'))
                                            <form action="{{ route('recurring-payments.destroy', encrypt_decrypt($data->id, 'encrypt'))}}"
                                                  class="edit alertDelete{{$data->id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a class="deleteRow delete" data-form_class="alertDelete{{$data ->id}}"
                                                   href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-original-title="@lang('index.delete')">
                                                    <i class="fa fa-trash"></i>
                                            </form>
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
