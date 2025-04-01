@extends('layouts.app')
@push('css')
<link href="{{ asset('assets/bower_components/jquery_ui/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('frequent_changing/css/drag_drop_list.css') }}">
@endpush

@section('content')
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-5 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.product_category_sorting')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['col' => '7','firstSection' => __('index.product_category'), 'secondSection' => __('index.product_category_sorting')])
            </div>
        </section>
        <div class="box-wrapper no_animation">
            <div class="table-box">
                <div>
                    <ul class="sort_category list-group">
                        @if(count($products))
                        @foreach ($products as $product)
                            <li class="list-group-item"  data-id="{{$product->id}}">
                            <span class="handle"><iconify-icon icon="jam:move" width="16"></iconify-icon></span> {{$product->title}}</li>
                        @endforeach
                        @else 
                        <div class="alert alert-danger" role="alert">
                            <strong>@lang('index.no_data_found')</strong>
                        </div>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-2 mb-2">
                    <a class="btn custom_header_btn w-100 mt-2" href="{{ route('product-category.index') }}">
                        @lang('index.back')
                    </a>
                </div>
            </div>
        </div>
        
    </section>
@endsection

@push('js')
<script src="{{ asset('assets/bower_components/jquery_ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('frequent_changing/js/product_category_sort.js') }}"></script>
@endpush
