<ul class="single-chat-users_{{ Auth::user()->id }}">
    @foreach($users as $user)
      @if($user->id != Auth::user()->id)
        <li class="chat-item single-chat-item single-pair-class_{{ $user->pair_key }} {{ $loop->first ? 'user-list-active active-user' : 'unseen-item' }}" data-id="{{ $user->id }}" pair-key="{{ $user->pair_key }}">
          <div class="avater">
            <img src="{{ asset($user->image ?? 'assets/images/avator.jpg')}}" alt="user-avater" data-active="1">
          </div>
          <div class="person-info">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="name">{{ $user->full_name }}</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-truncate single-chat-last-message_{{ $user->pair_key }} {{ !empty($user->last_message['seen_status']) && $user->last_message['seen_status'] == false ? 'text-unseen' : 'text-seen' }}">
                {{ $user->last_message['message'] ?? "" }}
              </span>

            </div>
          </div>
        </li>
      @endif
    @endforeach
</ul>





