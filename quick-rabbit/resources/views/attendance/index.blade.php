@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/hide_search.css?var=2.2') }}">
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
                    <h2 class="top-left-header  mt-2">@lang ('index.attendance_list')</h2>
                    <input type="hidden" class="datatable_name" data-title="@lang ('index.attendance_list')" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.attendance'), 'secondSection' => __('index.attendance_list')])
            </div>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- If admin want to search attendance from manual list -->
                <form action="{{ route('attendance.index') }}" method="GET">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="user_id">@lang ('index.employee')</label>
                                <select name="user_id" class="form-control select2" id="user_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ isset($user_id) && $user_id == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="from_date">@lang('index.from_date')</label>
                                <input type="text" name="from_date" class="form-control customDatepicker" autocomplete="off" value="{{ $from_date ?? "" }}" placeholder="@lang('index.from_date')" readonly>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="to_date">@lang('index.to_date')</label>
                                <input type="text" name="to_date" class="form-control customDatepicker" autocomplete="off" value="{{ $to_date ?? "" }}" placeholder="@lang('index.to_date')" readonly>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <button type="submit"
                                    class="btn bg-blue-btn w-100 top" id="go">
                                        @lang ('index.search')
                                    </button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <!-- Attendance search from end -->
                <div class="table-responsive">
                    <table id="datatable" class="table text-nowrap">
                        <thead>
                        <tr>
                            <th class="ir_w_1"></th>
                            <th class="ir_w_12">@lang('index.date')</th>
                            <th class="ir_w_12">@lang ('index.employee')</th>
                            <th class="ir_w_12">@lang ('index.in_time')</th>
                            <th class="ir_w_7">@lang ('index.out_time')</th>
                            <th class="ir_w_7">@lang ('index.time_count')</th>
                            <th class="ir_w_7">@lang ('index.note')</th>
                            <th class="ir_w_7">@lang ('index.added_by')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $data)
                            <tr>
                                <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                <td>{{ orgDateFormat($data->in_time)  }}</td>
                                <td>{{ getUserName($data->user_id) }}</td>
                                <td>{{ $data->in_time }}</td>
                                <td>{{ $data->out_time ?? 'N/A' }}</td>
                                <td>{{ $data->display_hours }}</td>
                                <td class="text_wrap_balance">{{ $data->note ?? 'N/A' }}</td>
                                <td>{{ getUserName($data->added_by) }}</td>
                                <td class="ir_txt_center">
                                    <div class="d-flex gap8">
                                        <a href="{{ route('attendance.edit',encrypt_decrypt($data->id,'encrypt')) }}" class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="@lang('index.edit')">
                                             <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('attendance.destroy', $data->id)}}"
                                              class="edit alertDelete{{$data->id}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a class="deleteRow delete"  data-form_class="alertDelete{{$data ->id}}" href="#" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-original-title="@lang('index.delete')">
                                                 <i class="fa fa-trash"></i>
                                        </form>
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
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
