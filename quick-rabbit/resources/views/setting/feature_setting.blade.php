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
                        @lang('index.feature_setting')
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.feature_setting')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <form action="{{ route('feature-setting-update') }}" method="POST" id='common-form' enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @foreach($data as $key => $feature)
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mb-2">
                                <div class="form-group custom_table">
                                    <label>@lang('index.feature_image') <br>(30px X 30px, jpg,svg,png, 2MB)</label>
                                    <table>
                                        <tr>
                                            <td class="ds_w_99_p">
                                                <input tabindex="1" type="file" name="icon[{{ $key }}]" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                            </td>
                                            <td class="ds_w_1_p">
                                                @if(isset($feature['icon']) && $feature['icon'])
                                                    <button type="button" class="btn btn-md pull-right fit-content btn-success-edited ms-2 open_modal_feature_icon" data-img="{{ $feature['icon'] }}">
                                                        <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="old_icon[{{ $key }}]" value="{{ $feature['icon'] }}">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mb-2">
                                <div class="form-group mtb-3">
                                    <label>@lang('index.feature_title')</label>
                                    <input type="text" name="feature_title[{{ $key }}]" class="form-control" placeholder="@lang('index.feature_title')" value="{{ $feature['title'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-group mtb-3">
                                    <label>@lang('index.feature_description')</label>
                                    <textarea type="text" name="feature_description[{{ $key }}]" class="form-control" placeholder="@lang('index.feature_description')">{{ $feature['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    @endforeach



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
                    <h4 class="modal-title" id="myModalLabel">@lang('index.feature_image')</h4>
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
