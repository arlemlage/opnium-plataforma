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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.activity_log')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.activity_log')])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- Search -->
            <form action="{{ url('activity-log-list') }}" method="GET">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            {!! Form::text('start_date', ($start_date ?? null), ['class' => 'form-control customDatepicker','placeholder'=>__('index.start_date'),'autocomplete'=>"off"]) !!}
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            {!! Form::text('end_date', ($end_date ?? null), ['class' => 'form-control customDatepicker','placeholder'=> __('index.end_date'),'autocomplete'=>"off"]) !!}
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <select name="user" class="form-control select2" id="customer">
                                <option value="">@lang('index.select_admin_or_agent')</option>
                                @foreach($all_users as $user)
                                    <option {{ isset($user_id) && $user_id == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <select name="activity_type" class="form-control select2" id="agent">
                                <option value="">@lang('index.select_type')</option>
                                <option {{ isset($type) && $type == "created" ? 'selected' : '' }} value="created">@lang('index.create')</option>
                                <option {{ isset($type) && $type == "commented" ? 'selected' : '' }} value="commented">@lang('index.comment')</option>
                                <option {{ isset($type) && $type == "mentioned" ? 'selected' : '' }} value="mentioned">@lang('index.mentioned')</option>
                                <option {{ isset($type) && $type == "close" ? 'selected' : '' }} value="close">@lang('index.close')</option>
                                <option {{ isset($type) && $type == "reopen" ? 'selected' : '' }} value="reopen">@lang('index.reopen')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                        <div class="form-group">
                            <button type="submit" class="btn bg-blue-btn w-100 h-40" id="go">@lang('index.search')</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <!-- End Search -->
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1 text-center">@lang('index.sn')</th>
                            <th class="ir_w_3">@lang('index.type')</th>
                            <th class="ir_w_3">@lang('index.product_category')</th>
                            <th class="ir_w_18">@lang('index.activity')</th>
                            <th class="ir_w_3">@lang('index.created_by')</th>
                            <th class="ir_w_3">@lang('index.created_at')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = sizeof($obj);?>
                        @foreach($obj as $value)
                            <tr>
                                <td class="ir_txt_center">{{ $count-- }}</td>
                                <td>{{ ucfirst($value->type) ?? "" }}</td>
                                <td>{{ $value->ticket->getProductCategory->title ?? "N/A"  }}</td>
                                <td>{{ $value->activity ?? "" }}</td>
                                <td>{{ $value->getActivityUser->full_name ?? "" }}</td>
                                <td>
                                    {{ isset($value->created_at)? date(siteSetting()->date_format, strtotime($value->created_at)) :"" }}
                                    <br>
                                    {{ isset($value->created_at)? date('h:i:s a', strtotime($value->created_at)) :"" }}
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
