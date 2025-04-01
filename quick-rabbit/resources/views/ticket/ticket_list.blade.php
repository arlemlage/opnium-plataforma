@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/ticket_index.css?var=2.2') }}">
@endpush

@section('content')
    @include('ticket.ticket_table')
@stop

@push('js')
    <!-- DataTables -->
@include('layouts.data_table_script')
<script src="{{ asset('frequent_changing/js/ticket_index.js?var=2.2') }}"></script>
@endpush
