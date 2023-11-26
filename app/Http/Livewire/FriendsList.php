<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Friendship;
use Illuminate\Support\Facades\Cache;

class FriendsList extends Component
{
    protected $listeners = ['refreshFriendsList'];
    public $totalActiveFriend = 0;

    public $isFriendsActive = false;


    public function refreshFriendsList()
    {
        // $this->refresh();

    }

    public function render()
    {
        return view('livewire.friends-list');
    }


}
