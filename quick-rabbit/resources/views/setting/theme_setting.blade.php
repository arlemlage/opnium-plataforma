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
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        @lang('index.theme_setting')
                    </h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.setting'),
                    'secondSection' => __('index.site_setting'),
                ])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">

                <div class="row theme_settings">
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">@lang('index.single_product')</h5>
                                <p class="card-text">
                                    @lang('index.single_product_desc')<br>
                                    @lang('index.single_product_example')<br>
                                    @lang('index.please_click')
                                    <a href="{{ route('product-category.index') }}"
                                        class="ds_anchor color-red font-w-500">@lang('index.here')</a>
                                    @lang('index.manage_service')
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('update-theme-setting', ['type' => 'single']) }}"
                                    class="btn bg-blue-btn {{ appTheme() == 'single' ? 'disabled' : '' }}">
                                    @if (appTheme() == 'single')
                                        <i class="fa fa-check-circle me-2"></i>@lang('index.selected')
                                    @else
                                        @lang('index.select')
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">@lang('index.multi_product')</h5>
                                <p class="card-text">
                                    @lang('index.multiple_product_desc')<br>
                                    @lang('index.multi_product_example') <br>
                                    @lang('index.please_click')
                                    <a href="{{ route('product-category.index') }}"
                                        class="ds_anchor color-red font-w-500">@lang('index.here')</a>
                                    @lang('index.manage_service')
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('update-theme-setting', ['type' => 'multiple']) }}"
                                    class="btn bg-blue-btn {{ appTheme() == 'multiple' ? 'disabled' : '' }}">
                                    @if (appTheme() == 'multiple')
                                        <i class="fa fa-check-circle me-2"></i>&nbsp;@lang('index.selected')
                                    @else
                                        @lang('index.select')
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/site-setting.js?var=2.2') }}"></script>
@endpush
