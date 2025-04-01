@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css') }}">
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-4 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ isset($obj) ? __('index.edit_product_category') : __('index.add_product_category') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [                    
                    'col' => '8',
                    'firstSection' => __('index.product_category'),
                    'secondSection' => isset($obj)
                        ? __('index.edit_product_category')
                        : __('index.add_product_category'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                {!! Form::model(isset($obj) && $obj ? $obj : '', [
                    'method' => isset($obj) && $obj ? 'PATCH' : 'POST',
                    'enctype' => 'multipart/form-data',
                    'route' => ['product-category.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'class' => 'needs-validation',
                    'novalidate',
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.title') {!! starSign() !!}</label>
                                {!! Form::text('title', null, [
                                    'class' => 'form-control',
                                    'id' => 'title',
                                    'placeholder' => __('index.title'),
                                    'required',
                                ]) !!}
                                <div class="invalid-feedback">
                                    @lang('index.title_field_required')
                                </div>
                            </div>
                            @if ($errors->has('title'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('title') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.product_code') {!! starSign() !!}</label>
                                {!! Form::text('product_code', null, [
                                    'class' => 'form-control',
                                    'id' => 'product_code',
                                    'placeholder' => __('index.product_code'),
                                    'required',
                                    'readonly',
                                ]) !!}
                                <div class="invalid-feedback">
                                    @lang('index.product_code_required')
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <div>
                                    <label>@lang('index.photo_thumb')</label>
                                    <small class="text-info">80px X 80px,jpeg,jpg,png,1MB</small>
                                </div>
                                <table class="w-100">
                                    <tr>
                                        <td>
                                            <input type="file" name="photo_thumb"
                                                class="form-control file_checker_global" data-this_file_size_limit="1"
                                                accept="image/*">
                                            <input type="hidden" id="image_url" name="image_url" value="">
                                        </td>
                                        <td class="w_1">
                                            @if (isset($obj->photo_thumb) && file_exists($obj->photo_thumb))
                                                <button type="button" id="image_block"
                                                    class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_modal_photo">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                            <button type="button" id="preview_block"
                                                class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_preview_image displayNone">
                                                <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @error('photo_thumb')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            @if (Session::has('photo_thumb'))
                                <span class="text-danger">{{ Session::get('photo_thumb') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.status')</label>
                                {!! Form::select(
                                    'status',
                                    ['1' => __('index.active'), '2' => __('index.in_active')],
                                    isset($obj->status) ? $obj->status : null,
                                    ['class' => 'form-control select2', 'id' => 'status'],
                                ) !!}
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.verification') {!! starSign() !!}</label>
                                <select name="verification" id="verification" class="form-control select2">
                                    <option value="0" {{ isset($obj) && $obj->verification == 0 ? 'selected' : '' }}>
                                        None</option>
                                    <option value="1" {{ isset($obj) && $obj->verification == 1 ? 'selected' : '' }}>
                                        Envato</option>
                                </select>
                                <div class="invalid-feedback">
                                    @lang('index.verification_required')
                                </div>
                            </div>
                            @if ($errors->has('verification'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('verification') }}
                                </span>
                            @endif
                        </div>



                        <div
                            class="col-lg-4 col-md-6 col-sm-6 col-12 mb-2 envato_product_code_field {{ isset($obj) && $obj->verification == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <label>@lang('index.envato_product_code') {!! starSign() !!}</label>
                                {!! Form::number('envato_product_code', null, [
                                    'class' => 'form-control envato_product_code',
                                    'placeholder' => __('index.envato_product_code'),
                                    isset($obj) && $obj->verification == 1 ? 'required' : '',
                                ]) !!}
                                <div class="invalid-feedback">
                                    @lang('index.envato_product_code_required')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label>@lang('index.short_description')</label>
                                <textarea name="short_description" class="form-control has-validation address_height" rows="10">{{ old('short_description') ?? ($obj->short_description ?? '') }}</textarea>
                            </div>
                            @if ($errors->has('short_description'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('short_description') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label>@lang('index.description')</label>
                                <textarea id="description" name="description" class="has-validation">{{ old('description') ?? ($obj->description ?? '') }}</textarea>
                            </div>
                            @if ($errors->has('description'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('description') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('product-category.index') }}">
                                @lang('index.back')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>


    </section>

    <!-- Photo Thumb Modal-->
    @if (isset($obj))
        <div class="modal fade" id="product_photo">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">@lang('index.photo_thumb')</h4>
                        <button type="button" class="btn-close close_modal_photo" data-bs-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset($obj->photo_thumb) }}" alt="" class="img-responsive" height="80"
                            width="80">
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="crop_image">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.photo_thumb')</h4>
                    <button type="button" class="btn-close close_modal_crop" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center">
                    <div id="img-div" class="upload_demo_single"></div>
                    <button id="crop_result" class="btn btn-sm bg-blue-btn">@lang('index.crop')</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="preview_image">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.photo_thumb')</h4>
                    <button type="button" class="btn-close close_preview_image" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center pb-3">
                    <tr>
                        <td>
                            <img src="" alt="" class="img-responsive" height="300" width="350"
                                id="crop-preview">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger modal-trash displayNone">
                                <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone"
                                    width="22"></iconify-icon>
                            </button>
                        </td>
                    </tr>
                </div>
            </div>
        </div>
    </div>


@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/bower_components/croppie/croppie.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/product_category.js') }}"></script>
@endpush
