<?php

namespace App\Http\Livewire;

use App\Events\Chat;
use App\Models\TemporaryFile;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Auth\ConversationController;
use App\Jobs\Chat\SendNewMessageJob;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;



class ChatBox extends Component
{
    use WithFileUploads;

    public $filepond;
    public $imageName;
    public $imageFolderName;
    public $isFileSaved = false;

    protected $listeners = [
        'showThisFriend' => 'showChat',
        'refreshChatBox' => '$refresh',
        'refresh' => '$refresh',
    ];
    public $selectedFriendId;  // Define a property to store the friend ID

    public $friend;

    public $conversation;

    public $messageContent; // Message content to send

    public $currentPage = 1;
    public $messagesPerPage = 10; // Number of messages to display per page

    public $loadOffset = 0; // Initialize the offset for older messages

    protected $rules = ['messageContent' => 'required'];


    public function mount()
    {
        if (session()->has('selected_friend_id')) {
            $this->showChat(session('selected_friend_id'));
            // session()->forget('selected_friend_id');
        }
    }

    public function refresh()
    {
        // $this->messagesPerPage = 10;
        // $this->dispatchBrowserEvent('rowChatToBottom');

    }



    public function render()
    {
        // dd(session('selected_friend_id'));
        $userId = auth()->user()->id;
        $frnId = $this->selectedFriendId;
        /**
         * Test Code For Optimizing the query.
         */
        $this->conversation = Conversation::withFriend($frnId)
            ->visibleToUser($userId)
            ->with(['messages' => function ($query){
                $query->notSeenReceived();
            }])
            ->get();
        // load conversation with map messages
        $this->conversation = $this->conversation->map(function ($conversation) {
            return $conversation->load('messages');
        });
        $unreadCount = $this->conversation->isNotEmpty() ? $this->conversation->sum('unread_messages_count') : 0;

//        foreach ($test as $conversation) {
//            // Access the messages property on each conversation model
//            $messages = $conversation->messages;
//            dump($messages);
//        }

        /**
         * Test code ends here.
         */


        /** @var \App\Models\User $user */

//        $user = auth()->user();
//        $frn = User::find($frnId);
//
//        if($frn){
//            //  conversations() is from user model relationship
//            $unreadCount = $user->conversations()
//                ->where(function ($query) use ($frnId) {
//                    $query->where('sender_id', auth()->user()->id)
//                        ->where('recipent_id', $frnId);
//                })
//                ->orWhere(function ($query) use ($frnId) {
//                    $query->where('sender_id', $frnId)
//                        ->where('recipent_id', auth()->user()->id);
//                })
//                ->first();
//                // ->unreadMessagesCountWithFriend($frnId);
//            if($unreadCount!=null){
//                $unreadCount = $unreadCount->unreadMessagesCountWithFriend($frnId);
//            }
//        }else{
//            $unreadCount = 0;
//        }

//        // dd($unreadCount);
//
//        // From Conversation Model we are getting the all old conversation bettween our friend.
//        $conversation = new Conversation();
//        $existingConversation = $conversation->getExistingConversationWith($frnId);
//
//
//        // dd($existingConversation);
//
//
//        // If there's no existing conversation, create a new one
//        if ($existingConversation === null) {
//            $this->conversation = null;
//        } else {
//            // Load messages for each conversation
//            $this->conversation = $existingConversation->map(function ($conversation) {
//                return $conversation->load('messages');
//            });
//        }

        return view('livewire.chat-box', [
            'conversation' => $this->conversation,
        ], compact('unreadCount'));
    }



    public function showChat($frnId)
    {
        if (session()->has('selected_friend_id')) {
            $this->selectedFriendId = session('selected_friend_id');
        } else {
            $this->selectedFriendId = $frnId;
        }
        // $this->selectedFriendId = $frnId;
        $this->friend = User::find($this->selectedFriendId);
        $this->render();
    }

