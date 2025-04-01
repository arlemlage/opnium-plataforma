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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.canned_message_view') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.canned_msg'), 'secondSection' =>  __('index.canned_message_view')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title mb-0 p-0">{{ $obj->title ?? "" }}</h5>
                    <hr>
                </div>
                <div class="col-md-12">
                    {!! $obj->canned_msg_content !!}
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-2 mb-2">
                    <a class="btn custom_header_btn w-100" href="{{ route('canned-message.index') }}">
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
