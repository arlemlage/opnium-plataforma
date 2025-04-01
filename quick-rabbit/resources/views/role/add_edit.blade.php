@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">{{ $title ?? __('index.role') }}
                    </h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.role'),
                    'secondSection' => $title,
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($data) && $data ? $data : '', [
                    'method' => isset($data) && $data ? 'PATCH' : 'POST',
                    'files' => true,
                    'route' => ['role.update', isset($data->id) && $data->id ? encrypt_decrypt($data->id, 'encrypt') : ''],
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label>@lang('index.role_name') {!! starSign() !!}</label>
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('index.role_name')]) !!}
                            </div>
                            @if ($errors->has('title'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('title') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label><b>@lang('index.role_permission')</b></label>
                        </div>

                        <div class="form-group">
                            <div class="d-flex gap-2">
                                <input type="checkbox" class="form-check-input" id="select_all_role">
                            <label for="select_all_role">@lang('index.select_all')</label>
                            </div>
                        </div>

                        @foreach ($menus as $menu_key => $menu)
                        @if (appTheme() == 'multiple')
                                @if ($menu->id == 24)
                                    @continue
                                @endif
                            @endif
                            @if ($menu->title != 'User Home')
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="d-flex gap-2">
                                            <input {{ isset($data) && in_array($menu->id, $data->menu_ids) ? 'checked' : '' }}
                                            id="menu_{{ $menu->id }}"
                                            class="menu_class form-check-input check_menu_{{ $menu->id }}"
                                            data-name = "{{ $menu_key + 1 }}" data-id={{ $menu->id }} type="checkbox"
                                            value="{{ $menu->id }}">
                                            <label for="menu_{{ $menu->id }}"><b>{{ $menu->title }}</b></label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @foreach ($menu->activities as $activity_key => $activity)
                                @if (appTheme() == 'single')
                                    @if (in_array($activity->id, ['107', '108', '109', '110', '113','115']))
                                        @continue
                                    @endif
                                @endif

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <div class="d-flex gap-2">
                                            <input
                                            {{ (isset($data) && in_array($activity->id, $data->activity_ids)) || $activity->auto_select == 'Yes' ? 'checked' : '' }}
                                            id="menu_activity_{{ $activity->id }}" data-id = "{{ $menu->id }}"
                                            class="activity_class form-check-input menu_activities_{{ $menu->id }}"
                                            type="checkbox" name="activity_id[]" value="{{ $activity->id }}">
                                        <label
                                            for="menu_activity_{{ $activity->id }}">{{ $activity->activity_name }}</label>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            <span>
                                <hr class="ml-4">
                            </span>
                        @endforeach
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('role.index') }}">
                                @lang('index.back')
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
    <script src="{{ asset('frequent_changing/js/role.js?var=2.2') }}"></script>
@endpush
