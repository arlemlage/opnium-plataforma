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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.faq_list') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.faq'), 'secondSection' => __('index.faq_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="" class="w-30">@lang('index.question')</th>
                            <th class="" class="w-30">@lang('index.categories')</th>
                            <th class="ir_w_12">@lang('index.status')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj); ?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $count-- }}</td>
                                <td>
                                    <span class="text-short">{{ $value->question ?? "" }}</span>
                                </td>
                                <td>
                                    <span class="text-short">{{ $value->getProductCategory->title ?? "" }}</span>
                                </td>
                                <td>
                                    <span class="text-{{ ($value->status==1) ? 'success' : 'danger' }}">{{ ($value->status==1)? "Active":"Inactive" }}</span>
                                </td>

                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        @if(routePermission('faq.show'))
                                            <a href="{{ route('faq.show', encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.details')">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('faq.edit'))
                                            <a href="{{ route('faq.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('faq.destroy'))
                                            <form action="{{ route('faq.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
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
