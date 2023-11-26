<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Friendship extends Model
{
    use HasFactory;

    // Friendship.php model
    protected $fillable = ['user_id', 'friend_id', 'status', 'action_user_id'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function requestSender(): BelongsTo
    {
        return $this->belongsTo(User::class,'action_user_id', 'id');
    }

}
