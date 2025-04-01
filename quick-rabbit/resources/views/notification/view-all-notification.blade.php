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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.notification_list') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.notifications'), 'secondSection' => __('index.notification_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="" width="57%">@lang('index.notification_msg')</th>
                            <th class="ir_w_12">@lang('index.read_unread')</th>
                            <th class="ir_w_7">@lang('index.created_by')</th>
                            <th class="ir_w_7">@lang('index.created_at')</th>
                            <th class="text-center" width="3%">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj);?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $count-- }}</td>
                                <td>
                                    <a class="p-3 text-primary text-decoration-none" href="{{ url($value->redirect_link) }}">
                                        {{ $value->message ?? "" }}
                                    </a>
                                </td>
                                <td>
                                   {{ ($value->mark_as_read_status == 1)? 'Read':'Unread' }}
                                </td>
                                <td>{{ isset($value->created_by)? $value->getCreatedBy->first_name.' '.$value->getCreatedBy->last_name:"" }}</td>
                                <td>{{ isset($value->created_at)? date(siteSetting()->date_format, strtotime($value->created_at)) :"" }}</td>
                                <td class="ir_txt_center">
                                    <div class="btn-group  actionDropDownBtn">
                                        <button type="button" class="btn bg-blue-color dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right"
                                             role="menu">
                                            <li>
                                                <a  href="{{ url($value->redirect_link) }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                    @lang('index.details')
                                                </a>
                                            </li>
                                            <li>
                                                <a  href="{{ url('mark-as-read-unread/'.encrypt_decrypt($value->id, 'encrypt')) }}">
                                                     <i class="fa fa-edit"></i>
                                                    @if($value->mark_as_read_status==1)@lang('index.mark_as_unread') @else @lang('index.mark_as_read')@endif
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('notification-destroy', encrypt_decrypt($value->id, 'encrypt'))}}"
                                                      class="edit alertDelete{{$value->id}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="deleteRow"  data-form_class="alertDelete{{$value ->id}}" href="#">
                                                         <i class="fa fa-edit"></i> @lang('index.delete')</a>
                                                </form>
                                            </li>

                                        </ul>
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
