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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.department') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.department')])
            </div>
            <div class="col-md-offset-2 col-md-4">
                <div class="btn_list m-right d-flex">
                    <a class="btn bg-blue-btn m-right" href="{{route('departments.create')}}">
                        @lang('index.add_department')
                    </a>
                </div>
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table text-nowrap">
                        <thead>
                        <tr>
                            <th class="ir_w_1 ir_txt_center">@lang('index.sn')</th>
                            <th class="ir_w_12">@lang('index.name')</th>
                            <th class="ir_w_12">@lang('index.leader')</th>
                            <th class="ir_w_12">@lang('index.description')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj);?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $count-- }}</td>
                                <td>{{ $value->name ?? "" }}</td>
                                <td>{{ $value->leader ?? "" }}</td>
                                <td>{{ $value->description ?? "" }}</td>
                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        <a href="{{ route('departments.edit',encrypt_decrypt($value->id,'encrypt')) }}" class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                             <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('departments.destroy', encrypt_decrypt($value->id, 'encrypt'))}}"
                                              class="edit alertDelete{{$value->id}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a class="deleteRow delete"  data-form_class="alertDelete{{$value ->id}}" href="#" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-original-title="@lang('index.delete')">
                                                 <i class="fa fa-trash"></i>
                                        </form>
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
