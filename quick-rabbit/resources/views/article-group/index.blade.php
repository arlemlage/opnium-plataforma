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
                        class="top-left-header  mt-2">@lang('index.article_group_list')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.article_group'), 'secondSection' => __('index.article_group_list')])
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
                            <th class="ir_w_12">@lang('index.product_category')</th>
                            <th class="ir_w_12">@lang('index.description')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($obj as $value)
                            <tr>
                                <td class="text-center">{{ $loop->index + 1 }}</td>
                                <td>{{ $value->title ?? "" }}</td>
                                <td>{{ isset($value->product_category)? $value->getProductCategory->title:"" }}</td>
                                <td>
                                    <span class="text-short">
                                        @if ($value->description)
                                            {!! Str::limit($value->description, 50, '...') !!} <i class="fa fa-eye ms-2 readMore" data-desc="{{ $value->description }}" role="button"></i>
                                        @else
                                            N/A
                                        @endif
                                        
                                        
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex gap8">
                                        @if(routePermission('article-group.destroy'))
                                            <a href="{{ route('article-group.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('article-group.destroy'))
                                            <form action="{{ route('article-group.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
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

     @include('helper.__read_more_modal')
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
