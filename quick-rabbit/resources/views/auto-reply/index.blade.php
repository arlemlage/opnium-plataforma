@extends('layouts.app')

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header  mt-2">@lang('index.auto_reply_list')</h3>
                    <input type="hidden" class="datatable_name" data-title="@lang('index.auto_reply_list')" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.auto_replay'),
                    'secondSection' => __('index.auto_reply_list'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <form action="{{ route('ai_replies.index') }}" method="GET">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-2">
                            @if (appTheme() == 'multiple')
                                <div class="form-group">
                                    <label>@lang('index.product_category') </label>
                                    <select name="product" id="product_id" class="form-control select2">
                                        <option value="">@lang('index.select')</option>
                                        @foreach (getAllProductCategory() as $product)
                                            <option value="{{ $product->id }}"
                                                {{ isset($product_id) && $product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group">
                                    <label>@lang('index.departments') </label>
                                    <select name="department" id="department_id" class="form-control select2">
                                        <option value="">@lang('index.select')</option>
                                        @foreach (getAllDepartment() as $department)
                                            <option value="{{ $department->id }}"
                                                {{ isset($department_id) && $department_id == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>
                        <div class="col-sm-12 mb-2 col-md-2">
                            <div class="form-group mt-0">
                                <button type="submit" class="btn bg-blue-btn w-100 top h-40" id="go">
                                    @lang ('index.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1">@lang('index.sn')</th>
                                <th class="w-30">@lang('index.question')</th>
                                @if (appTheme() == 'multiple')
                                    <th class="ir_w_12">@lang('index.product_category')</th>
                                @else
                                    <th class="ir_w_12">@lang('index.department')</th>
                                @endif
                                <th class="ir_w_45">@lang('index.answer')</th>
                                <th class="ir_w_1_txt_center">@lang('index.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obj as $value)
                                <tr>
                                    <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <span class="text-short">{{ $value->question ?? '' }}</span>
                                    </td>
                                    <td>
                                        @if (appTheme() == 'multiple')
                                            {{ isset($value->category_id) ? $value->getProductCategory->title : '' }}
                                        @else
                                            {{ isset($value->department_id) ? $value->getDepartment->name : '' }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-short">{!! Str::limit($value->answer, 50, '...') ?? '' !!} <i class="fa fa-eye ms-2 readMore"
                                                data-desc="{{ $value->answer }}" role="button"></i></span>
                                    </td>
                                    <td class="ir_txt_center">
                                        <div class="d-flex gap8">
                                            @if (routePermission('ai_replies.edit'))
                                                <a href="{{ route('ai_replies.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                    class="edit success-color" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (routePermission('ai_replies.destroy'))
                                                <form
                                                    action="{{ route('ai_replies.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                    class="edit alertDelete{{ $value->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="deleteRow delete"
                                                        data-form_class="edit alertDelete{{ $value->id }}" href="#"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
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
    <!-- ReadMore Modal-->
    @include('helper.__read_more_modal')
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