    /**
     *
     * Send New Message
     *
     */
    public function sendMessage($frnId)
    {
        // checking if any existing conversation or not with the specific friend
        if($this->filepond != null && $this->isFileSaved){
            // the photo is saved into local dir;
            $this->messageContent = 'sent a photo';
            $this->isFileSaved=false; // setting back to default.
        }
        $this->validate();
        $conversationController = new ConversationController();
        $conversationExists = $conversationController->checkConversation($frnId); // this returns true or false.

        if ($conversationExists) {
            // Old conversation exists

//            $existingConversation = Conversation::where(function ($query) use ($frnId) {
//                $query->where('sender_id', auth()->user()->id)
//                    ->where('recipent_id', $frnId)
//                    ->where(function ($query) {
//                        $query->whereNull('deleted_by_user_id');
//                    });
//            })
//                ->orWhere(function ($query) use ($frnId) {
//                    $query->where('sender_id', $frnId)
//                        ->where('recipent_id', auth()->user()->id)
//                        ->where(function ($query) {
//                            $query->whereNull('deleted_by_user_id');
//                        });
//                })->first();
            $existingConversation = Conversation::withFriend($frnId)
                ->visibleToUser(auth()->user()->id)
                ->whereNull('deleted_by_user_id')
                ->first();

            if ($existingConversation) {
                // there is existing conversation where no one has deleted anything
                // Create a new message
                $existingConversation->last_time_message = now();
                $existingConversation->save();
                // Your code here
                Message::create([
                    'conversation_id' => $existingConversation->id,
                    'user_id' => auth()->user()->id,
                    'content' => $this->imageName != null ? 'sent a photo' : $this->messageContent,
                    'attachment_type' => $this->imageName != null ? 'photo' : null,
                    'attachment_filename' => $this->imageName != null ? $this->imageName : null,
                    'attachment_url' => $this->imageFolderName != null ? $this->imageFolderName : null,
                    'is_seen' => false,
                ]);

                // event(new Chat($frnId, auth()->user()->id, auth()->user()->first_name, $this->messageContent));
                SendNewMessageJob::dispatch($frnId, auth()->user()->id, auth()->user()->first_name, $this->messageContent);

                // Reset message input after sending
                $this->messageContent = '';
                // Refresh the chat to display the sent message
                $this->dispatchBrowserEvent('rowChatToBottom');
                $this->emit('refresh');
                $this->refresh();
            } else {
//                $oldConv = Conversation::where(function ($query) use ($frnId) {
//                    $query->where('sender_id', auth()->user()->id)
//                        ->where('recipent_id', $frnId)
//                        ->where('deleted_by_user_id', '!=', null)
//                        ->where('has_multiple_conversation', false);
//                })
//                    ->orWhere(function ($query) use ($frnId) {
//                        $query->where('sender_id', $frnId)
//                            ->where('recipent_id', auth()->user()->id)
//                            ->where('deleted_by_user_id', '!=', null)
//                            ->where('has_multiple_conversation', false);
//                    })
//                    ->get();
                $oldConversations = Conversation::withFriend($frnId)
                    ->whereNotNull('deleted_by_user_id')
                    ->where('has_multiple_conversation', false)
                    ->get();

                if ($oldConversations->count() > 0) {
                    foreach ($oldConversations as $oldConv) {
                        $oldConv->has_multiple_conversation = true;
                        $oldConv->save();
                    }
                }
                $conversation = Conversation::create([
                    'name' => 'Conversation between ' . auth()->user()->name . ' and ' . $this->friend->name,
                    // 'type' => 'private',
                    'sender_id' => auth()->user()->id,
                    'recipent_id' => $frnId,
                    'last_time_message' => now(),
                ]);

                // Create a new message
                Message::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => auth()->user()->id,
                    'content' => $this->imageName != null ? 'sent a photo' : $this->messageContent,
                    'attachment_type' => $this->imageName != null ? 'photo' : null,
                    'attachment_filename' => $this->imageName != null ? $this->imageName : null,
                    'attachment_url' => $this->imageFolderName != null ? $this->imageFolderName : null,
                    'is_seen' => false,
                ]);

                // event(new Chat($frnId, auth()->user()->id, auth()->user()->first_name, $this->messageContent));
                SendNewMessageJob::dispatch($frnId, auth()->user()->id, auth()->user()->first_name, $this->messageContent);


                // Reset message input after sending
                $this->messageContent = '';
                $this->filepond = null;

                // Refresh the chat to display the sent message

                $this->dispatchBrowserEvent('rowChatToBottom');
                $this->emit('refresh');
                $this->refresh();
            }
        } else {
            // No conversation or New conversation
            $conversation = Conversation::create([
                'name' => 'Conversation between ' . auth()->user()->name . ' and ' . $this->friend->name,
                // 'type' => 'private',
                'sender_id' => auth()->user()->id,
                'recipent_id' => $frnId,
                'last_time_message' => now(),
            ]);

            // Create a new message
            Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => auth()->user()->id,
                'content' => $this->imageName != null ? 'sent an attachment' : $this->messageContent,
                'is_seen' => false,  // Assuming the message is not seen yet
                'attachment_type' => $this->imageName != null ? 'photo' : null,
                'attachment_filename' => $this->imageName != null ? $this->imageName : null,
                'attachment_url' => $this->imageFolderName != null ? $this->imageFolderName : null,
            ]);

            // event(new Chat($frnId, auth()->user()->id, auth()->user()->first_name, $this->messageContent));
            SendNewMessageJob::dispatch($frnId, auth()->user()->id, auth()->user()->first_name, $this->messageContent);

            // Reset message input after sending
            $this->messageContent = '';

            // Refresh the chat to display the sent message
            $this->dispatchBrowserEvent('rowChatToBottom');
            $this->emit('refresh');
            $this->refresh();
        }
    }

    /**
     *
     *
     * Delete a conversation (soft delete first)
     *
     */
    public function deleteConversation($convId, $frnId)
    {
        $eraseConversation = new ConversationController();
        $eraseConversation->deleteConversationHistory($convId, $frnId);
    }

    // Back Button
    public function goBack()
    {
        session()->forget('selected_friend_id');
        $this->friend = null;
        $this->conversation = null;
        $this->emit('refresh');
        $this->refresh();
    }

    // mark all as read
    public function markAsRead($frnId)
    {
        $markAsRead = new ConversationController();
        $markAsRead->markAllAsRead($frnId);
        $this->emit('refresh');
        $this->refresh();
    }



    public function loadMoreMessages()
    {
        // $this->currentPage++;
        $this->messagesPerPage += 10;
        // $this->loadOffset += $this->messagesPerPage; // Increase the load offset
    }


    /**
     *
     *
     * Attachment Upload in Message
     *
     *
     */
