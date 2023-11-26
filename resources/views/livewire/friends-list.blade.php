<div class="col-xl-12 col-lg-6 col-md-12 col-sm-3">
    {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"> --}}
    <div class="card"wire:poll.30000ms>
        <div class="card-header bg-dark">
            <h5 class="text-center">
                <span class="btn btn-link text-white" data-bs-toggle="collapse" data-bs-target="#collapseicon8"
                    aria-expanded="true" aria-controls="collapseicon8"><i
                        class="fa-solid fa-check-circle fa-lg text-light pe-2"></i>Online Friends</span>
            </h5>
        </div>
        <div class="collapse show" id="collapseicon8" aria-labelledby="collapseicon8" data-parent="#accordion">
            <div class="card-body social-list filter-cards-view" > {{-- pool time is 30sec --}}
                {{-- <dd>{{ $friends }}</dd> --}}
                @php
                    $anyFriendOnline = false; // Initializing a variable to track if any friend is online
                @endphp
                @foreach (auth()->user()->friendslist() as $friend)
                    {{-- checking whether the friend is online or  not --}}
                    @if (Cache::has('user-is-online-' . $friend->id))
                        @php
                            $anyFriendOnline = true; // Set the variable to true if any friend is online
                        @endphp
                        <div class="media border-bottom pb-3 px-3" type="button">
                            <div class="avatars m-r-20">
                                <div class="avatar">
                                    <img class="img-50 img-fluid rounded-circle"
                                        src="/storage/{{ $friend->profile_image_path }}" alt="" type="button"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $friend->id }}">
                                    <div
                                        class="status status-60
                                @if (Cache::has('user-is-online-' . $friend->id)) bg-success
                                @else
                                    bg-warning @endif
                                ">
                                    </div>
                                </div>
                            </div>
                            {{-- <img class="img-50 img-fluid m-r-20 rounded-circle" alt=""
                                src="/storage/{{ $friend->profile_image_path }}"> --}}
                            <div class="media-body">
                                <span class="d-block pb-2">{{ $friend->name }}
                                    <i class="fa-solid fa-circle-check fa-xs text-success"></i>
                                </span>
                                <a class="f-w-600 f-12"
                                    href="{{ route('check_msg_status', ['friend_id' => $friend->id]) }}"><span
                                        class="text-success f-14"><i class="fa-regular fa-comment-dots"></i></span> Send
                                    Message</a>
                            </div>
                        </div>
                    @endif
                @endforeach
                {{-- if no friend is online then this will be executed --}}
                @if (!$anyFriendOnline)
                    <div class="text-center text-muted">No friends available!</div>
                @endif

            </div>
        </div>
    </div>
</div>
