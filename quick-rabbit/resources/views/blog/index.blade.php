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
                        class="top-left-header mb-0">{{ __('index.blog_list') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="{{ __('index.blog_list') }}"
                           data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.blog'), 'secondSection' => __('index.blog_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="row">
                    <div class="col-md-4">
                        <select id="category" class="form-control select2 w-300">
                            <option value="">@lang('index.show_category_wise')</option>
                            @foreach($categories as $category)
                                <option value="{{ route('blog.index',['category' => encrypt_decrypt($category->id,'encrypt')]) }}" {{ isset($category_id) && $category->id == encrypt_decrypt($category_id,'decrypt') ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="w-20">@lang('index.category')</th>
                            <th class="w-50">@lang('index.title')</th>
                            <th class="ir_w_12">@lang('index.status')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>
                                    <span class="text-short">{{ $value->category->title }}</span>
                                </td>
                                <td>
                                    <span class="text-short">{{ $value->title ?? "" }}</span>
                                </td>
                                <td>
                                    <span class="{{ $value->status==1 ? 'text-success' : 'text-danger' }}">{{ ($value->status==1)? "Active":"Inactive" }}</span>
                                </td>
                                <td class="">
                                    <div class="d-flex gap8">
                                        @if(routePermission('blog.show'))
                                            <a href="{{ route('blog.show', encrypt_decrypt($value->id, 'encrypt'))}}"
                                               class="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.details')">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('blog.edit'))
                                            <a href="{{ route('blog.edit', encrypt_decrypt($value->id, 'encrypt'))}}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('blog.destroy'))
                                            <form action="{{ route('blog.destroy', encrypt_decrypt($value->id, 'encrypt'))}}"
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
    <script src="{{ asset('frequent_changing/js/blog_page.js?var=2.2') }}"></script>
    @include('layouts.data_table_script')
@endpush
