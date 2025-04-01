<form action="{{ route('update-chat-agent') }}" method="get" role="form" id="update-chat-agent">
    @csrf
    @method('PUT')
    <div class="form-group mt-2">
        <div class="form-group">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <label for="">@lang('index.agent') {!! starSign() !!}</label> 
            <select name="agent_id" id="agent_id" class="form-control select2" >
                <option value="">@lang('index.select')</option>
                @foreach($agents as $data)
                    <option value="{{ $data->id }}" {{ \App\Model\ProductCategory::find($product->id)->first_chat_agent_id == $data->id ? 'selected' : '' }}>{{ $data->full_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group mt-2">
        <button type="submit" class="btn bg-blue-btn">@lang('index.submit')</button>
    </div>
</form>

<script src="{{ asset('frequent_changing/js/chat_agent_form.js?var=2.2') }}"></script>

