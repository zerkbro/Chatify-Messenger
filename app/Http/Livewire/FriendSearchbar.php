<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Auth\FriendController;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class FriendSearchbar extends Component
{


    public $searchTerm = '';
    public $searchResults;


    public function render()
    {
        // To access the method of User model in this render method we need this to be defined
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $this->searchResults = $this->searchFriends();

        // Get the authenticated user ID for preventing self suggestation
        $authenticatedUserId = auth()->id();

        // Get the "user" role model using the Spatie Permission package
        $userRole = Role::where('name', 'user')->first();

        // Query random suggested users who have the "user" role and exclude the authenticated user
        $suggestedUsers = $userRole->users()
            // the current user is not included in the suggested users list
            ->where('id', '!=', $authenticatedUserId)
            // filters out users whose ID's are present in the subquery
            ->whereNotIn('id', function ($query) use ($authenticatedUserId) {
                $query->select('friend_id')
                    ->from('friendships') // This is table name
                    ->where('user_id', $authenticatedUserId);
            })
            ->whereNotIn('id', function ($query) use ($authenticatedUserId) {
                $query->select('user_id')
                    ->from('friendships') // This is table name
                    ->where('friend_id', $authenticatedUserId);
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();


        return view('livewire.friend-searchbar', compact('suggestedUsers'));
    }


    // searching friends
    public function searchFriends()
    {
        if (empty($this->searchTerm)) {
            return [];
        }
        $authenticatedUserId = auth()->user()->id;

        $userRole = Role::where('name', 'user')->first();

        // Performing search logic here based on $this->searchTerm

        $this->searchResults = $userRole->users()
            ->where(function ($query) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$this->searchTerm}%"])
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$this->searchTerm}%"])
                    ->orWhere('email', 'LIKE', "%{$this->searchTerm}%");
            })
            ->where('id', '!=', $authenticatedUserId)
            ->get();
        if(count($this->searchResults)===0){
            toastr()->info('no result found!', 'search status');
        }
        return $this->searchResults;
    }


    // Send Friend request
    public function addNewFriend($friendId){
        $friendController = new FriendController();
        $friendController->sendNewRequest($friendId);


        $this->emit('refreshComponent');
    }


    // Cancel Friend Request
    public function cancelRequest($friendId){
        $friendController = new FriendController();
        $friendController->cancelFriendRequest($friendId);

        $this->emit('refreshComponent');
    }


    // Accept Friend request
    public function acceptNewRequest($friendId)
    {
        $friendController = new FriendController();
        $friendController->acceptFriendRequest($friendId);

    }

    // Reject Friend request
    public function removeNewRequest($friendId)
    {
        $friendController = new FriendController();
        $friendController->declineFriendRequest($friendId);
    }





}


