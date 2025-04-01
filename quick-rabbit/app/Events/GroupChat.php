<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupChat implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message_type;
    public $sender;
    public $group;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message_type,$sender,$group,$message)
    {
        $this->message_type = $message_type;
        $this->sender = $sender;
        $this->group = $group;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel(pusherChannel());
    }

    public function broadcastAs()
    {
        return 'group-chat';
    }
}
