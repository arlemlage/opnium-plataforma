<ul class="group-chat-users_{{ Auth::user()->id }}">
    @foreach($groups as $group)
        <li class="chat-item group-chat-item group-pair-class_{{ $group->pair_key }} {{ $loop->first ? 'user-list-active active-group' : 'unseen-item' }}" data-id="{{ $group->id }}" pair-key="{{ $group->pair_key }}">
          <div class="avater">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22.375 2.0625H3.625C2.33281 2.0625 1.28125 3.11406 1.28125 4.40625V16.9062C1.28125 18.1984 2.33281 19.25 3.625 19.25H5.96875V23.1562C5.969 23.3033 6.01072 23.4474 6.08913 23.5718C6.16754 23.6962 6.27945 23.7961 6.41202 23.8598C6.54459 23.9235 6.69243 23.9485 6.83859 23.932C6.98474 23.9155 7.12327 23.8581 7.23828 23.7664L12.8836 19.25H22.375C23.6672 19.25 24.7188 18.1984 24.7188 16.9062V4.40625C24.7188 3.11406 23.6672 2.0625 22.375 2.0625ZM13 13H6.75C6.5428 13 6.34409 12.9177 6.19757 12.7712C6.05106 12.6247 5.96875 12.426 5.96875 12.2187C5.96875 12.0115 6.05106 11.8128 6.19757 11.6663C6.34409 11.5198 6.5428 11.4375 6.75 11.4375H13C13.2072 11.4375 13.4059 11.5198 13.5524 11.6663C13.6989 11.8128 13.7812 12.0115 13.7812 12.2187C13.7812 12.426 13.6989 12.6247 13.5524 12.7712C13.4059 12.9177 13.2072 13 13 13ZM19.25 9.875H6.75C6.5428 9.875 6.34409 9.79269 6.19757 9.64618C6.05106 9.49966 5.96875 9.30095 5.96875 9.09375C5.96875 8.88655 6.05106 8.68784 6.19757 8.54132C6.34409 8.39481 6.5428 8.3125 6.75 8.3125H19.25C19.4572 8.3125 19.6559 8.39481 19.8024 8.54132C19.9489 8.68784 20.0312 8.88655 20.0312 9.09375C20.0312 9.30095 19.9489 9.49966 19.8024 9.64618C19.6559 9.79269 19.4572 9.875 19.25 9.875Z" fill="#5065E2"/>
              </svg>
              
          </div>
          <div class="person-info">
            <div class="d-flex justify-content-between align-items-center">
              <div>
              <h5 class="name">{{ $group->name }}</h5>
                @if(authUserRole() == 3)
                  <span class="badge">
                      @if($group->agent_online == true)
                          <span class="text-green">{{ "Agent Online" }}</span>
                      @else
                          <span class="text-red">{{ "Agent Offline" }}</span>
                      @endif
                  </span>
                @endif
              </div>
              <span class="time">{{ \Carbon\Carbon::parse($group->last_message_at)->format('h:i A') }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-short group-chat-last-message_{{ $group->pair_key }} {{ !empty($group->last_message) && $group->last_message['seen_status'] == false && (Auth::id()!=$group->last_message['from_id']) ? 'text-unseen' : 'text-seen' }}">
                {{ $group->last_message['message'] ?? "" }}
              </span>

              <div class="chat-action">

              </div>
            </div>
          </div>
        </li>
    @endforeach
  </ul>
