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
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header  mt-2">{{ __('index.article_list') }}
                    </h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.article'),
                    'secondSection' => __('index.article_list'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <form action="{{ route('articles.index') }}" method="GET">
                    <div class="row">
                        @if (appTheme() == 'multiple')
                            <div class="col-sm-12 mb-2 col-md-3">
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
                            </div>
                        @endif
                        <div class="col-sm-12 mb-2 col-md-3">
                            <div class="form-group">
                                <label>@lang('index.article_group') </label>
                                @if (appTheme() == 'multiple')
                                    <select name="article_group" class="form-control select2" id="article_group_id">
                                        @if (isset($article_group_id))
                                            <option value="{{ $article_group_id }}">
                                                {{ App\Model\ArticleGroup::find($article_group_id)->title ?? '' }}</option>
                                        @else
                                            <option value="">@lang('index.select')</option>
                                        @endif

                                    </select>
                                @else
                                    <select name="article_group" class="form-control select2" id="article_group_id">
                                        @if (!empty($article_groups))
                                            @foreach ($article_groups as $group)
                                                <option value="{{ $group->id }}">
                                                    {{ $group->title ?? '' }}</option>
                                            @endforeach
                                        @else
                                            <option value="">@lang('index.select')</option>
                                        @endif
                                    </select>
                                @endif
                            </div>
                        </div>


                        <div class="col-sm-12 mb-2 col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn bg-blue-btn w-100 top" id="go">
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
                                <th class="w-30">@lang('index.title')</th>
                                <th class="ir_w_12">@lang('index.internal_external')</th>
                                <th class="ir_w_12">@lang('index.product_category')</th>
                                <th class="ir_w_12">@lang('index.article_group')</th>
                                <th class="ir_w_12">@lang('index.status')</th>
                                <th class="ir_w_1_txt_center">@lang('index.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obj as $value)
                                <tr>
                                    <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <span>{{ \Illuminate\Support\Str::limit($value->title, 50, '...') ?? '' }}</span>
                                    </td>
                                    <td>{{ $value->internal_external == 2 ? 'Internal' : 'External' }}</td>
                                    <td>{{ $value->getProductCategory->title ?? '' }}</td>
                                    <td>{{ isset($value->article_group_id) ? $value->getArticleGroup->title : '' }}</td>
                                    <td>{{ $value->status == 1 ? 'Active' : 'InActive' }}</td>

                                    <td class="ir_txt_center">
                                        <div class="d-flex gap8">
                                            @if (routePermission('article.show'))
                                                <a href="{{ route('articles.show', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                    class="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="@lang('index.details')">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif
                                            @if (routePermission('article.edit'))
                                                <a href="{{ route('articles.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                    class="edit success-color" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (routePermission('article.destroy'))
                                                <form
                                                    action="{{ route('articles.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                    class="edit alertDelete{{ $value->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="deleteRow delete"
                                                        data-form_class="edit alertDelete{{ $value->id }}" href="#"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="@lang('index.delete')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
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
    <script src="{{ asset('frequent_changing/js/article_list.js?var=2.2') }}"></script>
    @include('layouts.data_table_script')
@endpush
