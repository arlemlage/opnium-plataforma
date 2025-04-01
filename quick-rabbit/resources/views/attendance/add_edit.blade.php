@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>        
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 class="top-left-header  mt-2">
                        {{ __('index.'.titleConverter($title)) }}
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.attendance'), 'secondSection' => $title])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($data) && $data?$data:'', ['method' => isset($data) && $data?'PATCH':'POST','id'=>'update_data','enctype'=>'multipart/form-data', 'route' => ['attendance.update', isset($data->id) && $data->id?$data->id:''],'id' => 'common-form']) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>
                                    @lang('index.reference_no')
                                </label>
                                {!! Form::text('reference',$data->reference ?? $code,array('class'=>"form-control",'id'=>"reference",'placeholder' => __('index.reference_no'))) !!}
                            </div>
                            @error('reference')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>
                                    @lang ('index.agent')
                                    {!! starSign() !!}
                                </label>
                                
                                <select name="user_id" class="form-control select2" id="user_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ isset($data) && $data->user_id == $user->id || old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->full_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                         <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                             <div class="form-group">
                                 <label>@lang('index.date'){!! starSign() !!}</label>
                                 
                                @php
                                    $loginDate = '';
                                    if(isset($data)){
                                        $loginDate = date('Y-m-d',strtotime($data->attendance_date));
                                    }elseif(!empty(old('attendance_date'))){
                                        $loginDate = old('attendance_date');
                                    }elseif(isset($tDate)){
                                        $loginDate = $tDate;
                                    } else{
                                        $loginDate = "";
                                    }
                                @endphp
                                 <input type="text" name="attendance_date" value="{{ $loginDate ?? "" }}" placeholder="@lang('index.checkin_date')" class="form-control customDatepicker" autocomplete="off" readonly>

                            </div>
                            @error('attendance_date')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                         </div>
                         <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                             <div class="form-group">
                                 <label for="">@lang('index.in_time'){!! starSign() !!}</label>
                                 
                                 @php
                                    $loginTime = '';
                                    if(isset($data)){
                                        $loginTime = date('H:i',strtotime($data->in_time));
                                    }elseif(!empty(old('in_time'))){
                                        $loginTime = old('in_time');
                                    }else{
                                        $loginTime = "";
                                    }
                                @endphp
                                 <input type="text" name="in_time" value="{{ $loginTime ?? "" }}" placeholder="@lang ('index.in_time')" class="form-control customTimepicker" autocomplete="off" readonly>

                            </div>
                            @error('in_time')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                         </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                             <div class="form-group">
                                 <label>
                                    @lang ('index.out_time')
                                </label>
                                <input type="text" name="out_time" value="{{ old('out_time') ?? $data->out_time ?? "" }}" placeholder="@lang ('index.out_time')" class="form-control customTimepicker" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label>@lang ('index.note')</label>
                                {!! Form::textarea('note',old('note'),array('id'=>'note','class'=>"form-control",'row'=>"8",'placeholder'=>__('index.note'))) !!}
                                @error('note')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100" id="submit-btn">
                                        {!! commonSpinner() !!}@lang ('index.submit')
                                    </button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn bg-blue-btn w-100" href="{{ route('attendance.index') }}">
                                @lang ('index.back')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop

@push('js')
<script src="{{ asset('frequent_changing/js/timepicker_custom.js?var=2.2') }}"></script>
@endpush
