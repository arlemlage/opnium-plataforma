<form action="{{ route('update-chat-sequence-setting',$chat_product->id) }}" method="POST">
    @csrf
    <div class="form-group col-8">
        <h5>@lang('index.chat_forward_interval_in_minute') {!! starSign() !!}</h5>
        <input type="number" class="form-control" name="interval_minute" placeholder="10" value="{{ $chat_product->interval_minute ?? 0 }}">
    </div>
    <div class="form-group mt-2">
        <ul class="sort_agent list-group">
            @foreach ($chat_sequence_data as $value)
                <li class="list-group-item" data-id="{{ $value->id }}">
                <span class="handle"><iconify-icon icon="jam:move" width="18"></iconify-icon></span> {{ getUserName($value->agent_id) }}</li>
            @endforeach
        </ul>
    </div>
    <div class="form-group mt-2">
        <button class="btn bg-blue-btn">@lang('index.submit')</button>
    </div>
</form>

<script src="{{ asset('assets/jquery_ui/jquery-ui.min.js?var=2.2') }}"></script>
<script src="{{ asset('frequent_changin/js/sequence_chat.js?var=2.2') }}"></script>
<script src="{{ asset('frequent_changin/js/ocational.js?var=2.2') }}"></script>
