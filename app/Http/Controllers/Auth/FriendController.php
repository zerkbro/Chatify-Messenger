<?php

namespace App\Http\Controllers\Auth;

use App\Events\FriendshipSuccess;
use App\Events\NewfriendRequest;
use App\Jobs\User\FriendshipSuccessJob;
use App\Models\User;
use App\Models\Friendship;
use App\Notifications\FriendRequestNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\User\SendFriendRequestJob;

class FriendController extends Controller
{
    // Sending New Friend Request

    public function sendNewRequest($friendId)
    {
        /** @var \App\Models\User $user */

        $user = auth()->user();
        $friend = User::findOrFail($friendId);
        $friendship = new Friendship([
            'user_id' => $user->id,
            'friend_id' => $friend->id,
            'status' => 'pending',
            'action_user_id' => $user->id,
        ]);

        $friendship->save();
        toastr()->success('Friend Request Sent!');

        // event(new NewfriendRequest($friend->id, $user->id, $user->first_name ));
        SendFriendRequestJob::dispatch($friend->id, $user->id, $user->first_name);

        $friend->notify(new FriendRequestNotification($friend, $user, 'request_sent')); // $friend = receiver_user and $user = sender_user


        // return back();

    }

    public function cancelFriendRequest($friendId)
    {
        $user = auth()->user();
        $friend = User::findOrFail($friendId);

        $friendship = Friendship::where('user_id', $user->id)
            ->where('friend_id', $friend->id)
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            $friendship->delete();
            toastr()->info('Friend Request Cancelled!');
        }
        // return back();
    }

    public function acceptFriendRequest($friendId)
    {
        $user = User::findOrFail($friendId); // The user who sent the friend request
        $friend = auth()->user(); // The authenticated user who is accepting the friend request

        $friendship = Friendship::where('user_id', $user->id)
            ->where('friend_id', $friend->id)
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            $friendship->update(['status' => 'accepted']);
            toastr()->success('Friend Request Accepted!');
            // creating Request accepted event for broadcasting notification.
            // event(new FriendshipSuccess($user->id, $friend->id, $friend->first_name ));
            FriendshipSuccessJob::dispatch($user->id, $friend->id, $friend->first_name);
            $user->notify(new FriendRequestNotification($user, $friend, 'request_accept'));

        }
        // return back();
    }

    public function declineFriendRequest($friendId)
    {
        $user = User::findOrFail($friendId); // the one who sent the request
        $friend = auth()->user(); // the one who got the request and going to decline

        $friendship = Friendship::where('user_id', $user->id)
            ->where('friend_id', $friend->id)
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            $friendship->delete();
            toastr()->info('Friend request is declined!');
        }
        // return back();
    }


    // Delete a friend
    public function deleteFriend($friendId)
    {
        /** @var \App\Models\User $user */

        $user = auth()->user();
        $friend = User::findOrFail($friendId);

        if ($user->isFriendWith($friend)) {
            $user->deleteThisFriend($friend);
            toastr()->info('Friendship deleted!');
            return redirect()->route('userDashboard');

        } else {
            toastr()->error('Friendship not found.');
            return redirect()->route('userDashboard');

        }

        // return back();

    }
}
