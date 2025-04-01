@if(count($all_notification_info)>0)
    @foreach($all_notification_info as $key=>$notification)
        <?php
            $ticket_info = App\Model\Ticket::find($notification->ticket_id);
            $bg_color = (($key%2)==0)? 'even':'odd'
        ?>
    <li class="notification_element {{ $bg_color }}">
        <div>
            <a  href="{{ url($notification->redirect_link) }}"> {!! $notification->message !!}</a>
            <p class="fs-6 fw-bold mb-0">{{ $ticket_info->title ?? "" }}</p>
        </div>
        <div>
            <div class="trash_and_eye pb-1">
                <a href="{{ url($notification->redirect_link) }}"><iconify-icon icon="solar:eye-bold" width="22"></iconify-icon></a>
                <a href="{{ route('notification-delete', encrypt_decrypt($notification->id, 'encrypt'))}}"> <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon></a>
            </div>
            <span class="notification-item">{{ date(siteSetting()->date_format, strtotime($notification->created_at)) }}</span>
        </div>
    </li>
    @endforeach
@else
    <li class="notification_element even">
        <div>
            <a href="#">@lang('index.no_notification') </a>
        </div>
    </li>
@endif