//    public function save($frnId)
//    {
//        if ($this->filepond === null) {
//            // Handle the case where no file is selected or the file has been removed
//            return;
//        }
//
//        // Validating the file as image with its size and formats.
//        $this->validate([
//            'filepond' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB Max
//        ]);
//
//        // Accessing the  file details
//        $originalName = $this->filepond->getClientOriginalName();
//
//        // Process the file as needed
//        $this->imageName = time() . '_' . $originalName;
//        $this->filepond->storeAs('chatify/attachment/', $this->imageName, 'public');
//
//        // Clear the filepond property after successful upload
//        $this->isFileSaved = true;
//
//        // Now sending the new message by adding this image as attachment.
//        $this->sendMessage($frnId);
//    }

    public function save($frnId)
    {
        $tmp_file = TemporaryFile::where('user_id', Auth::id())->latest('created_at')->first();
        if ($tmp_file && Storage::exists('public/chatify/tmp/' . $tmp_file->folder . '/' . $tmp_file->file)) {
            Storage::copy('public/chatify/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, 'public/chatify/attachment/'. $tmp_file->folder . '/' . $tmp_file->file);

            $this->filepond = 1;

            $this->imageName = $tmp_file->folder . '/' . $tmp_file->file;
            $this->imageFolderName = $tmp_file->folder;
            // Clear the filepond property after successful upload
            $this->isFileSaved = true;

            // Now Deleting the Old Temporary files from the folder.
            Storage::deleteDirectory('public/chatify/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            // Now sending the new message by adding this image as attachment.
            $this->sendMessage($frnId);
        }else{
            toastr()->error('No image found', 'Error!');
            return redirect()->route('chat_body');
        }

    }
}
