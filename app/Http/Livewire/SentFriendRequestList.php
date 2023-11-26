<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\Auth\FriendController;

class SentFriendRequestList extends Component
{
    public function render()
    {
        return view('livewire.sent-friend-request-list');
    }

    public function cancelRequest($friendId){
        $friendController = new FriendController();
        $friendController->cancelFriendRequest($friendId);

        $this->emit('refreshComponent');
    }
}
