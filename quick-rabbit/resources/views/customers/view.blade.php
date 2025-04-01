@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.customer_details') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.customer'), 'secondSection' => __('index.customer_details')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <span class="heading-text">@lang('index.full_name')</span>
                        :
                        {{ $obj->full_name ?? "" }}
                    </p>

                    <p>
                        <span class="heading-text">@lang('index.email')</span> :
                        {{ $obj->email ?? "" }}
                    </p>
                    <p>
                        <span class="heading-text">@lang('index.mobile')</span> :
                        {{ $obj->mobile ?? "" }}
                    </p>


                </div>
                <div class="col-md-12">
                    <p class="heading-text">@lang('index.customer_notes')</p>
                    @foreach($notes as $note)
                            <p class="bg-light p-1">
                                {!! $note->note !!}
                            </p>
                        @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-2 mt-3">
            <a class="btn custom_header_btn w-100 mt-4" href="{{ route('customer.index') }}">
                @lang('index.back')
            </a>
        </div>
    </section>
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
