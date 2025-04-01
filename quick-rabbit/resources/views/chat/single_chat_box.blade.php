<div class="card chat-right" id="chat-box-single">
    <div class="right-chat-head">
      <div class="chat-right-avater">
        <img src="{{ asset($user->image ?? 'assets/images/avator.jpg') }}" alt="user-avater">
        <div class="chat-right-name">
          <h6>{{ $user->full_name ?? '' }}</h6>
        </div>
      </div>
      
    </div>
    <div class="right-chat-body single-message-for_{{ Auth::id() }}" id="single-chat-messages_{{ $user->pair_key }}">
      <div class="right-chat-list" id="single-chat-message-push-div_{{ $user->pair_key }}">
        @foreach($messages as $message)
            @if($message->message_type == "incoming_message")
                <div class="sender-data">
                    <div class="c-pull-left">
                        <div class="sender-avater">
                          <img title="{{ $message->sender->full_name }}" src="{{ asset($message->sender->image)}}" alt="">                          
                        </div>
                        <div class="sender-info">
                          @if($message->is_link)
                            <a target="_blank" href="{{ $message->message }}">{{ $message->message ?? "" }}</a>
                          @else   
                            <p>{{ $message->message ?? "" }} </p>
                          @endif
                          <div class="sender-time">
                            <span>{{ $message->message_time ?? "" }}</span>
                          </div>
                      </div>                      
                    </div>
                </div>
            @elseif($message->message_type == "outgoing_message")
                <div class="receiver-data">
                  <div class="c-pull-right">
                    <div class="receiver-info">
                      @if($message->is_link)
                          <a target="_blank" href="{{ $message->message }}">
                            @if($message->seen_status == 1)
                              <i class="bi bi-check2-all receiver-status-icon"></i>
                            @endif
                            {{ $message->message ?? "" }}
                          </a>
                        @else   
                          <p>
                            @if($message->seen_status == 1)
                              <i class="bi bi-check2-all receiver-status-icon"></i>
                            @endif
                            {{ $message->message ?? "" }}
                            </p>
                        @endif
                        <div class="receiver-time">
                          <span>{{ $message->message_time ?? "" }}</span>
                        </div>
                    </div>
                  </div>
                </div>
            @endif
        @endforeach
      </div>
    </div>
    <div class="message-box">
        <input type="hidden" name="to_id" value="{{ $to_id }}" id="to_id">

      <input type="text" placeholder="@lang('index.type_your_message_here')" class="form-control message-box_text_box border-r-25  single-chat-input_{{ $from_id }}" data-to="{{ $to_id }}">
      <span class="send-message">
        <button class="">
          <span class="single-chat-message-send-btn_{{ $from_id }}">
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
