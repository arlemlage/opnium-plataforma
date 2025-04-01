<div class="card chat-right" id="chat-box-group">
    <div class="right-chat-head">
        <div class="chat-right-avater">
            <div class="avatar">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.375 2.0625H3.625C2.33281 2.0625 1.28125 3.11406 1.28125 4.40625V16.9062C1.28125 18.1984 2.33281 19.25 3.625 19.25H5.96875V23.1562C5.969 23.3033 6.01072 23.4474 6.08913 23.5718C6.16754 23.6962 6.27945 23.7961 6.41202 23.8598C6.54459 23.9235 6.69243 23.9485 6.83859 23.932C6.98474 23.9155 7.12327 23.8581 7.23828 23.7664L12.8836 19.25H22.375C23.6672 19.25 24.7188 18.1984 24.7188 16.9062V4.40625C24.7188 3.11406 23.6672 2.0625 22.375 2.0625ZM13 13H6.75C6.5428 13 6.34409 12.9177 6.19757 12.7712C6.05106 12.6247 5.96875 12.426 5.96875 12.2187C5.96875 12.0115 6.05106 11.8128 6.19757 11.6663C6.34409 11.5198 6.5428 11.4375 6.75 11.4375H13C13.2072 11.4375 13.4059 11.5198 13.5524 11.6663C13.6989 11.8128 13.7812 12.0115 13.7812 12.2187C13.7812 12.426 13.6989 12.6247 13.5524 12.7712C13.4059 12.9177 13.2072 13 13 13ZM19.25 9.875H6.75C6.5428 9.875 6.34409 9.79269 6.19757 9.64618C6.05106 9.49966 5.96875 9.30095 5.96875 9.09375C5.96875 8.88655 6.05106 8.68784 6.19757 8.54132C6.34409 8.39481 6.5428 8.3125 6.75 8.3125H19.25C19.4572 8.3125 19.6559 8.39481 19.8024 8.54132C19.9489 8.68784 20.0312 8.88655 20.0312 9.09375C20.0312 9.30095 19.9489 9.49966 19.8024 9.64618C19.6559 9.79269 19.4572 9.875 19.25 9.875Z" fill="#5065E2"/>
                </svg>
            </div>                
            <div class="chat-right-name">
                <h6>{{ $group->name ?? '' }}</h6>
                <span class="text-mute"></span>
            </div>
        </div>
        <div class="chat-right-info">
            <form action="{{ route('close-chat', $group->id) }}" class="alertDelete-{{ $group->id }}" method="get"
                id="close-chat-form">
                @csrf
            </form>
            <a class="deleteRow btn btn-sm btn-danger text-white cancel_customer_chat" id="close-chat-"
                href="javascript:void(0)">
                </i> @lang('index.close_chat')
            </a>
            @if (authUserRole() != 3)
                <a type="button" class="btn btn-sm base-btn forward-chat" data-bs-toggle="modal"
                    data-bs-target="#forward-chat">
                    {{ __('index.forward_chat') }}
                </a>
            @endif
        </div>
    </div>

    <div class="right-chat-body individual-group_{{ Auth::id() }}" id="group-chat-messages_{{ $group->pair_key }}">
        <div class="right-chat-list" id="group-chat-messages-push-div_{{ $group->pair_key }}">
            @foreach ($messages as $message)
                @if ($message->message_type == 'incoming_message')
                    <div class="sender-data">
                        <div class="c-pull-left">
                            <div class="sender-avater">
                                <img title="{{ $message->sender['full_name'] }}"
                                    src="{{ asset($message->sender['image']) }}" alt="">                                
                            </div>
                            <div class="sender-info">
                                @if ($message->is_link)
                                    <a target="_blank" href="{{ $message->message }}">{!! $message->message ?? '' !!}</a>
                                @else
                                    <p>{!! $message->message ?? '' !!} </p>
                                @endif
                                <div class="sender-time">
                                    <span>{{ $message->message_time ?? '' }}</span>
                                </div>
                            </div>                            
                        </div>
                    </div>
                @elseif($message->message_type == 'forward_message')
                    <div class="devider-message-parent">
                        <span class="devider-message">{!! $message->message ?? '' !!}</span>
                    </div>
                    <br>
                @elseif($message->message_type == 'outgoing_message')
                    <div class="receiver-data ">
                        <div class="c-pull-right">
                            <div class="receiver-info">
                                @if ($message->is_link)
                                    <a target="_blank" href="{{ $message->message }}">
                                        @if ($message->seen_status == 1)
                                            <i class="bi bi-check2-all receiver-status-icon"></i>
                                        @endif
                                        {!! $message->message ?? '' !!}
                                    </a>
                                @else
                                    <p>
                                        @if ($message->seen_status == 1)
                                            <i class="bi bi-check2-all receiver-status-icon"></i>
                                        @endif
                                        {!! $message->message ?? '' !!}
                                    </p>
                                @endif
                                <div class="receiver-time">
                                    <span>{{ $message->message_time ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @if (auth()->user()->role_id == 3)
            <i class="ai_is_replying"><span>@lang('index.ai_agent_replying')</span><span class="animated-dots"></span></i>
        @endif
    </div>
    <div class="message-box">
        <input type="hidden" name="group_id" value="{{ $group->id }}" id="group_id">
        <input type="text" placeholder="@lang('index.type_your_message_here')"
            class="form-control message-box_text_box border-r-25  group-chat-input_{{ $from_id }}"
            data-to="{{ $group->id }}">
        <span class="send-message">
            <button class="">
                <span class="customer-send-message group-chat-message-send-btn_{{ $from_id }}">
                    @lang('index.send')
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_722_1472)">
                        <path d="M15.8626 0.137361C15.7978 0.0724935 15.7153 0.0280847 15.6254 0.00963719C15.5356 -0.00881035 15.4423 -0.000485702 15.3571 0.0335795L0.294585 6.05851C0.210253 6.09226 0.137545 6.1498 0.0853001 6.22411C0.033055 6.29842 0.0035236 6.3863 0.000296095 6.47708C-0.00293141 6.56786 0.020284 6.65763 0.06712 6.73546C0.113956 6.81329 0.182395 6.87584 0.264117 6.9155L6.20373 9.79615L9.08441 15.7358C9.12405 15.8175 9.18658 15.886 9.26441 15.9328C9.34225 15.9797 9.43202 16.0029 9.52281 15.9997C9.6136 15.9965 9.7015 15.9669 9.77581 15.9147C9.85012 15.8624 9.90764 15.7897 9.94138 15.7053L15.9664 0.642922C16.0004 0.557746 16.0088 0.464444 15.9903 0.374579C15.9719 0.284713 15.9275 0.202234 15.8626 0.137361ZM1.62783 6.53494L13.5849 1.75217L6.45898 8.878L1.62783 6.53494ZM9.46497 14.3721L7.12188 9.54087L14.2478 2.41504L9.46497 14.3721Z" fill="white"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_722_1472">
                        <rect width="16" height="16" fill="white"/>
                        </clipPath>
                        </defs>
                        </svg>
                        
                </span>
            </button>
        </span>
    </div>
</div>
