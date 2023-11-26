<?php

namespace App\Jobs\Chat;

use App\Events\Chat;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendNewMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $friend_id, $current_user_id, $current_user_name, $message_content;
    public function __construct($friend_id, $current_user_id, $current_user_name, $message_content)
    {
        //
        $this->friend_id =  $friend_id;
        $this->current_user_id = $current_user_id;
        $this->current_user_name = $current_user_name;
        $this->message_content = $message_content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // creating the chat event from the queue
        event(new Chat($this->friend_id, $this->current_user_id, $this->current_user_name, $this->message_content));
    }

}
