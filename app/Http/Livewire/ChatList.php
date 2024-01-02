<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Friendship;
use App\Models\Conversation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\ConversationController;

class ChatList extends Component
{
    protected $listeners = ['refresh' => '$refresh'];

    public $searchTerm = '';

    public $searchResults;


    public function render()
    {
        $this->searchResults = $this->searchFriendChat();

        if (session()->has('selected_friend_id')) {
            $frnId = session('selected_friend_id');
            $this->emit('showThisFriend', $frnId);
        }

        // calling the recentMessage from ConversationController method for getting the last message

        $latestmsg = new ConversationController();
        $lastConversations = $latestmsg->recentMessage();

        return view('livewire.chat-list', compact('lastConversations'));
    }


    // opening specific chat user selected in message list
    public function openThisChatUser($frnId)
    {
        $this->searchTerm = '';
        // Mark the last message as seen for the given friend
        $markMessageSeen = new ConversationController();
        $markMessageSeen->setMessageSeen($frnId);
        // triggering another component with specific friendId
        session(['selected_friend_id' => $frnId]);
        $this->emit('showThisFriend', $frnId);
    }

    // searching friends in chat list
    public function searchFriendChat()
    {
        if (empty($this->searchTerm)) {
            return [];
        }

//        $userId = auth()->user()->id;

        // Performing search logic here based on searchTerm
        $userId = auth()->user()->id;

        // Retrieve friend IDs using the friendslist method
        $friendIds = User::find($userId)->friendslist()->pluck('id', 'first_name');

        // Fetch the friend users based on the retrieved IDs and search term
        $this->searchResults = User::whereIn('id', $friendIds)
            ->where(function ($query) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$this->searchTerm}%"])
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$this->searchTerm}%"])
                    ->orWhere('email', 'LIKE', "%{$this->searchTerm}%");
            })
            ->get();

        if (count($this->searchResults) === 0) {
            toastr()->info('No result found!', 'Ops!');
        }
        return $this->searchResults;
    }

}
