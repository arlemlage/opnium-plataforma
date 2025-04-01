@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('frequent_changing/css/feedback.css?var=2.2') }}">
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
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.send_your_feedback') }}</h3>
                <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.customer_feedback'), 'secondSection' => __('index.send_your_feedback')])
        </div>
    </section>
    <div class="box-wrapper">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['method' => 'POST', 'url' => ['post-ticket-review'], 'class'=>'needs-validation', 'novalidate']) !!}
                <input type="hidden" name="ticket_id" value="{{ $ticket_id }}">
                <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                    <div class="card-body">
                        <p class="fw-bold texh-muted pd-0 mb-0">
                            Ticket: {{ App\Model\Ticket::find(encrypt_decrypt($ticket_id,'decrypt'))->title ?? "N/A" }}
                        </p>
                        <hr>
                        <h3 class="fw-bold">@lang('index.feedback_how_do')</h3>
                        <p class="fw-bold text-muted pb-0 mb-0">@lang('index.support_experience')</p>
                        <!-- Rating -->
                        <div class="form-group">
                            <div class="rating">
                                <input type="radio" name="rating" value="5" id="5" required> <label for="5">☆</label>
                                <input type="radio" name="rating" value="4" id="4" required> <label for="4">☆</label>
                                <input type="radio" name="rating" value="3" id="3" required> <label for="3">☆</label>
                                <input type="radio" name="rating" value="2" id="2" required> <label for="2">☆</label>
                                <input type="radio" name="rating" value="1" id="1" required> <label for="1">☆</label>
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <label class="mb-2">@lang('index.feedback_write_comment')</label>
                                {!! Form::textarea('review', null, ['class' => 'form-control review', 'required', 'cols'=>'200', 'placeholder'=>__('index.feedback_comment')]) !!}
                            </div>
                            <div class="col-sm-3 col-md-1 my-2">
                                <button type="submit" class="btn bg-blue-btn w-100">@lang('index.submit')</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</section>

@endsection


