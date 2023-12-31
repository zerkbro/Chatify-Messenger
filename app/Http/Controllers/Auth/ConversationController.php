<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Friendship;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;

class ConversationController extends Controller
{
    // checking if the conversation exists or not.
    public function checkConversation($receiverFriendId){

        $checkedConversation = Conversation::where('recipent_id', auth()->user()->id)
                                    ->where('sender_id', $receiverFriendId)
                                    ->orWhere('recipent_id', $receiverFriendId)
                                    ->where('sender_id', auth()->user()->id)
                                    ->get();
        if(count($checkedConversation)>0){
            return true;
        }else{
            return false;
        }

    }



    // setting the selected friend to open in the chat box.
    public function setSelectedFriend($frnId){
        session(['selected_friend_id' => $frnId]);
        // calling the message seen method to set seen on the last message.
        $this->setMessageSeen($frnId);

        return redirect()->route('chat_body');
    }



    // Setting message seen feature.
    public function setMessageSeen($friendId){
        $conversationQuery = Conversation::where(function ($query) use ($friendId) {
            $query->where('sender_id', auth()->user()->id)
                ->where('recipent_id', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('sender_id', $friendId)
                ->where('recipent_id', auth()->user()->id);
        });

        // Check if has_multiple_conversation is true
        $conversation = $conversationQuery->first();

        if ($conversation) {
            if ($conversation->has_multiple_conversation) {
                // For conversations with multiple conversations, get the latest one and update its last message as seen
                $latestConversation = $conversationQuery->latest()->first();
                if ($latestConversation && $latestConversation->lastMessage && $latestConversation->lastMessage->user_id != auth()->user()->id && !$latestConversation->lastMessage->is_seen) {
                    $latestConversation->lastMessage->update(['is_seen' => true]);
                }
            } else {
                // For single conversations, update the last message as seen
                if ($conversation->lastMessage && $conversation->lastMessage->user_id != auth()->user()->id && !$conversation->lastMessage->is_seen) {
                    $conversation->lastMessage->update(['is_seen' => true]);
                }
            }
        }

    }

    public function markAllAsRead($friendId) {
        $user = auth()->user();

        // Find all conversations with the friend
        $conversations = Conversation::where(function ($query) use ($user, $friendId) {
            $query->where('sender_id', $user->id)
                  ->where('recipent_id', $friendId);
        })->orWhere(function ($query) use ($user, $friendId) {
            $query->where('sender_id', $friendId)
                  ->where('recipent_id', $user->id);
        })->get();

        // Mark all messages in each conversation as seen
        foreach ($conversations as $conversation) {
            $messages = $conversation->messages;
            $messages->where('user_id', $friendId)
                     ->where('is_seen', false)
                     ->each(function ($message) {
                         $message->update(['is_seen' => true]);
                     });
        }
    }



    // Getting most recent message or last message between current user and his/her friends.
    public function recentMessage(){


        $latestConversations = Conversation::visibleToUser(auth()->id())
            ->with('lastMessage', 'sender', 'recipent')
            ->get();

        $filteredConversations = $latestConversations->filter(function ($conversation) {
            // Case 1: Check if the conversation is deleted by the user, don't show to the current user
            if ($conversation->isDeletedByUser(auth()->id())) {
                return false;
            }

            // Case 2: If there are multiple conversations, don't show the last message to anyone
            if ($conversation->has_multiple_conversation) {
                return false;
            }

            // Case 3: Only show the last message if it's not deleted by the current user and no multiple conversation is true
            return $conversation->lastMessage && !$conversation->lastMessage->is_deleted && !$conversation->has_multiple_conversation;
        });

        // Now $filteredConversations will contain the appropriate conversations to display
        return $filteredConversations;
    }


    /**
     *
     * Deleting Conversation
     *
     */

     public function deleteConversationHistory($conversation_id, $friend_id){

        $conversation = Conversation::findOrFail($conversation_id);

        if ($conversation) {
            // Check if the conversation is already soft deleted or deleted_by_user_id has value
            if ($conversation->has_multiple_conversation == true || $conversation->deleted_by_user_id != null && $conversation->deleted_by_user_id == $friend_id) {
                // Permanently delete the conversation
                $conversationsToDelete = Conversation::whereIn('sender_id', [$conversation->sender_id, $conversation->recipent_id])
                    ->whereIn('recipent_id', [$conversation->sender_id, $conversation->recipent_id])
                    ->where(function ($query) use ($friend_id) {
                        $query->whereIn('deleted_by_user_id', [$friend_id])
                            ->orWhere('has_multiple_conversation', true);
                    })
                    ->get();
                // Permanently delete all conversations between these users
                if(count($conversationsToDelete)>0){
                    foreach ($conversationsToDelete as $conv) {
                        foreach($conv->messages as $message) {
                            if($message->attachment_filename != null && $message->attachment_url != null){
                                Storage::deleteDirectory('public/chatify/attachment/' . $message->attachment_url);
                                // dd('attachment found for perma delete.');
                            }
                        }
                        $conv->forceDelete();
                    }
                    //$conversation->forceDelete();
                    toastr()->success('Conversation deleted!', 'Success!');
                    session()->forget('selected_friend_id');
                    return redirect()->route('chat_body');
                }
            } else {
                // set delete_by_user_id if it is first time delete
                $conversation->deleted_by_user_id = auth()->user()->id;
                $conversation->save();

                //if this $conversation is not deleted by any user but maybe user has previous conversations then
                $conversationsToDelete = Conversation::whereIn('sender_id', [$conversation->sender_id, $conversation->recipent_id])
                    ->whereIn('recipent_id', [$conversation->sender_id, $conversation->recipent_id])
                    ->where(function ($query) use ($friend_id) {
                        $query->whereIn('deleted_by_user_id', [$friend_id])
                            ->orWhere('has_multiple_conversation', true);
                    })
                    ->get();
                if(count($conversationsToDelete)>0){
                    foreach ($conversationsToDelete as $conv) {
                        if($conv->deleted_by_user_id == $friend_id){
                            foreach($conv->messages as $message) {
                                if($message->attachment_filename != null && $message->attachment_url != null){
                                    Storage::deleteDirectory('public/chatify/attachment/' . $message->attachment_url);
                                }
                            }
                            $conv->forceDelete();
                        }
                    }
                }

                toastr()->success('Conversation deleted!', 'Success!');
                session()->forget('selected_friend_id');
                return redirect()->route('chat_body');
            }

        } else {
            // Handle if the conversation with the given ID is not found
            toastr()->error('Something went wrong!', 'Error!');
        }

    }


}
