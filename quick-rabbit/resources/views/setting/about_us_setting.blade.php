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
                        @lang('index.about_us_setting')
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.about_us_setting')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <form action="{{ route('update-about-us-setting') }}" method="POST" id= 'common-form' enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6 mb-3">
                            <div class="form-group">
                                <label>@lang('index.title')</label>
                                <input type="text" name="title" class="form-control" placeholder="@lang('index.title')" value="{{ aboutUs()['title'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-12 mb-3">
                            <div class="form-group">
                                <label>@lang('index.about_us_text') {!! starSign() !!}</label>
                                <textarea name="about_us_content" id="support_policy" class="has-validation" placeholder="@lang('index.about_us_text')">{{ isset(aboutUs()['about_us_content'])? aboutUs()['about_us_content'] : null }}</textarea>
                                @error('about_us_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.about_us_image')
                                    <small>(595px X 573px, jpg,jpeg,png,svg, 2MB)</small>
                                </label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(aboutUs()['about_us_image']) && aboutUs()['about_us_image'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_image"   data-img="{{ aboutUs()['about_us_image'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.about_us_image_bottom')
                                    <small>(504px X 477px, jpg,jpeg,png,svg, 2MB)</small>
                                </label>
                                <table>
                                    <tr>
                                        <td class="ds_w_99_p">
                                            <input tabindex="1" type="file" name="about_us_image_bottom" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                        </td>
                                        <td class="ds_w_1_p">
                                            @if(isset(aboutUs()['about_us_image_bottom']) && aboutUs()['about_us_image_bottom'])
                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_image"   data-img="{{ aboutUs()['about_us_image_bottom'] }}">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h4>@lang('index.what_we_offer')</h4>
                        <div class="row">
                            <div class="col-sm-12 mb-2 col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="text" name="offer[]" class="form-control" placeholder="@lang('index.title')" value="{{ aboutUs()['offer'][0] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="text" name="offer[]" class="form-control" placeholder="@lang('index.title')" value="{{ aboutUs()['offer'][1] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="text" name="offer[]" class="form-control" placeholder="@lang('index.title')" value="{{ aboutUs()['offer'][2] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2 col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="text" name="offer[]" class="form-control" placeholder="@lang('index.title')" value="{{ aboutUs()['offer'][3] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.milestone_title')</label>
                                <input type="text" name="milestone_title" class="form-control" placeholder="@lang('index.milestone_title')" value="{{ aboutUs()['milestone_title'] ?? '' }}">
                            </div>
                        </div>

                        
                        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.milestone_title_description')</label>
                                <textarea type="text" name="milestone_title_description" class="form-control" placeholder="@lang('index.milestone_title_description')">{{ aboutUs()['milestone_title_description'] ?? '' }}</textarea>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_one')</label>
                                <input type="text" name="card_label_one" class="form-control" placeholder="@lang('index.card_label_one')" value="{{ aboutUs()['card_label_one'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_one_quantity')</label>
                                <input type="text" name="card_label_one_quantity" class="form-control" placeholder="@lang('index.card_label_one_quantity')" value="{{ aboutUs()['card_label_one_quantity'] ?? '' }}">
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_two')</label>
                                <input type="text" name="card_label_two" class="form-control" placeholder="@lang('index.card_label_two')" value="{{ aboutUs()['card_label_two'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_two_quantity')</label>
                                <input type="text" name="card_label_two_quantity" class="form-control" placeholder="@lang('index.card_label_two_quantity')" value="{{ aboutUs()['card_label_two_quantity'] ?? '' }}">
                            </div>
                        </div>
                        

                        <div class="clearfix"></div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_three')</label>
                                <input type="text" name="card_label_three" class="form-control" placeholder="@lang('index.card_label_three')" value="{{ aboutUs()['card_label_three'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_three_quantity')</label>
                                <input type="text" name="card_label_three_quantity" class="form-control" placeholder="@lang('index.card_label_three_quantity')" value="{{ aboutUs()['card_label_three_quantity'] ?? '' }}">
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_four')</label>
                                <input type="text" name="card_label_four" class="form-control" placeholder="@lang('index.card_label_four')" value="{{ aboutUs()['card_label_four'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.card_label_four_quantity')</label>
                                <input type="text" name="card_label_four_quantity" class="form-control" placeholder="@lang('index.card_label_four_quantity')" value="{{ aboutUs()['card_label_four_quantity'] ?? '' }}">
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-2">
                            <div class="form-group">
                                <label>@lang('index.our_work_area_title')</label>
                                <input type="text" name="our_work_area_title" class="form-control" placeholder="@lang('index.our_work_area_title')" value="{{ aboutUs()['our_work_area_title'] ?? '' }}">
                            </div>
                        </div>
                        <hr>
                        <div class="row add_more_div">
                            <?php
                                    $our_work_steps = aboutUs()['our_work_steps'] ?? '';
                                    $our_work_descriptions = aboutUs()['our_work_descriptions'] ?? '';
                                    $our_work_icon = aboutUs()['icon'] ?? '';
                                    $our_work_steps = explode("|||",($our_work_steps));
                                    $our_work_descriptions = explode("|||",($our_work_descriptions));
                                    $our_work_icon = explode("|||",($our_work_icon));
                                ?>
                                @foreach($our_work_steps as $key=>$vl)
                                    <div class="row">
                                        <div class="clearfix"></div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                                <div class="form-group">
                                                    <label class="step_title"> @lang('index.step')-<span class="counter_sn_step"></span> @lang('index.title')</label>
                                                    <input type="text" name="steps[]" required class="form-control" placeholder="@lang('index.step') @lang('index.title')" value="{{$vl}}">
                                                </div>
                                            </div>
                                        <input type="hidden" name="old_icon[{{ $key }}]" value="{{ $our_work_icon[$key] }}">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                            <div class="form-group custom_table">
                                                <label>@lang('index.icon') 
                                                    <small>(48px X 48px)</small>
                                                </label>
                                                <table>
                                                    <tr>
                                                        <td class="ds_w_99_p">
                                                            <input tabindex="1" type="file" name="icon[]" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                                        </td>
                                                        <td class="ds_w_1_p">
                                                            @if(isset($our_work_icon[$key]) && $our_work_icon[$key])
                                                                <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2  open_modal_feature_icon"   data-img="{{ $our_work_icon[$key] }}">
                                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                                <div class="form-group">
                                                    <label class="step_description">@lang('index.step')-<span class="counter_sn_description"></span> @lang('index.description')</label>
                                                    <textarea name="descriptions[]" required class="form-control" placeholder="@lang('index.step') @lang('index.description')">{{$our_work_descriptions[$key]}}</textarea>
                                                </div>
                                                <a class="remove_div" href="#">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon>
                                                </a>
                                            </div>
                                    </div>
                                @endforeach
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 mb-2">
                            <div class="form-group">
                                <a class="btn bg-blue-btn btn-xs add_more attachment_btn" data-step="@lang('index.step')" data-title="@lang('index.title')"  data-description="@lang('index.description')" data-icon="@lang('index.icon')" href="#">
                                    <iconify-icon icon="ph:plus-fill" width="18"></iconify-icon>@lang('index.add_more')
                                </a>
                             </div>
                       </div>

                    
                        <div class="clearfix"></div>
                    </div>


                    <div class="row mt-11">
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.view_image')</h4>
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
