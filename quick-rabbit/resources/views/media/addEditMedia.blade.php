@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/custom_v1.css?var=2.2') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css?var=2.2') }}">
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ isset($obj) ? __('index.edit_media') : __('index.add_media') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.media'),
                    'secondSection' => isset($obj) ? __('index.edit_media') : __('index.add_media'),
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
                    'route' => ['media.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.title') {!! starSign() !!}</label>
                                {!! Form::text('title', null, ['class' => 'form-control title', 'placeholder' => __('index.title')]) !!}
                            </div>
                            @if ($errors->has('title'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('title') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.group') {!! starSign() !!}</label>
                                <select class="form-control select2" id="group" name="group">
                                    <option value="">@lang('index.select')</option>
                                    <option value="blog" {{ isset($obj) && $obj->group == 'blog' ? 'selected' : '' }}>
                                        @lang('index.blog')</option>
                                    <option value="page" {{ isset($obj) && $obj->group == 'page' ? 'selected' : '' }}>
                                        @lang('index.page')</option>
                                    @foreach ($product_category as $value)
                                        <option value="{{ $value->id }}"
                                            {{ isset($obj) && $obj->group == $value->id ? 'selected' : '' }}>
                                            {{ $value->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('group'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('group') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.media_file') {!! starSign() !!}</label>
                                <table class="margin_0">
                                    <tr class="bg-white">
                                        <td class="ir_w_37">
                                            <button type="button"
                                                class="btn bg-blue-btn add_file nowrap">@lang('index.select_file')</button>
                                        </td>

                                        @isset($obj)
                                            <td class="">
                                                <a href="#image_viewer" class="btn bg-blue-btn viw_file popup-with-move-anim">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>&nbsp;
                                                </a>
                                                <div id="image_viewer" class="zoom-anim-dialog mfp-hide mfp-custom-modal">
                                                    <img id="set_image_src"
                                                        src="{{ isset($obj) ? asset($obj->media_path) : '' }}"
                                                        class="img-fluid">
                                                </div>
                                            </td>
                                        @else
                                            <td class="viw_file_td">
                                                <a href="#image_viewer" class="btn bg-blue-btn viw_file popup-with-move-anim">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>&nbsp;
                                                </a>
                                                <div id="image_viewer" class="zoom-anim-dialog mfp-hide mfp-custom-modal">
                                                    <img id="set_image_src"
                                                        src="{{ isset($obj) ? asset($obj->media_path) : '' }}"
                                                        class="img-fluid">
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    </table>

                                    <input type="hidden" name="media_path" id="media_path" value="{{ old('media_path') }}">
                                    <input type="hidden" name="media_path_old" id="media_path_old" value="">

                                    @if ($errors->has('media_path'))
                                        <span class="error_alert text-danger" role="alert">
                                            {{ $errors->first('media_path') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-12 col-md-3 mb-2">
                                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                                    id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                            </div>
                            <div class="col-sm-12 col-md-3 mb-2">
                                <a class="btn custom_header_btn w-100" href="{{ route('media.index') }}">
                                    @lang('index.back')
                                </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <img class="img-fluid preview-img" src="" alt="">
            </div>
        </section>

        <!-- Add Media Modal-->
        <div class="modal fade" id="add_media_file">
            <div class="modal-dialog mediaUploadModal modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="myModalLabel">
                            <h4>{{ __('index.media_upload') }}</h4>
                            <p>{{ __('index.media_upload_desc') }}</p>
                        </div>
                        <button type="button" class="btn-close close_modal" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.2987 5.70997C17.9087 5.31997 17.2787 5.31997 16.8887 5.70997L11.9988 10.59L7.10875 5.69997C6.71875 5.30997 6.08875 5.30997 5.69875 5.69997C5.30875 6.08997 5.30875 6.71997 5.69875 7.10997L10.5888 12L5.69875 16.89C5.30875 17.28 5.30875 17.91 5.69875 18.3C6.08875 18.69 6.71875 18.69 7.10875 18.3L11.9988 13.41L16.8887 18.3C17.2787 18.69 17.9087 18.69 18.2987 18.3C18.6887 17.91 18.6887 17.28 18.2987 16.89L13.4087 12L18.2987 7.10997C18.6787 6.72997 18.6787 6.08997 18.2987 5.70997Z"
                                        fill="#0B0B0B" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-wrapper">

                            <div class="img-container displayNone">
                                <img class="img-fluid displayNone" />
                            </div>
                            <div class="upload-area mb-4">
                                <div class="text-center py-5">
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1015_1146)">
                                        <path d="M33.4432 3.12073H14.1758V11.1108H37.5582V7.23415C37.5582 4.96579 35.7122 3.12073 33.4432 3.12073Z" fill="#CED9F9"/>
                                        <path d="M22.5352 12.3403H0V4.92636C0 2.20972 2.21068 0 4.92828 0H12.1336C12.8497 0 13.5396 0.150925 14.1664 0.434509C15.0418 0.828964 15.7939 1.47913 16.3213 2.3286L22.5352 12.3403Z" fill="#1640C1"/>
                                        <path d="M42 14.0001V37.8815C42 40.1527 40.1511 42 37.8789 42H4.12111C1.84891 42 0 40.1527 0 37.8815V9.88062H37.8789C40.1511 9.88062 42 11.7286 42 14.0001Z" fill="#2354E6"/>
                                        <path d="M42 14.0001V37.8815C42 40.1527 40.1511 42 37.8789 42H21V9.88062H37.8789C40.1511 9.88062 42 11.7286 42 14.0001Z" fill="#1849D6"/>
                                        <path d="M32.049 25.9398C32.049 32.0322 27.0928 36.9887 21.0011 36.9887C14.9093 36.9887 9.95312 32.0322 9.95312 25.9398C9.95312 19.8483 14.9093 14.8918 21.0011 14.8918C27.0928 14.8918 32.049 19.8483 32.049 25.9398Z" fill="#E7ECFC"/>
                                        <path d="M32.0479 25.9398C32.0479 32.0322 27.0918 36.9887 21 36.9887V14.8918C27.0918 14.8918 32.0479 19.8483 32.0479 25.9398Z" fill="#CED9F9"/>
                                        <path d="M24.5593 26.0753C24.3289 26.2704 24.0466 26.3656 23.7668 26.3656C23.4166 26.3656 23.0686 26.2173 22.8251 25.9282L22.2287 25.2213V29.8494C22.2287 30.5287 21.6776 31.0799 20.9983 31.0799C20.3189 31.0799 19.7678 30.5287 19.7678 29.8494V25.2213L19.1715 25.9282C18.7325 26.4476 17.9567 26.514 17.4373 26.0753C16.9182 25.6373 16.8515 24.8612 17.2896 24.3418L19.7252 21.4543C20.0427 21.0788 20.5061 20.8628 20.9983 20.8628C21.4905 20.8628 21.9538 21.0788 22.2714 21.4543L24.707 24.3418C25.145 24.8612 25.0784 25.6373 24.5593 26.0753Z" fill="#6C8DEF"/>
                                        <path d="M24.561 26.0753C24.3306 26.2704 24.0483 26.3656 23.7686 26.3656C23.4183 26.3656 23.0703 26.2173 22.8268 25.9282L22.2305 25.2213V29.8494C22.2305 30.5287 21.6793 31.0799 21 31.0799V20.8628C21.4922 20.8628 21.9555 21.0788 22.2731 21.4543L24.7087 24.3418C25.1467 24.8612 25.0801 25.6373 24.561 26.0753Z" fill="#3B67E9"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_1015_1146">
                                        <rect width="42" height="42" fill="white"/>
                                        </clipPath>
                                        </defs>
                                        </svg>
                                        
                                  <p class="mb-2">Drag your file(s) to start uploading</p>
                                  <p class="text-muted small mb-3">OR</p>
                                  <button id="browse-files" class="btn btn-primary">Browse files</button>
                                </div>
                            </div>
                            <p class="media_upload_helper_text">Only support .jpg, .png and .svg and zip files</p>
                            <div class="d-flex mt-3">
                                <div>
                                    <input type="file" class="file_checker_global" data-this_file_size_limit="2"
                                        id="upload" hidden>
                                </div>
                            </div>

                            <div class="table-box">
                                <div class="row mt-2 justify-content-end">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <button type="button"
                                            class="cancel_button w-100 close_modal">@lang('index.cancel')</button>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <button type="button"
                                            class="submit_btn w-100 upload-result btn-cropper-done close_modal">@lang('index.submit')</button>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @push('js')
        <link rel="stylesheet" href="{{ asset('frequent_changing/js/magnific-popup.css?var=2.2') }}">
        <script src="{{ asset('frequent_changing/js/jquery.magnific-popup.min.js?var=2.2') }}"></script>
        <script src="{{ asset('frequent_changing/crop/cropper.min.js?var=2.2') }}"></script>
        <script src="{{ asset('frequent_changing/js/media.js?var=2.2') }}"></script>
    @endpush
