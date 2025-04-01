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
                        @lang('index.site_setting')
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.site_setting')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                {!! Form::model(isset($data) && $data?$data:'', ['method' => 'POST', 'enctype'=>'multipart/form-data','id' => 'common-form', 'url' => ['update-site-setting']]) !!}
                @csrf
                @method('PUT')
                <div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.company_name') {!! starSign() !!}</label>
                                {!! Form::text('company_name', null, ['class' => 'form-control','placeholder'=>__('index.company_name')]) !!}
                            </div>
                            @if ($errors->has('company_name'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('company_name') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.site_title') {!! starSign() !!}</label>
                                {!! Form::text('title', null, ['class' => 'form-control','placeholder'=>__('index.site_title')]) !!}
                            </div>
                            @if ($errors->has('title'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('title') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.email') {!! starSign() !!}</label>
                                {!! Form::text('email', null, ['class' => 'form-control','placeholder'=>__('index.email')]) !!}
                            </div>
                            @if ($errors->has('email'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.phone') {!! starSign() !!}</label>
                                {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>__('index.phone')]) !!}
                            </div>
                            @if ($errors->has('phone'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </div>
                       
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.skype') {!! starSign() !!}</label>
                                {!! Form::text('skype', null, ['class' => 'form-control','placeholder'=>__('index.skype')]) !!}
                            </div>
                            @if ($errors->has('skype'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('skype') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2 custom_table">
                                <label>@lang('index.logo') (250px X 45px, jpg,jpeg,png, 2MB) {!! starSign() !!}</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="logo" class="form-control file_checker_global" data-this_file_size_limit="2"  accept=".jpg,.jpeg,.png">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset($data->logo) && file_exists($data->logo))
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_logo viw_file">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            @if (Session::has('logo_error'))
                               <span class="text-danger">{{ Session::get('logo_error') }}</span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2 custom_table">
                                <label>@lang('index.icon') (Max: 100px X 100px, ico, 1MB) {!! starSign() !!}</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="icon" class="form-control file_checker_global" data-this_file_size_limit="1"  accept=".ico">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset($data->icon) && file_exists($data->icon))
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_modal_icon viw_file"   >
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @if (Session::has('icon_error'))
                               <span class="text-danger">{{ Session::get('icon_error') }}</span>
                            @endif
                        </div>
                         
                        
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.date_format'){!! starSign() !!}</label>
                                {!! Form::select('date_format', ['d/m/Y'=>'d/m/Y', 'm/d/Y'=>'m/d/Y', 'Y/m/d'=>'Y/m/d'], null, ['class'=>'form-control select2', 'id' => 'date_format', 'placeholder'=>__('index.select_date_format')]) !!}
                                @if ($errors->has('date_format'))
                                    <span class="text-danger" role="alert">
                                        {{ $errors->first('date_format') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.timezone'){!! starSign() !!}</label>
                                <select name="timezone"  class="form-control select2" id="timezone">
                                    @foreach ($time_zones as $timezone)
                                        <option value="{{ $timezone->zone_name ?? 'Asia/Dhaka' }}" {{ isset($data->timezone) && $data->timezone == $timezone->zone_name ? 'selected' : '' }}>{{ $timezone->zone_name ?? 'Asia/Dhaka' }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('timezone'))
                                    <span class="text-danger" role="alert">
                                        {{ $errors->first('timezone') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label class="d-flex me-2">
                                    @lang('index.banner_text') {!! starSign() !!}
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.banner_tooltip_text')">
                                    <iconify-icon icon="ri:question-fill" width="22"></iconify-icon> 
                                </span>
                        
                                </label>
                                {!! Form::text('banner_text', null, ['class' => 'form-control','placeholder'=>__('index.banner_text')]) !!}
                            </div>
                            @if ($errors->has('banner_text'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('banner_text') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.banner_slogan') {!! starSign() !!}</label>
                                {!! Form::text('banner_slogan', null, ['class' => 'form-control','placeholder'=>__('index.banner_slogan')]) !!}
                            </div>
                            @if ($errors->has('banner_slogan'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('banner_slogan') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.address') {!! starSign() !!}</label>
                                <textarea name="address" id="address" class="form-control address_height" placeholder="@lang('index.address')">{{ $data->address ?? '' }}</textarea>
                            </div>
                            @if ($errors->has('address'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.g_map_url')</label>
                                {!! Form::text('g_map_url', null, ['class' => 'form-control','placeholder'=>__('index.g_map_url')]) !!}
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.footer_text') {!! starSign() !!}</label>
                                {!! Form::text('footer_text', null, ['class' => 'form-control','placeholder'=>__('index.footer_text')]) !!}
                            </div>
                            @if ($errors->has('footer_text'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('footer_text') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.footer') {!! starSign() !!}</label>
                                {!! Form::text('footer', null, ['class' => 'form-control','placeholder'=>__('index.footer')]) !!}
                            </div>
                            @if ($errors->has('footer'))
                                <span class="text-danger" role="alert">
                                    {{ $errors->first('footer') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.website_url')</label>
                                {!! Form::text('website_url', null, ['class' => 'form-control','placeholder'=>__('index.website_url')]) !!}
                            </div>
                            @error('website_url')
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph text-danger">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.facebook_url')</label>
                                {!! Form::url('facebook_url', null, ['class' => 'form-control','placeholder'=>__('index.facebook_url')]) !!}
                            </div>
                            @error('facebook_url')
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph text-danger">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>

                       
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.twitter_url')</label>
                                {!! Form::url('twitter_url', null, ['class' => 'form-control','placeholder'=>__('index.twitter_url')]) !!}
                            </div>
                            @error('twitter_url')
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph text-danger">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.dribble_url')</label>
                                {!! Form::url('dribble_url', null, ['class' => 'form-control','placeholder'=>__('index.dribble_url')]) !!}
                            </div>
                            @error('dribble_url')
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph text-danger">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.instagram_url')</label>
                                {!! Form::url('instagram_url', null, ['class' => 'form-control','placeholder'=>__('index.instagram_url')]) !!}
                            </div>
                            @error('instagram_url')
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph text-danger">
                                    {{ $message }}
                                </span>
                            </div>
                            @enderror
                        </div>
                        

                        <div class="12">
                            <div class="form-group mb-2">
                                <label>@lang('index.support_policy') {!! starSign() !!}</label>
                                <textarea id="support_policy" name="support_policy" class="has-validation" required>{{ isset($data->support_policy)? $data->support_policy : null }}</textarea>
                            </div>
                            @error('support_policy')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.language') (@lang('index.frontend')){!! starSign() !!}</label>
                                <select class="form-control select2" name="language" id="language">
                                    <option value="">@lang('index.select_language')</option>
                                    @foreach (languageFolders() as $dir)
                                    <option <?php echo isset($data->language) && $data->language==$dir?'selected':''?> value="{{ $dir }}">{{ lanFullName($dir) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('language'))
                                    <span class="text-danger" role="alert">
                                        {{ $errors->first('language') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group mb-2">
                                <label>@lang('index.is_captcha_enable'){!! starSign() !!}</label>
                                <select class="form-control select2" name="is_captcha" id="is_captcha">
                                    <option value="">@lang('index.select')</option>
                                    <option value="1" {{ isset($data->is_captcha) && $data->is_captcha == 1 ? 'selected' : '' }}>@lang('index.yes')</option>
                                    <option value="0" {{ isset($data->is_captcha) && $data->is_captcha == 0 ? 'selected' : '' }}>@lang('index.no')</option>
                                </select>
                                @if ($errors->has('is_captcha'))
                                    <span class="text-danger" role="alert">
                                        {{ $errors->first('is_captcha') }}
                                    </span>
                                @endif
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
                            <a class="btn custom_header_btn w-100" href="{{ route('dashboard') }}">
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
    <div class="modal fade" id="logo">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('index.logo')</h4>
                    <button type="button" class="btn-close close_modal_logo" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ (isset($data->logo) && file_exists($data->logo))? asset($data->logo) :'' }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- logo Icon-->
    <div class="modal fade" id="icon">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('index.icon')</h4>
                    <button type="button" class="btn-close close_modal_icon" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ (isset($data->icon) && file_exists($data->icon))? asset($data->icon) :'' }}" alt="" class="img-responsive" height="20" width="20">
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/site-setting.js?var=2.2') }}"></script>
@endpush
