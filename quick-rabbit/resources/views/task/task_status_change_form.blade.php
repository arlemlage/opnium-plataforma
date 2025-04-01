
<div class="row">
    <div class="col-sm-12 mb-2 col-md-12">
        <div class="form-group">
            <input type="hidden" id="task_id" value="{{ $task->id }}">
            <label>
                @lang('index.title')</label>
            <input type="text" value="{{ $task->task_title ?? '' }}" class="form-control" placeholder="@lang('index.title')" readonly>
        </div>
    </div>
     <div class="col-md-12">
        <div class="form-group">
            <label for="status">@lang('index.status'){!! starSign() !!}</label>
            <select name="status" class="form-control select2" id="task-status" >
                <option value="Pending" {{ isset($task) && $task->status === "Pending" ? 'selected' : '' }}>@lang('index.pending')</option>
                <option value="In-Progress" {{ isset($task) && $task->status === "In-Progress" ? 'selected' : '' }}>@lang('index.in_progress')</option>
                <option value="Done" {{ isset($task) && $task->status === "Done" ? 'selected' : '' }}>@lang('index.done')</option>
            </select>
        </div>
    </div>
    
</div>

<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js?var=2.2') }}"></script>
    <script src="{{ asset('assets/bower_components/datepicker/bootstrap-datepicker.js?var=2.2') }}"></script>

<script src="{{ asset('frequent_changing/js/task_status_change.js?var=2.2') }}"></script>
<script src="{{ asset('frequent_changing/js/ocational.js?var=2.2') }}"></script>



