@extends('layouts.app')

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
                        @lang('index.our_services_setting')
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.our_services_setting')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <form action="{{ route('update-our-services-setting') }}" method="POST" id= 'common-form' enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-2">
                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label>@lang('index.page_title')</label>
                                <input type="text" name="service_page_title" class="form-control" placeholder="@lang('index.page_title')" value="{{ ourService()['service_page_title'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.section_one_text')</label>
                                <input type="text" name="sr_section_one_text" class="form-control" placeholder="@lang('index.section_one_text')" value="{{ ourService()['sr_section_one_text'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.section_one_image') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="section_one_image" class="form-control" accept=".jpg,.jpeg,.png">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['section_one_image']) && ourService()['section_one_image'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['section_one_image'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.section_one_content')</label>
                                <textarea name="sr_section_one_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.section_one_content')">{{ ourService()['sr_section_one_content'] ?? '' }}</textarea>
                                @error('sr_section_one_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.section_two_text')</label>
                                <input type="text" name="sr_section_two_text" class="form-control" placeholder="@lang('index.section_two_text')" value="{{ ourService()['sr_section_two_text'] ?? '' }}">
                            </div>
                        </div>
                        {{--Section Two Image--}}
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.section_two_image') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="section_two_image" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['section_two_image']) && ourService()['section_two_image'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['section_two_image'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.section_two_content')</label>
                                <textarea name="sr_section_two_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.section_two_content')">{{ ourService()['sr_section_two_content'] ?? '' }}</textarea>
                                @error('sr_section_two_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.section_three_text')</label>
                                <input type="text" name="sr_section_three_text" class="form-control" placeholder="@lang('index.section_three_text')" value="{{ ourService()['sr_section_three_text'] ?? '' }}">
                            </div>
                        </div>
                        {{--Section Three Image--}}
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.section_three_image') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="section_three_image" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['section_three_image']) && ourService()['section_three_image'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['section_three_image'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.section_three_content')</label>
                                <textarea name="sr_section_three_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.section_three_content')">{{ ourService()['sr_section_three_content'] ?? '' }}</textarea>
                                @error('sr_section_three_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.section_four_text')</label>
                                <input type="text" name="sr_section_four_text" class="form-control" placeholder="@lang('index.section_four_text')" value="{{ ourService()['sr_section_four_text'] ?? '' }}">
                            </div>
                        </div>
                        {{--Section Four Image--}}
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.section_four_image') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="section_four_image" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['section_four_image']) && ourService()['section_four_image'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['section_four_image'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.section_four_content')</label>
                                <textarea name="sr_section_four_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.section_four_content')">{{ ourService()['sr_section_four_content'] ?? '' }}</textarea>
                                @error('sr_section_four_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.section_five_text')</label>
                                <input type="text" name="sr_section_five_text" class="form-control" placeholder="@lang('index.section_five_text')" value="{{ ourService()['sr_section_five_text'] ?? '' }}">
                            </div>
                        </div>
                        {{--    Section Five Image--}}
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.section_five_image') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="section_five_image" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['section_five_image']) && ourService()['section_five_image'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['section_five_image'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.section_five_content')</label>
                                <textarea name="sr_section_five_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.section_five_content')">{{ ourService()['sr_section_five_content'] ?? '' }}</textarea>
                                @error('sr_section_five_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.section_six_text')</label>
                                <input type="text" name="sr_section_six_text" class="form-control" placeholder="@lang('index.section_six_text')" value="{{ ourService()['sr_section_six_text'] ?? '' }}">
                            </div>
                        </div>
                        {{--Section Six Image--}}
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.section_six_image') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="section_six_image" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['section_six_image']) && ourService()['section_six_image'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['section_six_image'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.section_six_content')</label>
                                <textarea name="sr_section_six_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.section_six_content')">{{ ourService()['sr_section_six_content'] ?? '' }}</textarea>
                                @error('sr_section_six_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                       
                    </div>
                    <label for="">@lang('index.core_feature')</label>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.section_title')</label>
                                <input type="text" name="feature_section_title" class="form-control" placeholder="@lang('index.section_title')" value="{{ ourService()['feature_section_title'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label>@lang('index.section_sub_title')</label>
                                <input type="text" name="feature_section_sub_title" class="form-control" placeholder="@lang('index.section_sub_title')" value="{{ ourService()['feature_section_sub_title'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    {{--Feature One--}}
                    <label for="">@lang('index.box_one_content')</label>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.title')</label>
                                <input type="text" name="sr_box_one_title" class="form-control" placeholder="@lang('index.title')" value="{{ ourService()['sr_box_one_title'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.icon') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="box_one_icon" class="form-control" accept=".jpg,.jpeg,.png">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['box_one_icon']) && ourService()['box_one_icon'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['box_one_icon'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.content')</label>
                                <textarea name="sr_box_one_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.content')">{{ ourService()['sr_box_one_content'] ?? '' }}</textarea>
                                @error('sr_box_one_content')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{--Feature Two--}}
                    <label for="">@lang('index.box_two_content')</label>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.title')</label>
                                <input type="text" name="sr_box_two_title" class="form-control" placeholder="@lang('index.title')" value="{{ ourService()['sr_box_two_title'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.icon') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="box_two_icon" class="form-control" accept=".jpg,.jpeg,.png">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['box_two_icon']) && ourService()['box_two_icon'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['box_two_icon'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.content')</label>
                                <textarea name="sr_box_two_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.content')">{{ ourService()['sr_box_two_content'] ?? '' }}</textarea>
                                @error('sr_box_two_content')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{--Feature Three--}}
                    <label for="">@lang('index.box_three_content')</label>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.title')</label>
                                <input type="text" name="sr_box_three_title" class="form-control" placeholder="@lang('index.title')" value="{{ ourService()['sr_box_three_title'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.icon') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="box_three_icon" class="form-control" accept=".jpg,.jpeg,.png">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['box_three_icon']) && ourService()['box_three_icon'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['box_three_icon'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.content')</label>
                                <textarea name="sr_box_three_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.content')">{{ ourService()['sr_box_three_content'] ?? '' }}</textarea>
                                @error('sr_box_three_content')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{--Feature Four--}}
                    <label for="">@lang('index.box_four_content')</label>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>@lang('index.title')</label>
                                <input type="text" name="sr_box_four_title" class="form-control" placeholder="@lang('index.title')" value="{{ ourService()['sr_box_four_title'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.icon') (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="box_four_icon" class="form-control" accept=".jpg,.jpeg,.png">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(ourService()['box_four_icon']) && ourService()['box_four_icon'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ ourService()['box_four_icon'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-12 mt-2">
                            <div class="form-group">
                                <label>@lang('index.content')</label>
                                <textarea name="sr_box_four_content"  cols="30" rows="10" class="form-control" placeholder="@lang('index.content')">{{ ourService()['sr_box_four_content'] ?? '' }}</textarea>
                                @error('sr_box_four_content')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
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
                </form>
            </div>
        </div>
    </section>

    <!-- logo Modal-->
    <div class="modal fade" id="logo">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.service_image')</h4>
                    <button type="button" class="btn-close close_modal_logo" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body text-center" id="image_body">

                </div>
            </div>
        </div>
    </div>


@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/site-setting.js?var=2.2') }}"></script>
@endpush
