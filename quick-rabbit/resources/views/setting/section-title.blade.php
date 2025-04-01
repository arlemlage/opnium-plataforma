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
                        @lang('index.section_title')
                    </h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.section_title')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <form action="{{ route('section-title-update') }}" method="POST" id='common-form'>
                    @csrf
                    @method('PUT')
                    @foreach($data as $key => $section)
                        <label for="">{{ $section['section'] }}</label>
                        <input type="hidden" name="section[{{ $key }}]" value="{{ $section['section'] }}">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-group">
                                    <label>@lang('index.section_title')</label>
                                    <input type="text" name="section_title[{{ $key }}]" class="form-control" placeholder="@lang('index.section_title')" value="{{ $section['title'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-group">
                                    <label>@lang('index.section_sub_title')</label>
                                    <input type="text" name="section_sub_title[{{ $key }}]" class="form-control" placeholder="@lang('index.section_sub_title')" value="{{ $section['sub-title'] ?? '' }}">
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
