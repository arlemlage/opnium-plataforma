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
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                <div class="col-md-offset-2 col-md-4">
                    <div class="btn_list m-right d-flex">    
                    </div>
                </div>
            </div>
        </section>

        <div class="box-wrapper">
            @if(authUserRole() != 3)
                <div class="row text-center">
                    @php 
                        $attendance = App\Model\Attendance::where('user_id',Auth::id())->whereNotNull('in_time')->whereNull('out_time')->first();
                        if(App\Model\Attendance::where('user_id',Auth::id())->whereNotNull('in_time')->whereNull('out_time')->exists()){
                            $logIn = false;
                            $logOut = true;
                        } else{
                            $logIn = true;
                            $logOut = false;
                        }
                    @endphp

                    @if($logIn)
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <a href="{{ route('in-attendance') }}" class="btn bg-blue-btn w-100 top ">
                                @lang('index.check_in_attendance')
                            </a>
                        </div>
                        <div class="col-md-4"></div>
                    @endif

                    @if($logOut)
                        <h3 class="check_in_out_page">@lang('index.last_check_in') {{ date("h:i:s", strtotime($attendance->in_time)) }}</h3>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 pt-0">
                            <a href="{{ route('out-attendance') }}" class="btn btn-md bg-red-btn text-left">
                                @lang('index.check_out_attendance')
                            </a>
                        </div>
                        <div class="col-md-4"></div>
                    @endif
                </div>
            @endif
            <hr>
            <!-- general form elements -->
            <div class="table-box">
                <!-- If admin want to search attendance from manual list -->
                <form action="{{ route('check-in-out') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="from_date">@lang('index.from_date')</label>
                                <input type="text" name="from_date" class="form-control customDatepicker" autocomplete="off" value="{{ $from_date ?? "" }}" placeholder="@lang('index.from_date')" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="to_date">@lang('index.to_date')</label>
                                <input type="text" name="to_date" class="form-control customDatepicker" autocomplete="off" value="{{ $to_date ?? "" }}" placeholder="@lang('index.to_date')" readonly>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2 col-md-4">
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
                            <th class="ir_w_1"></th>
                            <th class="ir_w_12">@lang('index.date')</th>
                            <th class="ir_w_12">@lang ('index.in_time')</th>
                            <th class="ir_w_7">@lang ('index.out_time')</th>
                            <th class="ir_w_7">@lang ('index.time_count')</th>
                            <th class="ir_w_7">@lang ('index.note')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $data)
                                <tr>
                                    <td class="ir_txt_center">{{ $loop->index + 1 }}</td>
                                    <td>{{ orgDateFormat($data->attendance_date) }}</td>
                                    <td>{{ $data->in_time }}</td>
                                    <td>{{ $data->out_time ?? 'N/A' }}</td>
                                    <td>{{ $data->display_hours }}</td>
                                    <td>{{ $data->note ?? 'N/A' }}</td>
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
