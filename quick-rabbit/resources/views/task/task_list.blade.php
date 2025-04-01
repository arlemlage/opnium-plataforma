@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="alert-wrapper">
            {{ alertMessage() }}
        </section>
        <input type="hidden" class="datatable_name" data-title="Reason" data-id_name="datatable">
        <section class="content-header">
            <div class="row">
                <div class="row justify-content-between">
                    <div class="col-6 p-0">
                        <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header  mt-2">
                            {{ $title ?? __('index.task_list') }} </h2>
                    </div>
                    @include('layouts.breadcrumbs', [
                        'firstSection' => __('index.task'),
                        'secondSection' => $title,
                    ])
                </div>
                <div class="col-md-offset-2 col-md-4">
                    <div class="btn_list m-right d-flex">
                        <a class="btn bg-blue-btn m-right" href="{{ route('task-lists.create') }}">
                            <i data-feather="plus"></i> @lang('index.add_task')
                        </a>
                    </div>

                </div>
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1">@lang('index.sn')</th>
                                <th class="w-30">@lang('index.task')</th>
                                <th class="ir_w_12">@lang('index.assignee')</th>
                                <th class="ir_w_12">@lang('index.assign_date')</th>
                                <th class="ir_w_12">@lang('index.description')</th>
                                <th class="ir_w_12">@lang('index.file')</th>
                                <th class="ir_w_12">@lang('index.status')</th>
                                <th class="ir_w_1_txt_center">@lang('index.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $value)
                                <tr>
                                    <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                    <td>
                                        {{ $value->task_title ?? '' }}
                                    </td>
                                    <td>{{ $value->user->full_name ?? '' }}</td>
                                    <td>{{ orgDateFormat($value->work_date) ?? '' }}</td>
                                    <td>
                                        <span class="text-short">{!! Str::limit($value->description, 20, '...') ?? '' !!} <i class="fa fa-eye ms-2 readMore" data-desc="{{ $value->description }}" role="button"></i></span>
                                        
                                    </td>
                                    <td>
                                        @if ($value->file != null && file_exists('uploads/tasks/'.$value->file))
                                            <a class="btn bg-blue-btn text-center fit-content" target="_blank"
                                                href="{{ asset('uploads/tasks/'.$value->file) }}"><iconify-icon icon="solar:eye-bold"
                                                    width="22"></iconify-icon></a>
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-{{ $value->status == 'Pending' ? 'danger' : 'success' }}">
                                            {{ ucfirst($value->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap8">
                                            @if (routePermission('task-lists.edit'))
                                                <a href="{{ route('task-lists.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                    class="edit success-color" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (routePermission('task-lists.destroy'))
                                                <form
                                                    action="{{ route('task-lists.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
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
                <!-- /.box-body -->
            </div>
        </div>

    </section>

    <!-- ReadMore Modal-->
 @include('helper.__read_more_modal')
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
