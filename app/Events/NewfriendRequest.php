<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewfriendRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $recieverId;
    public $senderId;
    public $senderName;

    public function __construct($recieverId, $senderId, $senderName)
    {
        //
        $this->recieverId = $recieverId;
        $this->senderId = $senderId;
        $this->senderName = $senderName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('newFrnRequest-channel'),
        ];
    }

    public function broadcastAs(){
        return 'new-frnreq';
    }
}
