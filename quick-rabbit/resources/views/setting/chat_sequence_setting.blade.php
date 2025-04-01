@extends('layouts.app')
@push('css')
<link href="{{ asset('assets/bower_components/jquery_ui/jquery-ui.css?var=2.2') }}"/>
<link rel="stylesheet" href="{{ asset('frequent_changing/css/drag_drop_list.css?var=2.2') }}">
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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.first_agent')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.setting'), 'secondSection' => __('index.first_agent')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="row">
                    @if (appTheme() == 'multiple')
                        <div class="col-xs-6 col-sm-6 col-md-6">
                        <label for="" class="mt-1">@lang('index.product_category')</label>

                        <ul class="list-group mt-2">
                            @if(count($products))
                            @foreach ($products as $product)
                                <li class="list-group-item cursor-pointer product-category {{ $loop->first ? 'first-item' : '' }}" data-id="{{$product->id}}" data-type="product">
                                {{$product->title}}</li>
                            @endforeach
                            @else 
                            <div class="alert alert-danger" role="alert">
                                <strong>@lang('index.no_data_found')</strong>
                            </div>
                            @endif
                        </ul>
                    </div>
                    @else
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <label for="" class="mt-1">@lang('index.departments')</label>

                        <ul class="list-group mt-2">
                            @if(count($departments))
                            @foreach ($departments as $department)
                                <li class="list-group-item cursor-pointer product-category {{ $loop->first ? 'first-item' : '' }}" data-id="{{$department->id}}" data-type="department">
                                {{$department->name}}</li>
                            @endforeach
                            @else 
                            <div class="alert alert-danger" role="alert">
                                <strong>@lang('index.no_data_found')</strong>
                            </div>
                            @endif
                        </ul>
                    </div>
                    @endif
                    
                    <div class="col-xs-6 col-sm-6 col-md-6" id="sequence-form">

                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection

@push('js')

<script src="{{ asset('frequent_changing/js/chat_sequence.js?var=2.2') }}"></script>

@endpush
