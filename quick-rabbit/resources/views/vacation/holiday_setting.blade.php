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
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    @lang('index.holiday_setting')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.holidays'), 'secondSection' => __('index.holiday_setting')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <form action="{{ route('update-holiday-setting') }}" method="POST">
            @csrf
            @method('PUT')
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>@lang('index.day')</th>
                                <th>@lang('index.is_holiday')</th>
                                <th>@lang('index.start_time')</th>
                                <th>@lang('index.end_time')</th>
                                <th>@lang('index.send_autoresponse')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($holidays as $holiday)
                            <tr>
                                <td>
                                    <input type="hidden" name="holiday_id[]" value="{{ $holiday->id }}">
                                    <input type="text" name="day[]" class="form-control" readonly value="{{ $holiday->day }}">
                                </td>
                                <td>
                                    <label class="switch_ticketly">
                                        <input type="checkbox" class="holiday_checked" {{ $holiday->is_holiday =='Yes' ? 'checked':'' }} data-id="{{ $holiday->id }}">
                                        <span class="slider round"></span>
                                    </label>
                                    <input type="hidden" name="is_holiday[]" value="{{ $holiday->is_holiday }}" id="is_holiday_{{ $holiday->id }}">
                                </td>
                                <td>
                                    <input type="text" name="start_time[]" class="form-control customTimepicker" value="{{ $holiday->start_time }}" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" name="end_time[]" class="form-control customTimepicker" value="{{ $holiday->end_time }}" autocomplete="off">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-2">
                    <input type="checkbox" id="auto_response" value="Yes" {{ isset($obj) && $obj->auto_response == 'Yes' ? 'checked' : '' }}>
                    <label for="auto_response">@lang('index.auto_response_on_vaction')</label>
                </div>

                <div class="col-sm-12 mb-2 col-md-12 mt-2 displayNone" id="note_div">
                    <div class="form-group">
                        <label>@lang('index.note'){!! starSign() !!}</label> 
                        <textarea name="note" id="note" cols="30" rows="10" class="form-control" placeholder="@lang('index.note')">{{ $obj->note ?? old('note') ?? '' }}</textarea>
                        <div class="invalid-feedback">
                            <span>@lang('index.note_field_required_auto_response_true')</span>
                        </div>
                    </div>
                    @error('note')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100">@lang('index.submit')</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</section>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/holiday_setting.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/timepicker_custom.js?var=2.2') }}"></script>
@endpush
