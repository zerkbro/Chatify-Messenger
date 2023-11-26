<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\Auth\FriendController;

class AllFriendslist extends Component
{
    protected $listeners = ['refreshAllFriendsList'];

    public function refreshAllFriendsList()
    {

    }

    public function render()
    {
        // dd(auth()->user()->notifications->where('data.receiver_id', auth()->user()->id));
        // dd(auth()->user()->notifications()->get());
        return view('livewire.all-friendslist');
    }

    public function removeFriend($friendId){
        $friendController = new FriendController();
        $friendController->deleteFriend($friendId);

        return redirect()->back();
    }
}
