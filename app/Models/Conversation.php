<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'type',
        'sender_id',
        'recipent_id',
        'deleted_by_user_id',
        'last_time_message',
        'has_multiple_conversation',
    ];

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'conversation_user', 'conversation_id', 'user_id')
    //         ->withPivot('is_seen');
    // }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipent()
    {
        return $this->belongsTo(User::class, 'recipent_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id')
            ->orderByDesc('created_at')->latest();
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
