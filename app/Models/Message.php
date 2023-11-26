<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
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
