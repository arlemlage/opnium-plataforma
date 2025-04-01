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
            <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.article_list') }}</h3>
            <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
        </section>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.article_list') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.article'), 'secondSection' => __('index.article_list') ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="" class="w-30">@lang('index.title')</th>
                            <th class="ir_w_12">@lang('index.internal_external')</th>
                            <th class="ir_w_12">@lang('index.product_category')</th>
                            <th class="ir_w_12">@lang('index.article_group')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj);?>
                        @foreach($obj as $value)
                            <tr>
                                 <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>
                                    <span>{{ \Illuminate\Support\Str::limit($value->title,50,'...') ?? "" }}</span>
                                </td>
                                <td>{{ $value->internal_external == 1 ? "Internal" : 'External' }}</td>
                                <td>{{ isset($value->product_category_id)? $value->getProductCategory->title:"" }}</td>
                                <td>{{ isset($value->article_group_id)? $value->getArticleGroup->title:"" }}</td>
                                <td class="ir_txt_center">
                                    <div class="btn-group  actionDropDownBtn">
                                        <button type="button" class="btn bg-blue-color dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right"
                                             role="menu">
                                            <li>
                                                <a  href="{{ url('article-view/'.encrypt_decrypt($value->id, 'encrypt')) }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                    @lang('index.details')
                                                </a>
                                            </li>
                                        </ul>
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
