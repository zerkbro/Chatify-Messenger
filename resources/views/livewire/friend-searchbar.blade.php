{{-- Search bar to perform search --}}
<div>

    <div class="row justify-content-center">
        <div class="text-center mt-5">
            <div class="text-muted mb-2">
                <h2>Search New Friends</h2>
            </div>
        </div>
        <div class="col-sm-6">
            {{-- <form> --}}
            <div class="form-group mt-3 mb-5">
                <div class="input-group">
                    {{-- <input wire:model.debounce.1000ms="searchTerm" name="searchTerm" --}}
                    <input wire:model.lazy="searchTerm" name="searchTerm"
                        class="form-control rounded-pill py-3 border-secondary shadow" type="search"
                        placeholder="Search...">
                </div>
            </div>
            {{-- </form> --}}

        </div>
        {{-- Showing The Search Results Here --}}
        @if ($searchResults && count($searchResults) > 0)
            <div class="row shadow align-items-center justify-content-center">
                <div class="text-center mt-5">
                    <div class="text-muted mb-4">
                        <h3>Search Result</h3>
                    </div>
                    <div class="border-top border-bottom mb-5"></div>
                </div>
                <!-- Display searched friends -->
                @foreach ($searchResults as $sr)
                    @php
                        $friendshipStatus = auth()
                            ->user()
                            ->getFriendshipStatusWith($sr);
                    @endphp
                    <div class="col-md-3 col-lg-3 col-xl-3 box-col-6 border-bottom ">
                        <div class="card custom-card">
                            <div class="card-profile">
                                <img class="rounded-circle" src="{{ asset('storage/' . $sr->profile_image_path) }}"
                                    style="max-width: 200px; max-height: 200px; height: 100%; width: 100%"
                                    alt="">
                            </div>
                            <div class="text-center profile-details">
                                {{-- Opening friend profile model here --}}
                                <button class="btn" data-bs-toggle="modal" data-original-title="test"
                                    data-bs-target="#exampleModal{{ $sr->id }}" data-bs-original-title=""
                                    title="">
                                    <h4>{{ $sr->first_name . ' ' . $sr->last_name }}</h4>
                            </button>
                                @if ($friendshipStatus === 'accepted')
                                    @if (Cache::has('user-is-online-' . $sr->id))
                                        <h6 class="text-success"><i class="fa-solid fa-circle-check fa-lg"></i> online
                                        </h6>
                                    @else
                                        <h6 class="text-warning"><i class="fa-solid fa-moon fa-lg"></i> offline</h6>
                                    @endif
                                @else
                                    <h6>Bio Here</h6>
                                @endif
                            </div>
                            <div class="card-footer row">
                                <div class="col-6 col-sm-6">
                                    <h6>Friends</h6>

                                    {{-- <h3 class="counter">696</h3> --}}
                                    @if ($friendshipStatus === 'accepted')
                                        <h3 class="counter">
                                            @php
                                                $friendCount = count($sr->fofList($sr->id));
                                            @endphp
                                            @foreach ($sr->fofList($sr->id)->take(3) as $frn)
                                                <img class="rounded-circle img-30"
                                                    src="{{ asset('storage/' . $frn->profile_image_path) }}"
                                                    alt="">
                                            @endforeach

                                            @if ($friendCount > 3)
                                                <span class="text-muted f-12">+{{ $friendCount - 3 }}</span>
                                            @endif
                                        </h3>
                                    @else
                                        <h3 class="counter">
                                            @if (count($sr->fofList($sr->id)) == 0)
                                                <span class="text-danger f-14">New To Chatify!</span>
                                            @else
                                                {{ count($sr->fofList($sr->id)) }}
                                            @endif
                                        </h3>
                                    @endif


                                    <dd>
                                        {{-- {{ auth()->user()->mutualFriends }} --}}
                                    </dd>

                                </div>
                                <div class="col-6 col-sm-6">
                                    @if ($friendshipStatus === 'accepted')
                                        <span class="text-success">Already friends</span>
                                        <button class="btn btn-dark mt-2">
                                            <a href="{{ route('check_msg_status', ['friend_id' => $sr->id]) }}"
                                                class="text-white"><span class="text">Send Message</span></a>
                                        </button>
                                    @elseif($friendshipStatus === 'pending')
                                        {{-- further more checking if request is sent or recieved. --}}
                                        @if (auth()->user()->hasPendingFriendRequest($sr->id))
                                            {{-- If current user has already incomming request from this user $sr->id --}}
                                            <button class="btn btn-success rounded-pill"
                                                wire:click="acceptNewRequest({{ $sr->id }})">Accept</button>
                                            <button class="btn btn-danger rounded-pill mt-2"
                                                wire:click="removeNewRequest({{ $sr->id }})">Decline</button>
                                        @else
                                            <button class="btn btn-success mt-2"
                                                wire:click="cancelRequest({{ $sr->id }})">Cancel Request</button>
                                        @endif
                                    @else
                                        {{-- <span class="text danger">status here</span> --}}
                                        <button class="btn btn-dark mt-2 "
                                            wire:click="addNewFriend({{ $sr->id }})">Add Friend</button>
                                    @endif
                                    {{-- @dd(auth()->user()->hasPendingFriendRequest($sr->id)) --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('auth.frontend.user.friend.search_profile_details')
                @endforeach
            </div>
        @endif

    </div>


    {{-- If there are suggested users, display them --}}

    {{-- display the suggested friends only when there is no search result --}}
    @if (!$searchResults)
        <div class="row shadow">
            <div class="text-center mt-5">
                <div class="text-muted mb-4">
                    <h3>Suggested Friends</h3>
                </div>
                <div class="border-top border-bottom mb-5"></div>
            </div>

            @if ($suggestedUsers && count($suggestedUsers) > 0)
                <div class="row justify-content-center">
                    @foreach ($suggestedUsers as $su)
                        <div class="col-md-3 col-lg-3 col-xl-3 box-col-6 border-bottom">
                            <div class="card custom-card">
                                <div class="card-profile"><img class="rounded-circle "
                                        src="{{ asset('storage/' . $su->profile_image_path) }}" alt=""
                                        style="max-width:200px; max-height: 200px; height: 100%; width:100%"></div>

                                <div class="text-center profile-details">
                                    <button class="btn" data-bs-toggle="modal" data-original-title="test"
                                    data-bs-target="#exampleModal{{ $su->id }}" data-bs-original-title=""
                                    title="">
                                        <h4>{{ $su->first_name . ' ' . $su->last_name }}</h4>
                                    </button>
                                    <h6>{{ $su->user_bio!=null ? $su->user_bio : 'Bio Here' }}</h6>
                                </div>

                                <div class="card-footer row">
                                    <div class="col-6 col-sm-6">
                                        <h6>Friends</h6>
                                        {{-- <h3 class="counter">956</h3> --}}
                                        @if (count($su->fofList($su->id)) > 0)
                                            <h3 class="counter">{{ count($su->fofList($su->id)) }}</h3>
                                        @else
                                            <h3 class="counter"><span class="text-danger f-12">New to Chatify!</span>
                                            </h3>
                                        @endif
                                    </div>
                                    <div class="col-6 col-sm-6">
                                        <button class="btn btn-dark mt-2"
                                            wire:click="addNewFriend({{ $su->id }})">Add Friend </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- open profile details model for suggested users. --}}
                        @include('auth.frontend.user.friend.suggested_profile_details')


                    @endforeach
                </div>
            @else
                <div class="text-center text-danger">No suggestations at the moment!</div>
            @endif

        </div>
    @endif
    {{-- @dd(auth()->user()->friendship) --}}

</div>
