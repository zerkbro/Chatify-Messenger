<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $receiver_user;
    protected $sender_user;
    protected $type;
    public function __construct($receiver_user, $sender_user, $type)
    {
        //
        $this->receiver_user = $receiver_user;
        $this->sender_user = $sender_user;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

    public function via($notifiable)
    {
        return ['database'];
    }




    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'receiver_id' => $this->receiver_user['id'],
            'receiver_name' => $this->receiver_user['name'],
            'sender_id' => $this->sender_user['id'],
            'sender_name' => $this->sender_user['name'],
            'type' => $this->type,
        ];
    }
}
