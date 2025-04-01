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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.tag_list')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.tag'), 'secondSection' => __('index.tag_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table text-nowrap">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="ir_w_12">@lang('index.title')</th>
                            <th class="ir_w_12">@lang('index.description')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($obj as $value)
                            <tr>
                                <td class="">{{ $loop->index + 1 }}</td>
                                <td>{{ $value->title ?? "" }}</td>
                                <td>
                                    <span class="d-inline-block text-truncate">{!! $value->description ?? "N/A" !!}</span>
                                </td>

                                <td class="">
                                    <div class="d-flex gap8">
                                        @if(routePermission('tag.edit'))
                                            <a href="{{ route('tag.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('tag.destroy'))
                                            <form action="{{ route('tag.destroy', encrypt_decrypt($value->id, 'encrypt'))}}"
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
