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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.canned_msg_list') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="{{ __('index.canned_msg_list') }}" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.canned_msg'), 'secondSection' => __('index.canned_msg_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="w-40">@lang('index.title')</th>
                            <th class="w-50">@lang('index.content')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($obj as $value)
                            <tr>
                                <td class="">{{ $loop->index + 1 }}</td>
                                <td>
                                    <span class="text-short">{{ nl2br($value->title) ?? "" }}</span>
                                </td>
                                <td>
                                    <span class="text-short">{!! Str::limit($value->canned_msg_content, 150, '...') ?? 'N/A' !!}</span>
                                </td>

                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">                                        
                                            @if(routePermission('canned-message.edit'))
                                        <a href="{{ route('canned-message.edit', encrypt_decrypt($value->id, 'encrypt')) }}" class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                             <i class="fa fa-edit"></i>
                                        </a>
                                            @endif
                                            @if(routePermission('canned-message.destroy'))
                                        <form action="{{ route('canned-message.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
                                              class="edit alertDelete{{$value->id}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a class="deleteRow delete"  data-form_class="alertDelete{{$value ->id}}" href="#" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-original-title="@lang('index.delete')">
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
