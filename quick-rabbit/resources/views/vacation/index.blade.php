@extends('layouts.app')
@section('title','Vacations')
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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.vacation_list')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.vacation'), 'secondSection' => __('index.vacation_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="ir_w_12">@lang('index.title')</th>
                            <th class="ir_w_12">@lang('index.start_date')</th>
                            <th class="ir_w_12">@lang('index.end_date')</th>
                            <th class="ir_w_12">@lang('index.auto_response')</th>
                            <th class="ir_w_12">@lang('index.mail_subject')</th>
                            <th class="ir_w_7">@lang('index.created_by')</th>
                            <th class="ir_w_7">@lang('index.created_at')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj); ?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $count-- }}</td>
                                <td>
                                    <span class="text-short">{{ $value->title ?? "" }}</span>
                                </td>
                                <td>{{ orgDateFormat($value->start_date) ?? "N/A" }}</td>
                                <td>{{ orgDateFormat($value->end_date) ?? "N/A" }}</td>
                                <td>{{ $value->auto_response == 'on' ? 'Yes' : 'No' }}</td>
                                <td>{!! $value->mail_subject ?? "N/A" !!}</td>
                                <td>{{ getUserName($value->created_by) }}</td>
                                <td>{{ orgDateFormat($value->created_at) }}</td>
                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        @if(routePermission('vacations.edit'))
                                            <a href="{{ url('vacations/'.encrypt_decrypt($value->id, 'encrypt').'/edit') }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('vacations.destroy'))
                                            <form action="{{ route('vacations.destroy', encrypt_decrypt($value->id, 'encrypt'))}}"
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
            </div>
        </div>

    </section>
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
