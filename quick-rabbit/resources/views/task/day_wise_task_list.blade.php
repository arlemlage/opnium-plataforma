@if(count($results))
    @include('task.task_loop_list')
@else
    <p class="alert alert-danger">@lang('index.no_data_found')</p>
@endif
<script src="{{ asset('frequent_changing/js/ocational.js?var=2.2') }}"></script>
<script src="{{ asset('frequent_changing/js/task_filter.js?var=2.2') }}"></script>

