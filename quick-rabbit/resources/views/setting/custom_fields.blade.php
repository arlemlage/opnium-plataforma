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
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between">
                        <div class="col-6 p-0">
                            <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header  mt-2">@lang('index.custom_fields')</h2>
                            <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                        </div>
                        @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.custom_fields')])
                    </div>
                </div>
                <div class="col-md-offset-2 col-md-4">
                    <div class="btn_list m-right d-flex">
                        <a class="btn bg-blue-btn m-right" href="{{route('custom-fields.create')}}">
                            <i data-feather="plus"></i> @lang('index.add_new')
                        </a>
                    </div>
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
                            <th class="ir_w_12">@lang('index.product_category')</th>
                            @if (appTheme() == 'single')
                                <th class="ir_w_12">@lang('index.department')</th>
                            @endif
                            <th class="ir_w_12">@lang('index.status')</th>
                            <th class="ir_w_12">@lang('index.field_count')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>{{ $value->product_category->title ?? "" }}</td>
                                @if (appTheme() == 'single')
                                    <td>{{ $value->department->name ?? "" }}</td>
                                @endif
                                <td>{{ $value->status ?? "" }}</td>
                                <td>
                                    @isset($value->custom_field_type) 
                                        {{ count(json_decode($value->custom_field_type)) ?? 0 }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        <a href="{{ route('custom-fields.edit',encrypt_decrypt($value->id,'encrypt')) }}" class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                             <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('custom-fields.destroy', encrypt_decrypt($value->id, 'encrypt'))}}"
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
    <script src="{{  asset('frequent_changing/js/custom_field.js?var=2.2') }}"></script>
@endpush
