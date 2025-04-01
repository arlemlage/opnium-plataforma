@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css?var=2.2') }}">
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
                    @lang('index.edit_profile')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.profile'), 'secondSection' => __('index.edit_profile')])
        </div>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
           <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data" id="common-form">
           	    @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.first_name'){!! starSign() !!}</label>
                            
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ Auth::user()->first_name }}" placeholder="@lang('index.first_name')">
                        </div>
                        @if ($errors->has('first_name'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('first_name') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.last_name') {!! starSign() !!}</label>

                            <input type="text" name="last_name" class="form-control"
                                   value="{{ Auth::user()->last_name }}" placeholder="@lang('index.last_name')">
                        </div>
                        @if ($errors->has('last_name'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('last_name') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.phone_number') {!! starSign() !!}</label>
                            <input tabindex="1" type="text" name="mobile" class="form-control"  value="{{ Auth::user()->mobile }}" placeholder="@lang('index.phone_number')">
                        </div>
                        @if ($errors->has('mobile'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('mobile') }}
                            </span>
                        @endif
                        @if(Session::has('mobile_error'))
                        <span class="error_alert text-danger" role="alert">
                            {{ Session::get('mobile_error') }}
                        </span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label>@lang('index.email'){!! starSign() !!}</label>
                            
                            <input tabindex="1" type="text" name="email" class="form-control"
                                   placeholder="@lang('index.email')"
                                   value="{{ Session::get('email') ?? old('email') ?? Auth::user()->email }}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                        @if(Session::has('email_error'))
                        <span class="error_alert text-danger" role="alert">
                            {{ Session::get('email_error') }}
                        </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group custom_table">
                            <label>@lang('index.photo') (100px X 100px, jpeg,jpg,png, 1MB)</label>
                            <table>
                                <tr>
                                    <td>
                                        <input tabindex="1" type="file" name="image" accept="image/jpeg,image/jpg,image/png" class="form-control" id="profile_photo">
                                        <input type="hidden" id="image_url" name="image_url" value="">
                                    </td>
                                    <td class="w_1">
                                        <div class="d-flex">
                                            @if(isset(Auth::user()->image) && file_exists(Auth::user()->image))
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_common_image_modal viw_file" id="image_block"><iconify-icon icon="solar:eye-bold" width="22"></iconify-icon></button>
                                            @endif
                                            <button type="button" id="preview_block" class="btn btn-md ms-2 pull-right fit-content btn-success-edited viw_file open_preview_image displayNone">
                                                <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            @if(Session::has('photo_error'))
                            <span class="error_alert text-danger" role="alert">
                                {{ Session::get('photo_error') }}
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-sm-6 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100" id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('user-home') }}">
                                @lang('index.back')
                            </a>
                        </div>
                </div>
                
           </form>
        </div>
    </div>
</section>

<div class="modal fade" id="commonImage">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">@lang('index.photo')</h4>
                  <button type="button" class="btn-close close_common_image_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
              </div>
            <div class="modal-body text-center">
                <img src="{{ asset(Auth::user()->image) }}" alt="" class="img-responsive" height="200" width="200">
            </div>
        </div>
    </div>
</div>

  <div class="modal fade" id="crop_image">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('index.photo')</h4>
                <button type="button" class="btn-close close_modal_crop" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img class="img-fluid displayNone"/>
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
                <button type="button" class="btn-close close_preview_image" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body text-center pb-3">
                <img src="" alt="" class="img-responsive w-100" id="crop-preview">
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
    <script src="{{ asset('frequent_changing/crop/cropper.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/edit_profile.js?var=2.2') }}"></script>
@endpush
