<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Friendship;
use App\Http\Controllers\Auth\FriendController;

class FriendRequestList extends Component
{
    // Showing the pending friend request
    public function render()
    {
                /**
                 * This way also we can retrieve pending friend request list of current friend
                 * but we will use Eloquent relationship directly in the view.
                 */

        // $pendingFriendRequests = Friendship::where('status', 'pending')
        //     ->where('friend_id', auth()->user()->id)
        //     ->with('user')
        //     ->get();
        // return view('livewire.friend-request-list', compact('pendingFriendRequests'));

        return view('livewire.friend-request-list');
    }

    public function acceptNewRequest($friendId)
    {
        $friendController = new FriendController();
        $friendController->acceptFriendRequest($friendId);
            // Emit an event to trigger a refresh in the Friends List component
        $this->emit('refreshFriendRequestList');
        $this->emitTo('friends-list', 'refreshFriendsList');
        $this->emitTo('all-friendslist', 'refreshAllFriendsList');

    }

    public function removeNewRequest($friendId)
    {
        $friendController = new FriendController();
        $friendController->declineFriendRequest($friendId);
        $this->emit('refreshFriendRequestList');
    }
}
