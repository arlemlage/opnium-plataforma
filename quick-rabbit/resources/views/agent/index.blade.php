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
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">{{ __('index.agent_list') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.agent'),
                    'secondSection' => __('index.agent_list'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1">@lang('index.sn')</th>
                                <th class="ir_w_12">@lang('index.first_name')</th>
                                <th class="ir_w_12">@lang('index.last_name')</th>
                                <th class="ir_w_12">@lang('index.email')</th>
                                <th class="ir_w_12">@lang('index.mobile')</th>
                                @if (appTheme() == 'multiple')
                                <th class="ir_w_12">@lang('index.product_category')</th>
                                @endif
                                <th class="ir_w_12">@lang('index.role')</th>
                                <th class="ir_w_12">@lang('index.department')</th>
                                <th class="ir_w_12">@lang('index.status')</th>
                                <th class="ir_w_1_txt_center">@lang('index.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = sizeof($obj); ?>
                            @foreach ($obj as $value)
                                <tr>
                                    <td class="ir_txt_center">{{ $count-- }}</td>
                                    <td>{{ $value->first_name ?? '' }}</td>
                                    <td>{{ $value->last_name ?? '' }}</td>
                                    <td>{{ $value->email ?? '' }}</td>
                                    <td>{{ $value->mobile ?? '' }}</td>
                                    @if (appTheme() == 'multiple')
                                        <td>
                                            @if (!empty($value->product_cat_ids))
                                                <?php $all_product_cat = \App\Model\ProductCategory::type()->whereIn('id', explode(',', $value->product_cat_ids))
                                                    ->where('del_status', 'Live')
                                                    ->get(); ?>
                                                @foreach ($all_product_cat as $cat)
                                                    {{ $cat->title }}
                                                    @unless ($loop->last)
                                                        {{ ', ' }}
                                                    @endunless
                                                @endforeach
                                            @else
                                                {{ 'All' }}
                                            @endif
                                        </td>
                                    @endif

                                    <td>{{ getRolePermissionName($value->permission_role) ?? 'N/A' }}</td>
                                    <td>{{ $value->department->name ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="text-{{ $value->status == 1 ? 'success' : 'danger' }}">{{ $value->status == 1 ? 'Active' : 'Inactive' }}</span>
                                    </td>

                                    <td class="ir_txt_center">
                                        @if ($value->id != 3)
                                            <div class="d-flex gap8">
                                                @if (routePermission('agent.edit'))
                                                    <a href="{{ route('agent.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                        class="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="@lang('index.edit')">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if (routePermission('agent.destroy'))
                                                    <form
                                                        action="{{ route('agent.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
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
                                        @else
                                            <small>@lang('index.default_agent')</small>
                                        @endif
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
