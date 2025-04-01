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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.faq_view') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.faq'), 'secondSection' =>  __('index.faq_view')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="row">
                
                <div class="col-md-12">
                    <p class=""><span class="heading-text">{{ $obj->question }}</span></p>
                    <hr>
                </div>
                <div class="col-md-12">
                    <p class="">{!! $obj->answer !!}</p>
                </div>
                <div class="col-md-12 mt-2">
                    @if(count($all_tags) > 0)
                        <p class="mb-1">
                            <span class="heading-text">@lang('index.tags')</span>
                            <hr class="mt-0">
                            @foreach($all_tags as $tag)
                                <span class="tag-bg">{{ $tag->title }}</span>
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-2 mb-2">
                    <a class="btn custom_header_btn w-100" href="{{ route('faq.index') }}">
                        @lang('index.back')
                    </a>
                </div>
            </div>
        </div>
        

    </section>
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
