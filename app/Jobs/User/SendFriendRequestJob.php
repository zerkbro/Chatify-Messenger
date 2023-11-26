<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use App\Events\NewfriendRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendFriendRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $friend_id, $current_user_id, $current_user_name;
    public function __construct($friend_id, $current_user_id, $current_user_name)
    {
        //
        $this->friend_id = $friend_id;
        $this->current_user_id = $current_user_id;
        $this->current_user_name = $current_user_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        event(new NewfriendRequest($this->friend_id, $this->current_user_id, $this->current_user_name ));
    }
}
