@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="alert-wrapper">
            {{ alertMessage() }}
        </section>

        <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between">
                        <div class="col-6 p-0">
                            <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}"
                                class="top-left-header  mt-2"> {{ $title ?? __('index.holiday_list') }} </h2>
                            <input type="hidden" class="datatable_name" data-title="Reason" data-id_name="datatable">
                        </div>
                        @include('layouts.breadcrumbs', ['firstSection' => __('index.vacation'), 'secondSection' => $title ?? __('index.holiday_list')])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn_list m-right d-flex">
                        <a class="btn bg-blue-btn m-right" href="{{ route('holiday-setting.create') }}">
                            <i data-feather="plus"></i> @lang('index.add_new')
                        </a>
                    </div>
                </div>
            </div>
        </section>


        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1 ir_txt_center">@lang('index.sn')</th>
                            <th class="ir_w_12">@lang('index.day')</th>
                            <th class="ir_w_12">@lang('index.start_time')</th>
                            <th class="ir_w_12">@lang('index.end_time')</th>
                            <th class="ir_w_12">@lang('index.auto_response')</th>
                            <th class="ir_w_12">@lang('index.mail_subject')</th>
                            <th class="ir_w_7">@lang('index.created_at')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($holidays as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>{{ $value->day ?? "N/A" }}</td>
                                <td>{{ $value->start_time ?? "N/A" }}</td>
                                <td>{{ $value->end_time ?? "N/A" }}</td>
                                <td>{{ $value->auto_response == 'on' ? 'Yes' : 'No' }}</td>
                                <td>{!! $value->mail_subject ?? "N/A" !!}</td>
                                <td>{{ orgDateFormat($value->created_at) }}</td>
                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        @if(routePermission('holiday-setting.edit'))
                                            <a href="{{ route('holiday-setting.edit',encrypt_decrypt($value->id,"encrypt")) }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('holiday-setting.destroy'))
                                            <form action="{{ route('holiday-setting.destroy', encrypt_decrypt($value->id,'encrypt')) }}"
                                                  class="edit alertDelete{{$value->id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a class="deleteRow delete" data-form_class="alertDelete{{$value ->id}}"
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
