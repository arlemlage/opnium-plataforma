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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.mail_template')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.mail_template')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="fit-content">@lang('index.sn')</th>
                            <th class="fit-content">@lang('index.event')</th>
                            <th class="fit-content">@lang('index.customer_mail_subject')</th>
                            <th class="fit-content">@lang('index.admin_agent_mail_subject')</th>
                            <th class="fit-content">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $value)
                            <tr>
                                <td class="fit-content">{{ $loop->index + 1 }}</td>
                                <td class="fit-content">{{ $value->event ?? "" }}</td>
                                <td class="fit-content">{{ $value->customer_mail_subject ?? "N/A" }}</td>
                                <td class="fit-content">{{ $value->admin_agent_mail_subject ?? "N/A" }}</td>
                                <td class="ir_txt_center">
                                    <a href="{{ url('mail-templates-edit/'.encrypt_decrypt($value->id, 'encrypt')) }}" class="edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                         <i class="fa fa-edit"></i>
                                    </a>
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
