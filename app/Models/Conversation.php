<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected array $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'type',
        'sender_id',
        'recipent_id',
        'deleted_by_user_id',
        'last_time_message',
        'has_multiple_conversation',
    ];

    protected $casts = [
        'has_multiple_conversation' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function sender():  BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipent_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'conversation_id')
            ->orderByDesc('created_at')->latest();
    }

    /**
     * Test Code for scopeVisibleForUser
     */
    public function scopeVisibleToUser($query, $userId)
    {
        return $query->where(function ($query) use ($userId) {
            // Include conversations initiated by the user
            $query->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('recipent_id', $userId);
            });
            // Exclude conversations deleted by the user or not initiated by the user
            $query->where(function ($query) use ($userId) {
                $query->where('deleted_by_user_id', '!=', $userId)
                    ->orWhereNull('deleted_by_user_id');
            });
        });
    }

    /**
     * Test Code for scopeWithFriend
     */
    public function scopeWithFriend($query, $friendId)
    {
        return $query->where(function ($query) use ($friendId) {
            $query->where('sender_id', $friendId)
                ->orWhere('recipent_id', $friendId);
        });
    }

    /**
     * Test Code for deleted_by_user_id
     */

    public function isDeletedByUser($userId): bool
    {
        return $this->deleted_by_user_id === $userId;
    }

    /**
     * Test Code for scopeWithUnreadMessagesCount
     */
    public function getUnreadMessagesCountAttribute()
    {
        return $this->messages()->notSeenReceived(auth()->id())->count();
    }


    public function conversationDeletingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by_user_id');
    }

    public static function getUserConversations($userId)
    {

        return self::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->whereNull('deleted_by_user_id');
        })->orWhere(function ($query) use ($userId) {
            $query->where('recipent_id', $userId)
                ->whereNull('deleted_by_user_id');
        });
    }




    // used for counting unread messages.
    public function unreadMessagesCountWithFriend($friendId)
    {
        $conversations = $this
            ->where(function ($query) use ($friendId) {
                $query->where('sender_id', auth()->user()->id)
                    ->where('recipent_id', $friendId);
            })
            ->orWhere(function ($query) use ($friendId) {
                $query->where('sender_id', $friendId)
                    ->where('recipent_id', auth()->user()->id);
            })
            ->get();

        // dd($conversations);

        $unreadCount = 0;

        foreach ($conversations as $conversation) {
            $unreadCount += $conversation->messages()
                ->where('user_id', '!=', auth()->user()->id)
                ->where('is_seen', false)
                ->count();
        }
        // dd($unreadCount);

        return $unreadCount;
    }



    // used for getting the existing conversation in The ChatBox livewire component.
    public function getExistingConversationWith($userId)
    {
        return $this->where(function ($query) use ($userId) {
            $query->whereHas('sender', function ($senderQuery) use ($userId) {
                $senderQuery->where('id', auth()->user()->id);
            })->whereHas('recipent', function ($recipientQuery) use ($userId) {
                $recipientQuery->where('id', $userId);
            })->where(function ($subQuery) {
                $subQuery->whereNull('deleted_by_user_id')
                    ->orWhere('deleted_by_user_id', '!=', auth()->user()->id);
            });
        })->orWhere(function ($query) use ($userId) {
            $query->whereHas('sender', function ($senderQuery) use ($userId) {
                $senderQuery->where('id', $userId);
            })->whereHas('recipent', function ($recipientQuery) use ($userId) {
                $recipientQuery->where('id', auth()->user()->id);
            })->where(function ($subQuery) {
                $subQuery->whereNull('deleted_by_user_id')
                    ->orWhere('deleted_by_user_id', '!=', auth()->user()->id);
            });
        })->get();
    }


        /**
         *
         * Test Code for getting existing conversation.
         *
         */

    // $existingConversation = Conversation::where(function ($query) use ($frnId) {
    //     $query->where('sender_id', auth()->user()->id)
    //         ->where('recipent_id', $frnId)
    //         ->where(function ($subQuery) {
    //             $subQuery->whereNull('deleted_by_user_id')
    //                 ->orWhere('deleted_by_user_id', '!=', auth()->user()->id);
    //         });
    // })->orWhere(function ($query) use ($frnId) {
    //     $query->where('sender_id', $frnId)
    //         ->where('recipent_id', auth()->user()->id)
    //         ->where(function ($subQuery) {
    //             $subQuery->whereNull('deleted_by_user_id')
    //                 ->orWhere('deleted_by_user_id', '!=', auth()->user()->id);
    //         });
    // })->get();
}
