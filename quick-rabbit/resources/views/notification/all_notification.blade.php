@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/notification.css?var=2.2') }}">
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
                    <table id="datatable"  class="table" data-ordering="false">
                        <thead>
                        <tr>
                            <th class="ir_w_1">
                                <div class="d-flex">
                                    <input type="checkbox" id="allCheck">
                                    <div class="btn-group  actionDropDownBtn">
                                        <button type="button" class=" bg-blue-color"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right"
                                             role="menu">
                                            <li>
                                                <a  href="javascript:void(0)" id="mark_as_read">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                    @lang('index.mark_as_read')
                                                </a>
                                            </li>
                                            <li>
                                                <a  href="javascript:void(0)" id="delete_all">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon>
                                                    @lang('index.delete_all')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </th>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="text-left" width="47%">@lang('index.notification_msg')</th>
                            <th class="ir_w_12">@lang('index.read_unread')</th>
                            <th class="ir_w_7">@lang('index.created_by')</th>
                            <th class="text-center" width="3%">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $count = sizeof($results);?>
                            @foreach($results as $key => $value)
                                <tr class="{{ $value->mark_as_read_status == 1 ? 'bg-white' : 'bg-grey' }}">
                                    <td>
                                        <input type="checkbox" name="check_data[]"  class="checkbox_notification" value="{{ $value->id }}" id="user_{{ $key }}">
                                    </td>
                                    <td class="ir_txt_center">{{ $count-- }}</td>
                                    <td>
                                        <a target="_blank" class="text-black text-decoration-none" href="{{ url($value->redirect_link) }}">
                                            {{ $value->message ?? "" }}
                                        </a>
                                    </td>
                                    <td>
                                       {{ ($value->mark_as_read_status == 1 ) ? 'Read':'Unread' }}
                                    </td>
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
                                                @if($value->mark_as_read_status != 1)
                                                    <li>
                                                    <a  href="{{ route('mark-as-read',encrypt_decrypt($value->id, 'encrypt')) }}">
                                                         <i class="fa fa-edit"></i>
                                                        @if($value->mark_as_read_status==1)@lang('index.mark_as_unread') @else @lang('index.mark_as_read')@endif
                                                    </a>
                                                </li>
                                                @endif
                                                <li>
                                                    <form action="{{ route('delete-notification', encrypt_decrypt($value->id, 'encrypt'))}}"
                                                          class="edit alertDelete{{$value->id}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="deleteRow"  data-form_class="alertDelete{{$value ->id}}" href="#">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon> @lang('index.delete')</a>
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
    <script src="{{ asset('frequent_changing/js/notification.js?var=2.2') }}"></script>
    @include('layouts.data_table_script')
@endpush
