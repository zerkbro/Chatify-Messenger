<div wire:poll.10s>
    @if ($friend)
        <div class="card b-r-10" style="height: 85vh;">
            <div class="card-body p-0">
                <div class="row chat-box d-flex justify-content-center align-items-center">
                    <!-- Chat right side start-->

                    <div class="col chat-right-aside">
                        <!-- chat start-->
                        <div class="chat">
                            {{-- chat box header section --}}
                            <div class="media chat-header clearfix">
                                <button class="btn d-flex align-self-center" wire:click='goBack'>
                                    <i class="fa-solid fa-arrow-left-long fa-2xl f-20 text-secondary"></i>
                                </button>
                                <div class="avatars">
                                    <div class="avatar">
                                        <img class="rounded-circle" src="/storage/{{ $friend->profile_image_path }}"
                                            alt="">
                                        <div
                                            class="status status-60
                                        @if (Cache::has('user-is-online-' . $friend->id)) bg-success
                                        @else
                                            bg-warning @endif
                                        ">
                                        </div>

                                    </div>
                                </div>
                                {{-- current conversation friend header details --}}
                                <div class="media-body">
                                    <div class="about">
                                        <div class="name">{{ $friend->name }}
                                            @if (Cache::has('user-is-online-' . $friend->id))
                                                <span class="text-success f-12">online</span>
                                            @else
                                                <span class="text-warning f-12">offline</span>
                                            @endif
                                        </div>
                                        <div class="status digits">Last Seen
                                            {{ \Carbon\Carbon::parse($friend->last_seen)->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                @if (isset($unreadCount) && $unreadCount > 0)
                                    <div class="f-right p-r-20 chat-menu-icons">
                                        <button class="btn text-danger"
                                            wire:click='markAsRead({{ $friend->id }})'>Mark All Read <i
                                                class="fa-solid fa-envelope"></i></button>
                                    </div>
                                @endif

                                <ul class="list-inline float-start float-sm-end chat-menu-icons">
                                    <li class="list-inline-item toogle-bar" ><a href="javascript:void(0)">
                                            <i class="fa-solid fa-circle-info"></i></a></li>
                                </ul>
                            </div>

                            {{-- Chat History or Convesations loads --}}
                            <div class="chat-history chat-msg-box custom-scrollbar chatbox_body" style="height: 65vh;"
                                id="chat-history">
                                <ul id="message-list">
                                    @if ($conversation->isNotEmpty())
                                        {{-- counting how many conversations does a user have --}}
                                        @foreach ($conversation as $conv)
                                            {{-- Load More Message Button --}}
                                            @if ($conv->messages->count() > $messagesPerPage)
                                                <div class="d-flex justify-content-center align-self-center mb-2">
                                                    <button class="btn btn-light text-secondary rounded-pill" wire:click="loadMoreMessages">
                                                        <i class="fa-solid fa-arrow-down-long"></i> Load More
                                                    </button>
                                                </div>
                                            @endif

                                            @foreach ($conv->messages as $message)
                                                <li class="{{ $message->user_id === auth()->user()->id ? 'clearfix' : '' }}">
                                                    <div class="message
                                                    @if ($message->sender->id != auth()->user()->id && $message->getUnreadMessageIdAttribute() != null) bg-light @endif
                                                    {{ $message->user_id === auth()->user()->id ? 'other-message pull-right float-end border-success' : 'my-message border-secondary shadow' }}">

                                                        <div class="message-data {{ $message->user_id === auth()->user()->id ? '' : 'text-end' }}">
                                                            <span class="f-12 text-muted"><i class="fa-regular fa-clock"></i> {{ $message->created_at->diffForHumans() }}</span>
                                                        </div>

                                                        @if ($message->sender->id === auth()->user()->id)
                                                            @if ($message->is_seen)
                                                                @if($message->attachment_type != null)
                                                                    {{-- Attachment seen by the receiver --}}
                                                                    <div class="text-center">
                                                                        <a href="{{ asset('storage/chatify/attachment/' . $message->attachment_filename) }}">
                                                                            <img src="{{ asset('storage/chatify/attachment/' . $message->attachment_filename) }}" class="rounded" alt="..." height="400px" width="400px">
                                                                        </a>
                                                                    </div>
                                                                    <img class="rounded-circle f-right img-20" src="/storage/{{ $friend->profile_image_path }}" alt="">
                                                                @else
                                                                    {{-- No attachment, message seen by the receiver --}}
                                                                    {{ $message->content }}
                                                                    <img class="rounded-circle f-right img-20" src="/storage/{{ $friend->profile_image_path }}" alt="">
                                                                @endif
                                                            @else
                                                                {{-- Attachment not seen by the receiver --}}
                                                                @if($message->attachment_type != null)
                                                                    <div class="text-center">
                                                                        <a href="{{ asset('storage/chatify/attachment/' . $message->attachment_filename) }}">
                                                                            <img src="{{ asset('storage/chatify/attachment/' . $message->attachment_filename) }}" class="rounded" alt="..." height="400px" width="400px">
                                                                        </a>
                                                                    </div>
                                                                    <span class="f-right"><i class="fas fa-check"></i> sent</span>
                                                                @else
                                                                    {{-- No attachment, message not seen by the receiver --}}
                                                                    {{ $message->content }} <span class="f-right"><i class="fas fa-check"></i> sent</span>
                                                                @endif
                                                            @endif
                                                        @else
                                                            {{-- Receiver section (Left side message) --}}
                                                            @if($message->attachment_type != null)
                                                                <div class="text-center">
                                                                    <a href="{{ asset('storage/chatify/attachment/' . $message->attachment_filename) }}">
                                                                        <img src="{{ asset('storage/chatify/attachment/' . $message->attachment_filename) }}" class="rounded" alt="..." height="400px" width="400px">
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <span class="f-14">{{ $message->content }}</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    @else
                                        {{-- If there is blank or now messages between the current user and the friend --}}
                                        <div class="d-flex justify-content-center align-items-center text-center
                                        f-30 text-muted bg-white"
                                            style="height: 50vh;">Start sending new messages</div>
                                    @endif
                                </ul>
                            </div>

                            {{-- message send area  --}}
                            <div class="chat-message">
                                <div class="row">
                                    <div class="col-xl-12 d-flex">

                                        <div class="smiley-box d-flex"
                                             class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                             type="button">
                                            <div class="bg-light align-self-center ">
                                                <i class="fa-solid fa-link fa-xl text-muted"></i>
                                            </div>
                                        </div>
                                        <form wire:submit.prevent="sendMessage({{ $friend->id }})"
                                            class="form-control bg-light">
                                            <div class="input-group text-box">
                                                {{-- inside the input field the selected emoji should go --}}
                                                <input
                                                    class="form-control @error('messageContent') is-invalid @enderror"
                                                    type="text" wire:model="messageContent" id="inputMessage"
                                                    name="messageContent" placeholder="Type a message......">

                                                <button class="btn btn-dark input-group-text"
                                                    type="submit">SEND</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Emoji Selector Script -->
                                <!-- Vertically centered modal -->
                                <!-- Modal -->
                                <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore>
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form wire:submit.prevent="save({{$friend->id}})">
                                            <div class="modal-body">
                                                {{-- file upload from modal --}}
{{--                                                <input type="file" wire:model="filepond" />--}}
                                                @error('filepond')
                                                        <span class="text-danger">{{ $message }}</span>
                                                @enderror

{{--                   File pond Upload Section. Disable the above input file to use the below on--}}
                                                <input type="file" wire:model="filepond" class="my-pond" name="filepond" />


                                                <!-- This container is just for the demo -->

                                                {{-- file upload from modal --}}
                                            </div>
                                            <div class="modal-footer">
{{--                                                <button type="button" class="btn btn-info text-light" data-bs-dismiss="modal">Close</button>--}}
                                                <button type="submit" class="btn btn-primary text-white">Attach</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                {{--    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script> --}}

                                <!-- add before </body> -->
                                <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
                                <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
                                <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
                                <script>
                                    $(function(){

                                        // First register any plugins
                                        $.fn.filepond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);

                                        // Turn input element into a pond

                                        $('.my-pond').filepond();
                                        // Set allowMultiple property to true

                                        $('.my-pond').filepond('imagePreviewHeight', 500);
                                        $('.my-pond').filepond('allowMultiple', false);
                                        $('.my-pond').filepond('acceptedFileTypes', ['image/*']);

                                        // Listen for addfile event
                                        $('.my-pond').on('FilePond:addfile', function(e) {
                                            console.log('file added event', e);
                                        });

                                        FilePond.setOptions({
                                            server: {
                                                process: '/tmp-upload',
                                                revert: '/tmp-delete',
                                                headers:{
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                }
                                            },
                                        });



                                    });
                                </script>

                            </div>
                        </div>
                    </div>

                    {{-- Emoji script --}}

                    {{-- Opens Info Area in the chat box --}}
                    <div class="col chat-menu">
                        <ul class="nav nav-tabs border-tab nav-primary" id="info-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link" id="contact-info-tab" data-bs-toggle="tab"
                                    href="#info-contact" role="tab" aria-selected="false">
                                    PROFILE</a>
                                <div class="material-border"></div>
                            </li>
                        </ul>
                        <div class="tab-content" id="info-tabContent">
                            <div class="tab-pane fade show active" id="info-profile" role="tabpanel"
                                aria-labelledby="profile-info-tab">
                                <div class="user-profile ">
                                    <div class="image">
                                        <div class="avatar text-center"><img alt=""
                                                src="/storage/{{ $friend->profile_image_path }}"></div>
                                    </div>
                                    <div class="user-content text-center">
                                        <h5 class="text-uppercase">{{ $friend->name }}</h5>
                                        <div class="text-center digits">
                                            <p class="text-muted py-3">Email : {{ $friend->email }}</p>
                                        </div>
                                        <div class="text-center">
                                            {{-- @if ($conversation) --}}
                                            @if (isset($conv) && $conv)
                                                <a href="#" class="btn btn-danger " type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalCenter{{ $friend->id }}"
                                                    data-bs-original-title="" title="">Delete Conversation</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Model start of delete conversation --}}
            <div class="modal fade" id="exampleModalCenter{{ $friend->id }}" tabindex="-1"
                aria-labelledby="exampleModalCenter{{ $friend->id }}" style="display: none;" aria-modal="true"
                role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Conversation with {{ $friend->first_name }}</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                                data-bs-original-title="" title=""></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure! want to delete this conversation?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-dark" type="button" data-bs-dismiss="modal"
                                data-bs-original-title="" title="">Cancel</button>
                            {{-- @if ($conversation) --}}
                            @if (isset($conv) && $conv)
                                <button class="btn btn-danger" type="button" data-bs-original-title=""
                                    title=""
                                    wire:click="deleteConversation({{ $conv->id }}, {{ $friend->id }})">Yes</button>
                            @endif
                            {{-- @endif --}}
                            {{-- <dd>{{ $conv->id }}</dd> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- end of delete conversation --}}
        </div>


        @if (session()->has('selected_friend_id'))
{{--            <script>--}}
{{--                $(document).ready(function() {--}}
{{--                    // This function scrolls the chat-history to the bottom--}}
{{--                    function scrollToBottom() {--}}
{{--                        var chatHistory = $('#chat-history');--}}
{{--                        chatHistory.scrollTop(chatHistory[0].scrollHeight);--}}
{{--                    }--}}

{{--                    // Call the function to scroll to the bottom when the page loads or new messages are added--}}
{{--                    scrollToBottom();--}}
{{--                });--}}
{{--            </script>--}}
{{--        @else--}}
            <div wire:ignore>
                <script>
                    $(document).ready(function() {
                        // This function scrolls the #chat-history to the bottom of the page. WHich is current position
                        function scrollToBottom() {
                            var chatHistory = $('#chat-history');
                            chatHistory.scrollTop(chatHistory[0].scrollHeight);
                        }

                        // Calling the function to scroll to the bottom when the page loads or new messages are added
                        scrollToBottom();
                    });
                </script>
            </div>
        @endif
    @else
        {{-- Default chatbox information --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="row chat-box d-flex justify-content-center align-items-center">
                    <div class="col chat-right-aside">
                        <!-- chat start-->
                        <div class="d-flex justify-content-center align-items-center text-center
                            f-30 text-muted bg-white"
                            style="height: 85vh;">Start or select a conversation</div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- Real time message update  --}}
    @if ($friend && $friend->id)
        @push('scripts')
            <script>
                // Pusher.logToConsole = false;
                var pusher = new Pusher('39d8b4ffd7de9257d701', {
                    cluster: 'ap2'
                });
                // check $user->conversations->id
                var channel36 = pusher.subscribe('newMsg-channel');
                channel36.bind('new-message', function(data) {
                    // if (data.senderId == {{ $friend->id }} && data.recieverId == {{ auth()->user()->id }}) {
                    if (data.senderId == {{ session('selected_friend_id') }} && data.recieverId ==
                        {{ auth()->user()->id }}) {
                        // Create a list item for the message
                        var li = document.createElement('li');
                        li.className = '';

                        // Create the message container div
                        var messageDiv = document.createElement('div');
                        messageDiv.className = 'message my-message bg-light border-secondary';

                        // Create the message data div
                        var messageDataDiv = document.createElement('div');
                        messageDataDiv.className = 'message-data text-end';
                        messageDataDiv.innerHTML = '<span class="f-12 text-muted">1 seconds ago</span>';

                        // Create the message content span
                        var messageContentSpan = document.createElement('span');
                        messageContentSpan.className = 'f-14';
                        messageContentSpan.innerText = data.message;

                        // Append the message content span to the message div
                        messageDiv.appendChild(messageDataDiv);
                        messageDiv.appendChild(messageContentSpan);

                        // Append the message div to the list item
                        li.appendChild(messageDiv);

                        // Append the list item to the message list
                        var messageList = document.getElementById('message-list');
                        if ({{ $friend->id }} == data.senderId) {
                            messageList.appendChild(li);

                            window.addEventListener('rowChatToBottom', event => {
                                $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
                            });
                        }

                        // const audio = new Audio('/talkster/sounds/newmessage.mp3');
                        // audio.muted = false;  // Automatically muted to allow autoplay
                        // audio.volume = 1;
                        // audio.play();
                    }
                });
            </script>
        @endpush
    @endif

{{--    @push('scripts')--}}
{{--        <script>--}}
{{--            window.addEventListener('rowChatToBottom', event => {--}}
{{--                $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endpush--}}
</div>
