@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/customer_page.css?var=2.2') }}">
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
                        class="top-left-header  mt-2">{{ __('index.customer_list') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.customer'), 'secondSection' => __('index.customer_list')])
            </div>
        </section>
        <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="ir_w_12">@lang('index.full_name')</th>
                            <th class="ir_w_12">@lang('index.email')</th>
                            <th class="ir_w_12">@lang('index.mobile')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj); ?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $count-- }}</td>
                                <td>{{ $value->full_name ?? "" }}</td>
                                <td>{{ $value->email ?? "" }}</td>
                                <td>{{ $value->mobile ?? "" }}</td>
                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        @if(routePermission('customer.show'))
                                            <a href="{{ route('customer.show',encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.details')">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('customer.edit'))
                                            <a href="{{ route('customer.edit',encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('reset-customer-password'))
                                            <form action="{{ route('reset-customer-password', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                  class="edit alertDelete{{$value->id}}" method="post">
                                                @csrf
                                                <a class="edit deleteRow delete" data-message="@lang('index.reset_and_mail_send_message')" data-form_class="alertDelete{{$value ->id}}"
                                                   href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-original-title="@lang('index.reset_and_send_temp_password')">
                                                    <i class="fa fa-key"></i>
                                                </a>
                                            </form>
                                        @endif
                                    </div>
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
