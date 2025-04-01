@if(count($results))
    @foreach($results as $value)
        <div class="card {{ $loop->index > 0 ? 'mt-2' : '' }}">
            <div class="card-header calendar-bg">
                <h6 class="pull-left">{{ $value->task_title ?? "N/A" }}</h6>
                <h6 class="pull-right">{{ $value->status }}</h6>
            </div>
            <div class="card-body">
                <h6>@lang('index.assigned_to') : {{ $value->user->full_name ?? "N/A" }}</h6>
                @if($value->ticket_id != Null)
                <h6>@lang('index.ticket') : {{ $value->ticket->ticket_no.' - '. $value->ticket->title ?? "" }} </h6>
                @endif
                
                <p class="text-justify">{!! $value['description'] ?? "N/A" !!}</p>
            </div>
        </div>
    @endforeach
@else
    <p class="alert alert-danger">@lang('index.no_data_found')</p>
@endif



