<div class="card b-r-10" style="height: 85vh;">
    <div class="card-body chat-body">
        <div class="chat-box">
            <!-- Chat left side Start-->
            <div class="chat-left-aside">
                {{-- current user profile picture --}}
                <div class="media">
                    <div class="avatars m-r-10">
                        <div class="avatar">
                            <img class="img-50 img-fluid rounded-circle"
                                src="/storage/{{ auth()->user()->profile_image_path }}" alt="">
                            <div
                                class="status status-60
                            @if (Cache::has('user-is-online-' . auth()->user()->id)) bg-success
                            @else
                                bg-warning @endif
                            ">
                            </div>
                        </div>
                    </div>
                    <div class="media-body">
                        <div class="about">
                            @if (auth()->user()->name == null)
                                <div class="name f-w-600">No Name</div>
                            @else
                                <div class="name f-w-600">{{ auth()->user()->name }}</div>
                            @endif
                            <div class="status text-success">online</div>
                        </div>
                    </div>
                </div>
                <div class="people-list" id="people-list">
                    <div class="search">
                        {{-- Chat list message search bar --}}
                        <div class="theme-form">
                            <div class="form-group">
                                <input wire:model.debounce.500ms="searchTerm" name="searchTerm"
                                    class="form-control py-2 border-muted" type="text" placeholder="search.."><i
                                    class="fa fa-search text-muted"></i>
                            </div>
                        </div>
                    </div>
                    {{-- Search Result will be display here --}}
                    @if ($searchResults && count($searchResults) > 0)
                        <ul class="list custom-scrollbar">
                            @foreach ($searchResults as $sr)
                                <li class="clearfix">
                                    <div class="media">
                                        <div class="avatars m-r-20">
                                            <div class="avatar">
                                                <img class="img-50 img-fluid rounded-circle"
                                                    src="/storage/{{ $sr->profile_image_path }}" alt="">
                                                <div
                                                    class="status status-60
                                            @if (Cache::has('user-is-online-' . $sr->id)) bg-success
                                            @else
                                                bg-warning @endif
                                            ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="about">
                                                <div class="name">{{ $sr->first_name . ' ' . $sr->last_name }}</div>
                                                {{-- <a href="{{ route('check_msg_status',['friend_id'=>$sr->id]) }}">Send
                                                    Message</a> --}}
                                                <div class="status"><a href="#"
                                                        wire:click="openThisChatUser({{ $sr->id }})">Send
                                                        Message</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- If no search results then this will be displayed --}}
                    @if (!$searchResults)
                        <ul class="list custom-scrollbar" wire:poll.5s>
                            {{-- Display Friends with their last conversation --}}
                            @foreach ($lastConversations as $conversation)
                                <li class="clearfix py-2">
                                    <div>
                                        <h4>
                                            {{--
                                                Key Points To Remember :
                                                1) A current user can be either sender or 'sender_id'. (conversation model )
                                                2) A current user can be either receiver or 'recipent_id'.
                                                3) These fields data varies in both possible coditions.
                                                4) we are also checking whether the message is seen or not seen 'is_seen' and this field is in message table.

                                                5) conversation->recipent->id returns the id of the user who is receiver
                                                6) conversation->sender->id returns the id of the user who is sender (this is from Eloquent Relationship)


                                                --}}

                                            {{-- If the conversation sender is the current user then this if blocks execute. --}}
                                            @if ($conversation->sender_id == auth()->user()->id)
                                                {{-- @dd($conversation->recipent->id) --}}

                                                <div class="media chatmedia
                                                        @if ($conversation->recipent->id == session('selected_friend_id')) bg-light b-r-5 shadow border-secondary @endif
                                                            p-2"
                                                    wire:click='openThisChatUser({{ $conversation->recipent->id }})'>
                                                    <div class="avatars m-r-20">
                                                        <div class="avatar">
                                                            <img class="img-50 img-fluid rounded-circle"
                                                                src="/storage/{{ $conversation->recipent->profile_image_path }}"
                                                                alt="">
                                                            <div
                                                                class="status status-60
                                                        @if (Cache::has('user-is-online-' . $conversation->recipent->id)) bg-success
                                                        @else
                                                            bg-warning @endif
                                                        ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="media-body pt-2">
                                                        <span
                                                            class="text-muted f-14 d-block">{{ $conversation->recipent->first_name }}
                                                        </span>
                                                        @if ($conversation->lastMessage->user_id != auth()->user()->id && !$conversation->lastMessage->is_seen)
                                                            <a class="f-12 f-w-600 text-dark"
                                                                id="lastMessage{{ $conversation->recipent->id }}">
                                                                {{ $conversation->lastMessage ? Illuminate\Support\Str::limit($conversation->lastMessage->content, 10) : 'No messages yet' }}
                                                            </a>
                                                        @else
                                                            <a class="f-12"
                                                                id="lastMessage{{ $conversation->recipent->id }}"
                                                                wire:click="openThisChatUser({{ $conversation->recipent->id }})">
                                                                @if ($conversation->lastMessage->user_id == auth()->user()->id)
                                                                    {{ ' You : ' }}
                                                                @endif
                                                                {{ $conversation->lastMessage ? Illuminate\Support\Str::limit($conversation->lastMessage->content, 10) : 'No messages yet' }}
                                                            </a>
                                                        @endif
                                                        <span>
                                                            @if ($conversation->unreadMessagesCountWithFriend($conversation->recipent->id) > 0)
                                                                <span class="text-danger f-14 f-w-600 f-right pt-2">
                                                                    {{ $conversation->unreadMessagesCountWithFriend($conversation->recipent->id) }}
                                                                    <i class="fa-solid fa-envelope"></i>
                                                                </span>
                                                            @endif
                                                        </span>

                                                        {{-- Pusher script for realtime message --}}
                                                        <script>
                                                            var pusher = new Pusher('39d8b4ffd7de9257d701', {
                                                                cluster: 'ap2'
                                                            });
                                                            var channel3 = pusher.subscribe('newMsg-channel');
                                                            channel3.bind('new-message', function(data) {
                                                                if (data.senderId == {{ $conversation->recipent->id }} && data.recieverId ==
                                                                    {{ auth()->user()->id }}) {
                                                                    // document.getElementById('lastMessage{{ $conversation->recipent->id }}').innerText = data.message;
                                                                    var element = document.getElementById('lastMessage{{ $conversation->recipent->id }}');
                                                                    var timeElement = document.getElementById('lastMessageTime{{ $conversation->recipent->id }}');
                                                                    timeElement.innerText = '1 second ago';
                                                                    var message = data.message; // Assuming $data is a JavaScript object or a variable with the message
                                                                    if (message.length > 10) {
                                                                        message = message.substring(0, 8) + '...'; // Limiting to 50 characters
                                                                    }

                                                                    element.innerText = message;
                                                                    element.className = "f-12 f-w-800 text-dark";
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                    <span class=" text-muted f-12 f-right pt-2"
                                                        id="lastMessageTime{{ $conversation->recipent->id }}"><i
                                                            class="fa-regular fa-clock"></i>
                                                        {{ str_replace(' ago', '', $conversation->lastMessage->created_at->diffForHumans()) }}</span>
                                                </div>
                                            @else
                                                {{-- {{ $conversation->sender->name }} (ID: {{ $conversation->sender->id }}) --}}

                                                {{-- profile picture of the last message sender. it might be either current user or his/her friend. --}}
                                                <div class="media chatmedia
                                                        @if ($conversation->sender->id == session('selected_friend_id')) bg-light b-r-5 shadow @endif
                                                        p-2"
                                                    wire:click='openThisChatUser({{ $conversation->sender->id }})'>
                                                    <div class="avatars m-r-20">
                                                        <div class="avatar">
                                                            <img class="img-50 img-fluid rounded-circle"
                                                                src="/storage/{{ $conversation->sender->profile_image_path }}"
                                                                alt="">
                                                            <div
                                                                class="status status-60
                                                        @if (Cache::has('user-is-online-' . $conversation->sender->id)) bg-success
                                                        @else
                                                            bg-warning @endif
                                                        ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="media-body pt-2">
                                                        <span
                                                            class="text-muted f-14 d-block">{{ $conversation->sender->first_name }}
                                                        </span>
                                                        {{-- If the last message is not seen and the last message sender is by not the current user --}}
                                                        @if ($conversation->lastMessage->user_id != auth()->user()->id && !$conversation->lastMessage->is_seen)
                                                            <a class="f-12 f-w-600 text-dark"
                                                                id="lastMessage{{ $conversation->sender->id }}">
                                                                {{ $conversation->lastMessage ? Illuminate\Support\Str::limit($conversation->lastMessage->content, 10) : 'No messages yet' }}
                                                            </a>
                                                        @else
                                                            {{-- If the last message is seen and the last message sender is not by the current user --}}

                                                            <a class="f-12"
                                                                id="lastMessage{{ $conversation->sender->id }}">
                                                                @if ($conversation->lastMessage->user_id == auth()->user()->id)
                                                                    {{ ' You : ' }}
                                                                @endif
                                                                {{ $conversation->lastMessage ? Illuminate\Support\Str::limit($conversation->lastMessage->content, 10) : 'No messages yet' }}
                                                            </a>
                                                        @endif
                                                        <span>
                                                            {{-- here we are counting the unread last message. --}}
                                                            @if ($conversation->unreadMessagesCountWithFriend($conversation->sender->id) > 0)
                                                                <span class="text-danger f-14 f-w-600 f-right pt-2">
                                                                    {{ $conversation->unreadMessagesCountWithFriend($conversation->sender->id) }}
                                                                    <i class="fa-solid fa-envelope"></i>
                                                                </span>
                                                            @endif
                                                        </span>

                                                        <script>
                                                            var pusher = new Pusher('39d8b4ffd7de9257d701', {
                                                                cluster: 'ap2'
                                                            });

                                                            var channel3 = pusher.subscribe('newMsg-channel');
                                                            channel3.bind('new-message', function(data) {
                                                                if (data.senderId == {{ $conversation->sender->id }} && data.recieverId == {{ auth()->user()->id }}) {
                                                                    // document.getElementById('lastMessage{{ $conversation->sender->id }}').innerText = data.message;
                                                                    var element = document.getElementById('lastMessage{{ $conversation->sender->id }}');
                                                                    var timeElement = document.getElementById('lastMessageTime{{ $conversation->sender->id }}');
                                                                    timeElement.innerText = '1 second ago';
                                                                    // element.innerText = data.message;
                                                                    var message = data.message; // Assuming $data is a JavaScript object or a variable with the message
                                                                    if (message.length > 10) {
                                                                        message = message.substring(0, 8) + '...'; // Limiting to 50 characters
                                                                    }

                                                                    element.innerText = message;
                                                                    element.className = "f-12 f-w-600 text-dark";
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                    <span class=" text-muted f-right f-12 d-block pt-2"
                                                        id="lastMessageTime{{ $conversation->sender->id }}"><i
                                                            class="fa-regular fa-clock"></i>
                                                        {{ str_replace(' ago', '', $conversation->lastMessage->created_at->diffForHumans()) }}
                                                    </span>

                                                </div>
                                            @endif
                                        </h4>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <style>
                            .chatmedia:hover {
                                cursor: pointer;
                                background-color: rgb(234, 231, 231);
                                border-radius: 5px;
                            }
                        </style>


                    @endif
                </div>
            </div>
            <!-- Chat left side Ends-->
        </div>
    </div>
</div>
