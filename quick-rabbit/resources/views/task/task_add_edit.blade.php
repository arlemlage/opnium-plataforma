@extends('layouts.app')
@push('css')
@endpush

@section('content')
<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    {{ $title ?? __('index.add_task') }}
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.task'), 'secondSection' => $title ])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <form action="{{ $route }}" method="post" enctype="multipart/form-data" id="common-form">
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset
            <div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>
                            	@lang('index.title'){!! starSign() !!}</label>
                            <input type="text" name="task_title" id="task_title" value="{{ old('task_title') ?? $data->task_title ?? '' }}" class="form-control @error('task_title') is-invalid @enderror" placeholder="@lang('index.title')">
                        </div>
                        @error('task_title')
                        <span class="error_alert text-danger">
                            	{{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.ticket')</label>
                            <select name="ticket_id" id="ticket_id" class="form-control select2">
                                <option value="">@lang('index.select')</option>
                                @foreach($tickets as $ticket)
                                <option value="{{ $ticket->id }}" {{ isset($data) && $data->ticket_id == $ticket->id || old('ticket_id') == $ticket->id ? 'selected' : '' }}>
                                    {{ $ticket->ticket_no . ' - '. $ticket->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.agent')</label>
                            <select name="assigned_person" id="assigned_person" class="form-control select2">
                                <option value="">@lang('index.select')</option>
                                @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ isset($data) && $data->assigned_person == $agent->id || old('assigned_person') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->full_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>@lang('index.date'){!! starSign() !!}</label>
                            <input type="text" name="work_date" id="work_date" value="{{ old('work_date') ?? $data->work_date ?? '' }}" class="form-control customDatepicker" placeholder="@lang('index.date')" autocomplete="off" readonly>
                        </div>
                        @error('work_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>
                            	@lang('index.file') (@lang('index.max_file_size_5mb'))
                            </label>
                            <div class="d-flex gap-1">
                                <input tabindex="1" type="file" name="file" class="form-control file_checker_global" data-this_file_size_limit="5" >
                                @isset($data)
                                    @if(file_exists('uploads/tasks/'.$data->file))
                                        <a class="btn bg-blue-btn pull-right btn-xs" href="{{ asset('uploads/tasks/'.$data->file) }}" target="_blank">
                                            <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                        </a>
                                    @endif
                                @endisset
                            </div>

                            @error('file')
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>
                    </div>
                     <div class="col-lg-4 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label for="status">@lang('index.status'){!! starSign() !!}</label>
                            
                            <select name="status" class="form-control select2 @error('status') is-invalid @enderror" id="position">
                                <option value="">@lang('index.select')</option>
                                <option value="Pending"  {{ old('status') && old('status') === "Pending" ? 'selected' : '' }} {{ isset($data) && $data->status === "Pending" ? 'selected' : '' }}>@lang('index.pending')</option>
                                <option value="In-Progress"  {{ old('status') && old('status') === "In-Progress" ? 'selected' : '' }} {{ isset($data) && $data->status === "In-Progress" ? 'selected' : '' }}>@lang('index.in_progress')</option>
                                <option value="Done" {{ old('status') && old('status') === "Done" ? 'selected' : '' }} {{ isset($data) && $data->status === "Done" ? 'selected' : '' }}>@lang('index.done')</option>
                            </select>
                        </div>
                         @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label>
                                @lang('index.description')
                                {!! starSign() !!}
                            </label>
                            
                            <textarea name="description" id="description" maxlength="2000" cols="30" rows="10" class="form-control  @error('description') is-invalid @enderror" placeholder="@lang('index.description')">{{ old('description') ?? $data->description ?? '' }}</textarea>
                        </div>
                        @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit"
                                class="btn bg-blue-btn w-100" id="submit-btn">
                                <span class="me-2 spinner d-none"><iconify-icon icon="la:spinner" width="22"></iconify-icon></span>
                                @lang('index.submit')
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-2">
                        <a class="btn custom_header_btn w-100" href="{{ route('task-lists.index') }}">
                            @lang('index.back')
                        </a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
@stop

@push('js')

@endpush
