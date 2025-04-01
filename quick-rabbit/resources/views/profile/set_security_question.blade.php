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
                <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">
                    @lang('index.set_security_question')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.profile'), 'secondSection' => __('index.set_security_question')])
        </div>
    </section>
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
           <form action="{{ route("save-security-question") }}" method="POST" id="common-form">
           	@csrf
           	@method('PUT')
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.question')
                                {!! starSign() !!}
                            </label>
                            <select name="question" id="question" class="form-control select2">
                                <option value="">@lang('index.select_question')</option>
                                @foreach($questions as $question)
                                    <option value="{{ $question }}" {{ Auth::user()->question === $question ? 'selected' : '' }}>{{ $question }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('question'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('question') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label>@lang('index.answer') {!! starSign() !!}</label>
                            <input tabindex="2" type="text" name="answer" class="form-control" placeholder="@lang('index.answer')" value="{{ Auth::user()->answer ?? '' }}">
                        </div>
                        @if ($errors->has('answer'))
                            <span class="error_alert text-danger" role="alert">
                                {{ $errors->first('answer') }}
                            </span>
                        @endif
                    </div>

                <div class="row mt-2">
                    <div class="col-sm-6 col-md-3 mb-2">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100" id="submit-btn">{!! commonSpinner() !!}@lang('index.submit')</button>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-2">
                            <a class="btn custom_header_btn w-100" href="{{ route('user-home') }}">
                                @lang('index.back')
                            </a>
                        </div>
                </div>
            </div>
                </div>
           </form>
        </div>
    </div>
</section>
@endsection

@push('js')
@endpush
