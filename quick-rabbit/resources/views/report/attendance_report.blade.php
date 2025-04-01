@extends('layouts.app')
@push('css')
    
@endpush

@section('content')
    <input type="hidden" class="is_pagination" value="false">
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>


        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h2 class="top-left-header  mt-2">@lang ('index.attendance_report')</h2>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.report'), 'secondSection' => __('index.attendance_report')])
            </div>
        </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- If admin want to search attendance from manual list -->
                <form action="{{ route('attendance-report') }}" method="GET">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="user_id">@lang ('index.employee')</label>
                                <select name="user_id" class="form-control select2" id="user_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($users as $user)
                                        <option value="{{ encrypt_decrypt($user->id,'encrypt') }}" {{ isset($user_id) && $user_id == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="from_date">@lang('index.from_date')</label>
                                <input type="text" name="from_date" class="form-control customDatepicker" autocomplete="off" value="{{ $from_date ?? "" }}" placeholder="@lang('index.from_date')" readonly>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="to_date">@lang('index.to_date')</label>
                                <input type="text" name="to_date" class="form-control customDatepicker" autocomplete="off" value="{{ $to_date ?? "" }}" placeholder="@lang('index.to_date')" readonly>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
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
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="ir_w_12">@lang('index.date')</th>
                            <th class="ir_w_12">@lang ('index.employee')</th>
                            <th class="ir_w_12">@lang ('index.in_time')</th>
                            <th class="ir_w_7">@lang ('index.out_time')</th>
                            <th class="ir_w_7">@lang ('index.time_count')</th>
                            <th class="ir_w_7">@lang ('index.note')</th>
                            <th class="ir_w_7">@lang ('index.added_by')</th>
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
                                <td>
                                <span class="text-short">{!! Str::limit($data->note, 50, '...') ?? 'N/A' !!} 
                                @if($data->note)
                                <i class="fa fa-eye ms-2 readMore" data-desc="{{ $data->note }}" role="button"></i>
                                @endif
                                </span>
                                </td>
                                <td>{{ getUserName($data->added_by) }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr class="mt-4">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="fw-bold">  @lang('index.total_hour'):</td>
                            <td class="fw-bold">{{ $results->sum('work_hour') }} @lang('index.hours')</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
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
