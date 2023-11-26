<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recieverId;
    public $senderName;
    public $senderId;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($recieverId, $senderId, $senderName, $message)
    {
        //
        $this->recieverId = $recieverId;
        $this->senderName = $senderName;
        $this->message = $message;
        $this->senderId = $senderId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // return [
        //     new Channel('newMsg-channel'),
        // ];
        return [new Channel('newMsg-channel')];
    }

    public function broadcastAs(){
        return 'new-message';
    }
}
