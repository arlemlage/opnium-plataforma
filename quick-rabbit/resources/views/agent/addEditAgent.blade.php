@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css') }}">
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper d-none ajax_data_alert_show_hide">
            <div class="alert alert-{{ Session::get('type') ?? 'info' }} alert-dismissible fade show">
                <div class="alert-body">
                    <p><iconify-icon icon="{{ Session::get('sign') ?? 'material-symbols:check' }}"
                            width="22"></iconify-icon><span class="ajax_data_alert"></span></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ isset($obj) ? __('index.edit_agent') : __('index.add_agent') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.agent'),
                    'secondSection' => isset($obj) ? __('index.edit_agent') : __('index.add_agent'),
                ])
            </div>
            <div class="row justify-content-start">
                <div class="col-12 p-0 justify-content-start">
                    <p>@lang('index.please_click') <a href="{{ route('chat-sequence-setting') }}"
                            class="ds_anchor color-red font-w-500">@lang('index.here')</a> @lang('index.chat_sequence_msg')</p>
                </div>
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'files' => true,
                    'route' => ['agent.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'enctype' => 'multipart/form-data',
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <input type="hidden" id="company_name" value="{{ siteSetting()->company_name ?? '' }}">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label for="">@lang('index.role'){!! starSign() !!}</label> 
                                <select name="permission_role" id="permission_role" class="form-control select2">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ (isset($obj) && $obj->permission_role == $role->id) || old('permission_role') == $role->id ? 'selected' : '' }}>
                                            {{ $role->title ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('permission_role'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('permission_role') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.first_name') {!! starSign() !!}</label>
                                {!! Form::text('first_name', null, [
                                    'class' => 'form-control first_name',
                                    'placeholder' => __('index.first_name'),
                                ]) !!}
                            </div>
                            @if ($errors->has('first_name'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('first_name') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.last_name') {!! starSign() !!}</label>
                                {!! Form::text('last_name', null, ['class' => 'form-control last_name', 'placeholder' => __('index.last_name')]) !!}
                            </div>
                            @if ($errors->has('last_name'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('last_name') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.email') {!! starSign() !!}</label>
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('index.email')]) !!}
                            </div>
                            @if ($errors->has('email'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            @if (Session::has('email_error'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ Session::get('email_error') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.mobile') {!! starSign() !!}</label>
                                {!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __('index.mobile')]) !!}
                            </div>
                            @if ($errors->has('mobile'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('mobile') }}
                                </span>
                            @endif
                            @if (Session::has('mobile_error'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ Session::get('mobile_error') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.photo') (100px X 100px, jpeg,jpg,png, 1MB)</label>
                                <table class="w-100">
                                    <tr>
                                        <td>
                                            <input tabindex="1" type="file" name="image"
                                                accept="image/jpeg,image/png,image/jpg" class="form-control" value=""
                                                id="agent_image">
                                            <input type="hidden" id="image_url" name="image_url" value="">
                                        </td>
                                        <td class="w_1">
                                            @if (isset($obj->image) && file_exists($obj->image))
                                                <button type="button" id="image_block"
                                                    class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_modal_photo viw_file">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                            <button type="button" id="preview_block"
                                                class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_preview_image displayNone viw_file">
                                                <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                @if (Session::has('photo_error'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ Session::get('photo_error') }}
                                    </span>
                                @endif
                            </div>

                        </div>
                        @if (appTheme() == 'multiple')
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-group">
                                    <label class="d-flex me-2">@lang('index.product_category')
                                        <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('index.product_cat_tooltip') }}">
                                            <iconify-icon icon="ri:question-fill" width="22"></iconify-icon>
                                        </span>

                                    </label>
                                    {!! Form::select(
                                        'product_cat_ids[]',
                                        $product_category,
                                        isset($obj->product_cat_ids) ? explode(',', $obj->product_cat_ids) : null,
                                        [
                                            'class' => 'form-control select2 h-40',
                                            'id' => 'product_cat_ids',
                                            'data-placeholder' => __('index.select_product_category'),
                                            'multiple',
                                        ],
                                    ) !!}
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="product_cat_ids"
                                value="{{ array_key_first($product_category->toArray()) }}">
                        @endif

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.department')</label>
                                <select name="department_id" class="from-control select2" id="department_id">
                                    <option value="">@lang('index.select')</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ (isset($obj) && $obj->department_id == $department->id) || old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.status') {!! starSign() !!}</label>
                                {!! Form::select(
                                    'status',
                                    ['1' => __('index.active'), '2' => __('index.in_active')],
                                    isset($obj->status) ? $obj->status : null,
                                    ['class' => 'form-control select2', 'id' => 'status'],
                                ) !!}
                            </div>
                            @if ($errors->has('status'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('status') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.signature')</label>
                                {!! Form::textarea('signature', isset($obj->signature) ? $obj->signature : null, [
                                    'class' => 'form-control signature',
                                    'readonly',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('agent.index') }}">
                                @lang('index.back')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>

    <!-- logo Modal-->
    <div class="modal fade" id="photo">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.photo')</h4>
                    <button type="button" class="btn-close close_modal_photo" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ isset($obj->image) && file_exists($obj->image) ? asset($obj->image) : '' }}"
                        alt="" id="image-view" class="img-responsive" height="100" width="100">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="crop_image">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.photo')</h4>
                    <button type="button" class="btn-close close_modal_crop" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="crop-image" class="img-fluid displayNone" />
                    </div>
                    <br>
                    <button id="crop_result" class="btn btn-sm bg-blue-btn">@lang('index.crop')</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="preview_image">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.image')</h4>
                    <button type="button" class="btn-close close_preview_image" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center pb-3">
                    <img src="" alt="" class="img-responsive w-100" id="crop-preview">
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/crop/cropper.min.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/agent.js') }}"></script>
@endpush
