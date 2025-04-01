@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/customer.css?var=2.2') }}">
@endpush

@section('content')
    <input type="hidden" value="@lang('index.phone_size_error')" id="phone_size_error">
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
                        {{ isset($obj) ? __('index.edit_customer') : __('index.add_customer') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.customer'),
                    'secondSection' => isset($obj) ? __('index.edit_customer') : __('index.add_customer'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- form start -->
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'files' => true,
                    'route' => ['customer.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'id' => 'common-form',
                    'class' => 'needs-validation',
                    'novalidate',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <input type="hidden" id="action-mode" value="{{ isset($obj) ? 'edit' : 'add' }}">
                        <input type="hidden" id="running-email" value="{{ isset($obj) ? $obj->email : '' }}">
                        <input type="hidden" id="running-mobile" value="{{ isset($obj) ? $obj->mobile : '' }}">
                        <div class="col-lg-4 col-md-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.first_name') {!! starSign() !!}</label>
                                {!! Form::text('first_name', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('index.first_name'),
                                    'required',
                                ]) !!}
                            </div>
                            @if ($errors->has('first_name'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('first_name') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.last_name') {!! starSign() !!}</label>
                                {!! Form::text('last_name', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('index.last_name'),
                                    'required',
                                ]) !!}
                            </div>
                            @if ($errors->has('last_name'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('last_name') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.email') {!! starSign() !!}</label>
                                <input tabindex="1" type="text" name="email" id="email" class="form-control"
                                    placeholder="@lang('index.email')" value="{{ old('email') ?? ($obj->email ?? '') }}"
                                    required>

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
                            <span class="error_alert text-danger email-error d-none" role="alert">

                            </span>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.mobile')</label>
                                <input tabindex="1" type="text" name="mobile" id="mobile" class="form-control"
                                    placeholder="@lang('index.mobile')" value="{{ old('mobile') ?? ($obj->mobile ?? '') }}">

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
                            <span class="error_alert text-danger mobile-error d-none" role="alert">

                            </span>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-2">
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
                    </div>

                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group custom_table">
                            <label>@lang('index.customer_notes')</label>
                            <table id="noteTable" class="mt-0 w-100">
                                <tbody>
                                    @isset($obj)
                                        @foreach ($obj->notes as $note)
                                            <tr class="bg-white mt-2">
                                                <td>
                                                    <textarea name="note[]" class="form-control tiny" rows="30">{!! $note->note ?? '' !!}</textarea>
                                                </td>
                                                <td class="align-bottom">
                                                    <span class="ml-5 remove_btn">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone"
                                                            width="22"></iconify-icon>
                                                    </span>
                                                </td>
                                            </tr>
                                            <br>
                                        @endforeach
                                    @endisset
                                </tbody>

                            </table>
                        </div>
                        <div class="row my-2">
                            <div class="form-group">
                                <button type="button"
                                    class="btn btn-sm btn-success-edited add_new_note d-flex attachment_btn">
                                    <iconify-icon icon="ph:plus-fill" width="18"></iconify-icon>
                                    <span class="ms-1">@lang('index.add_note')</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-18">
                        <div class="col-sm-6 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">
                                {!! commonSpinner() !!}@lang ('index.submit')
                            </button>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('customer.index') }}">
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
    <script src="{{ asset('frequent_changing/js/customer.js?var=2.2') }}"></script>
@endpush
