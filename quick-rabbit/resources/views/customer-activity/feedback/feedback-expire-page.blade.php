@extends('errors.layout')
@section('message')
    <div class="common-page">
        <div class="message-wrap">
            <h4 class="message">
                419
            </h4>
            <h5 class="message-1">@lang('index.link_expired')</h5>
            <a class="link-btn" href="{{ route('dashboard') }}">@lang('index.go_to_back')</a>
        </div>
    </div>
@endsection
