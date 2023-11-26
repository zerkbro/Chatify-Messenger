<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use App\Events\FriendshipSuccess;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class FriendshipSuccessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $current_user_id, $friend_id, $friend_name;
    public function __construct( $current_user_id, $friend_id, $friend_name)
    {
        //
        $this->current_user_id = $current_user_id;
        $this->friend_id = $friend_id;
        $this->friend_name = $friend_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        event(new FriendshipSuccess($this->current_user_id, $this->friend_id, $this->friend_name ));

    }
}
