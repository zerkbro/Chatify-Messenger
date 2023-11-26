<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendshipSuccess implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recieverId; // id of the one who gets the frn request
    public $senderId;   // frn req sender
    public $recieverName; // name of the one who gets the request

    /**
     * Create a new event instance.
     */
    public function __construct($senderId, $recieverId, $recieverName)
    {
        //
        $this->senderId = $senderId;
        $this->recieverId = $recieverId;
        $this->recieverName = $recieverName;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('friendship-success'),
        ];
    }

    public function broadcastAs(){
        return 'friendship-alert';
    }
}
