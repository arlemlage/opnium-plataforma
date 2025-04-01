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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}"
                        class="top-left-header  mt-2">@lang('index.product_category_list')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.product_category'), 'secondSection' => __('index.product_category_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="w-30">@lang('index.title')</th>
                            <th class="ir_w_7">@lang('index.product_code')</th>
                            <th class="ir_w_12">@lang('index.photo_thumb')</th>
                            <th class="ir_w_7">@lang('index.status')</th>
                            <th class="ir_w_12">@lang('index.verification')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $verification = ['0' => 'None', '1' => 'Envato', '2' => 'Woocommerce', '3' => 'Shopify', '4' => 'Easy Digital Downloads', '5' => 'Themely Marketplace'];
                        ?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>
                                    <span class="text-short">{{ $value->title ?? "" }}</span>
                                </td>
                                <td>
                                    <span class="text-short">{{ $value->product_code ?? "" }}</span>
                                </td>
                                <td>
                                    <img src="{{ asset($value->photo_thumb) }}" alt="@lang('index.photo_thumb')"
                                         class="img-responsive product-img-product-list-page">
                                </td>
                                <td>
                                    @if($value->status == 1)
                                        <span class="text-success">@lang('index.active')</span>
                                    @elseif($value->status == 2)
                                        <span class="text-danger">@lang('index.in_active')</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($value->verification == 1)
                                        Envato ({{ $value->envato_product_code ?? "" }})
                                    @else
                                        {{ "None" }}
                                    @endif
                                </td>

                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        @if(routePermission('product-category.edit'))
                                            <a href="{{ route('product-category.edit', encrypt_decrypt($value->id, 'encrypt'))}}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('product-category.destroy'))
                                            <form action="{{ route('product-category.destroy', encrypt_decrypt($value->id, 'encrypt'))}}"
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
