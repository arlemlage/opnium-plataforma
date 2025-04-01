@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-2 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">
                        {{ isset($obj) ? __('index.edit_article_group') : __('index.add_article_group') }}</h3>
                </div>
                @include('layouts.breadcrumbs', [                    
                    'col' => '8',
                    'firstSection' => __('index.article_group'),
                    'secondSection' => isset($obj)
                        ? __('index.edit_article_group')
                        : __('index.add_article_group'),
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
                    'route' => ['article-group.update', isset($obj->id) && $obj->id ? encrypt_decrypt($obj->id, 'encrypt') : ''],
                    'id' => 'common-form',
                ]) !!}
                @csrf
                <div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="form-group">
                                <label>@lang('index.title') {!! starSign() !!}</label>
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('index.title')]) !!}
                            </div>
                            @if ($errors->has('title'))
                                <span class="error_alert text-danger" role="alert">
                                    {{ $errors->first('title') }}
                                </span>
                            @endif
                        </div>
                        @if (appTheme() == 'multiple')
                            <div class="col-lg-4 col-md-6 mb-2">
                                <div class="form-group">
                                    <label>@lang('index.product_category') {!! starSign() !!}</label>
                                    {!! Form::select(
                                        'product_category',
                                        $product_category,
                                        isset($obj->product_category) ? $obj->product_category : null,
                                        ['class' => 'form-control select2', 'placeholder' => __('index.select'),'id' => 'product_category'],
                                    ) !!}
                                </div>
                                @if ($errors->has('product_category'))
                                    <span class="error_alert text-danger" role="alert">
                                        {{ $errors->first('product_category') }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <input type="hidden" name="product_category"
                                value="{{ array_key_first($product_category->toArray()) }}">
                        @endif

                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="form-group">
                                <label>@lang('index.description')</label>
                                {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => __('index.description')]) !!}
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="form-group custom_table">
                                <label>@lang('index.icon') (Types: jpeg,jpg,png, max. size:5mb)</label>
                                <table class="w-100">
                                    <tr>
                                        <td>
                                            <input tabindex="1" type="file" name="image" accept=".jpeg,.png,.jpg" class="form-control file_checker_global" data-this_file_size_limit="5" value="" id="blog_image">
                                            <input type="hidden" id="image_url" name="image_url" value="">
                                        </td>
                                        <td class="w_1">
                                            @if(isset($obj->icon) && file_exists($obj->icon))
                                                <button type="button" id="image_block" class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_modal_image">
                                                    <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                                </button>
                                            @endif
                                            <button type="button" id="preview_block" class="btn btn-md ms-2 pull-right fit-content btn-success-edited open_preview_image displayNone">
                                                <iconify-icon icon="solar:eye-bold" width="22"></iconify-icon>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
    
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if(Session::has('image_error'))
                                <span class="text-danger">{{ Session::get('image_error') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"
                                id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                        </div>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('article-group.index') }}">
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
@endpush
