<?php

namespace App\Models;

use App\Models\Friendship;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CanResetPassword, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'first_name',
        'last_name',
        'password',
        'phone',
        'profile_image',
        'profile_image_path',
        'gender',
        'address',
        'city',
        'user_bio',
        'is_online',
        'last_seen',
        'account_status',
        'account_inactive_reason',
        'account_inactive_since',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     *
     *
     *Relationship with Friendship Model
     *
     *
     */


    // This returns collection of friendship of current user.
    public function friendship(): HasMany
    {
        return $this->hasMany(Friendship::class)->where('status', 'accepted');
    }

    public function getDetailOfFriendship($friend): ?Friendship
    {
        $friendId = $friend instanceof User ? $friend->id : $friend;
        return $this->friendship()
            ->where(function ($query) use ($friendId) {
                $query->where('user_id', $this->id)
                    ->where('friend_id', $friendId)
                    ->where('status', 'accepted');
            })
            ->orWhere(function ($query) use ($friendId) {
                $query->where('user_id', $friendId)
                    ->where('friend_id', $this->id)
                    ->where('status', 'accepted');
            })
            ->first();
    }

    // This returns all the sent requests
    public function sentFriendRequests(): HasMany
    {
        return $this->hasMany(Friendship::class, 'user_id', 'id')->where('status', '=', 'pending');
    }

    // This returns all the received requests
    public function receivedFriendRequests(): HasMany
    {
        return $this->hasMany(Friendship::class, 'friend_id', 'id')->where('status', '=', 'pending');
    }

    //Currently Used In Seperating Cancle Request & Accept Or Decline Request. (search result view)
    public function hasPendingFriendRequest($frnId)
    {
        // Check if there is a pending friend request from $frnId
        return $this->receivedFriendRequests()->where('user_id', $frnId)->exists();
    }

    // used in search view for counting friends.
    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('status', '=', 'accepted'); // Assuming 'status' is the column in the pivot table
    }


    // Custom Function For checking the friendship status using collection
    public function isFriendWith(User $user)
    {
        return Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $this->id)
                ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('friend_id', $this->id);
        })->where('status', 'accepted')
            ->exists();
    }

    // Custom Function to delete friendship
    public function deleteThisFriend(User $user)
    {
        $friendship = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $this->id)
                ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('friend_id', $this->id);
        })->where('status', 'accepted')
            ->first();

        if ($friendship) {
            $friendship->delete();
        }
        // return back();
    }


    // Used for getting the exact friendship status with each user from the search result page view

    public function getFriendshipStatusWith(User $user)
    {
        $friendship = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $this->id)
                ->where('friend_id', $user->id)
                ->orWhere('user_id', $user->id)
                ->where('friend_id', $this->id);
        })
            ->first();

        if ($friendship) {
            return $friendship->status;
        }

        return null; // No friendship exists
    }



    public function getFriends()
    {
        // Get friend IDs for both sender and receiver
        $friendIds = Friendship::where('user_id', $this->id)
            ->orWhere('friend_id', $this->id)
            ->where('status', 'accepted')
            ->pluck('user_id', 'friend_id')
            ->toArray();

        // Get User IDs for the friends
        $friendUserIds = array_keys($friendIds);

        // Get the User models for the friend User IDs
        return User::whereIn('id', $friendUserIds)->get();

        // $friendIds = array_diff($friendIds, [$this->id]); // Remove the user's own ID
    }

    // Retreving the friendlist of Auth()->User() or current user
    /**
     * used in Online Friend List view
     */
    public function friendslist()
    {
        $senderFriends = Friendship::where('user_id', $this->id)
            ->where('status', 'accepted')
            ->pluck('friend_id');

        $receiverFriends = Friendship::where('friend_id', $this->id)
            ->where('status', 'accepted')
            ->pluck('user_id');

        $allFriendIds = $senderFriends->concat($receiverFriends)->unique();

        return User::whereIn('id', $allFriendIds)->get();
    }

    // Retreving the friendlist of other friends also
    public function fofList($id)
    {
        $senderFriends = Friendship::where('user_id', $id)
            ->where('status', 'accepted')
            ->pluck('friend_id');

        $receiverFriends = Friendship::where('friend_id', $id)
            ->where('status', 'accepted')
            ->pluck('user_id');

        $allFriendIds = $senderFriends->concat($receiverFriends)->unique();

        return User::whereIn('id', $allFriendIds)->get();
    }


    /**
     *
     * Relationship with Coversation Model
     */

    public function sentConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    public function receivedConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'recipent_id');
    }

    // public function conversations(): BelongsToMany
    // {
    //     return $this->belongsToMany(Conversation::class);
    // }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'sender_id', 'id')
            ->orWhere(function ($query) {
                $query->where('recipent_id', $this->id);
            });
    }

    public function friendsWithConversations()
    {
        $senderFriends = Friendship::where('user_id', $this->id)
            ->where('status', 'accepted')
            ->pluck('friend_id');

        $receiverFriends = Friendship::where('friend_id', $this->id)
            ->where('status', 'accepted')
            ->pluck('user_id');

        $allFriendIds = $senderFriends->concat($receiverFriends)->unique();

        // Filter friends who have conversations with the authenticated user
        $friendsWithConversations = User::whereIn('id', $allFriendIds)
            ->where(function ($query) {
                $query->whereHas('sentConversations', function ($query) {
                    $query->where('recipent_id', $this->id);
                })->orWhereHas('receivedConversations', function ($query) {
                    $query->where('sender_id', $this->id);
                });
            })
            ->with(['sentConversations.lastMessage', 'receivedConversations.lastMessage'])
            ->get();

        return $friendsWithConversations;
    }
}
