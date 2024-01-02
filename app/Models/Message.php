<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'content',
        'is_seen',
        'attachment_type',
        'attachment_url',
        'attachment_filename',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     *
     * Unread message count feature
     *
     */
    public function scopeNotSeenReceived($query)
    {
        return $query->where('is_seen', false)->where('user_id', '!=', auth()->id());
    }


    /**
     *
     * Unread message highlighting feature
     *
     *
     */

    // for checking the last message is seen or not.
    public function getUnreadMessageIdAttribute()
    {
        // Check if the message is unread, and return the message ID
        // dd($this->id);

        if (!$this->is_seen) {
            return $this->id;
        }

        return null; // Return null for seen messages
    }


}
