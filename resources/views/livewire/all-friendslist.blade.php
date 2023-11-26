<div class="col-xl-12 col-lg-6 col-md-12 col-sm-3 ">
    <div class="card">
        <div class="card-header bg-dark">
            <h5 class="text-center">
                <span class="btn btn-link text-white" data-bs-toggle="collapse" data-bs-target="#collapseicon4"
                    aria-expanded="true" aria-controls="collapseicon4"><span class="text-light f-14 pe-2"><i
                            class="fa-solid fa-users fa-lg"></i></span>All Friends (
                    {{ count(auth()->user()->friendslist()) }} )</span>
            </h5>
        </div>
        {{-- All Friend lists here --}}
        <div class="collapse show scroll-bar" id="collapseicon4" aria-labelledby="collapseicon4"
            data-parent="#accordion">
            <div class="card-body social-list filter-cards-view">
                @foreach (auth()->user()->friendslist() as $friend)
                    <div class="media border-bottom pb-2 friendBox">
                        <div class="avatars m-r-20 p-2 pt-2">
                            <div class="avatar">
                                <img class="img-60 img-fluid rounded-circle"
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
                        <div class="media-body p-2">
                            <span class="d-block">{{ $friend->name }}
                                @if (Cache::has('user-is-online-' . $friend->id))
                                    <span class="text-success f-12">online</span>
                                @else
                                    <span class="text-warning f-12">offline</span>
                                @endif

                            </span><a class="f-w-600 f-12"
                                href="{{ route('check_msg_status', ['friend_id' => $friend->id]) }}"><span
                                    class="text-success f-14"><i class="fa-regular fa-comment-dots"></i></span> Send
                                Message</a>
                            <button class="btn text-muted" type="button" data-bs-toggle="modal"
                                data-original-title="test" data-bs-target="#exampleModal{{ $friend->id }}"
                                data-bs-original-title="" title=""><span class="f-12 text-muted"><i
                                        class="fa-solid fa-id-badge fa-lg"></i> Profile</span></button>
                        </div>
                    </div>

                    {{--

                            This section opens when Profile Details is clicked

                        --}}

                    {{-- Friend Details Modal Section --}}
                    <div class="modal fade" id="exampleModal{{ $friend->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel"><i
                                            class="fa-regular fa-address-card"></i> Profile Details</h4>

                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                                        data-bs-original-title="" title=""></button>
                                </div>
                                <div class="modal-body">
                                    {{-- Friend Profile Picture --}}
                                    <div class="d-flex justify-content-center p-3">
                                        <div class="row gallery my-gallery" id="aniimated-thumbnials1" itemscope=""
                                            data-pswp-uid="7">
                                            <figure class="col-md-3 img-hover hover-1" itemprop="associatedMedia"
                                                itemscope="">
                                                <a href="{{ asset('storage/' . $friend->profile_image_path) }}"
                                                    itemprop="contentUrl">
                                                    <div><img class="rounded-pill"
                                                            src="/storage/{{ $friend->profile_image_path }}"
                                                            itemprop="thumbnail" alt="Image description" height="170px"
                                                            width="170px"></div>
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                    {{-- Friend Name & online status --}}
                                    <div class="f-w-600 f-20 text-center pt-4 friendName"><i
                                            class="fa-regular fa-user"></i>
                                        {{ $friend->first_name . ' ' . $friend->last_name }}

                                        @if (Cache::has('user-is-online-' . $friend->id))
                                            <span class="badge bg-success f-12 rounded-pill text-light">online</span>
                                        @else
                                            <span
                                                class="badge badge-warning f-12 rounded-pill text-light">offline</span>
                                        @endif
                                        {{-- </h5> --}}
                                    </div>

                                    {{-- Last Time Active Status --}}
                                    <div class="text-center border-bottom pb-3 pt-2">
                                        <span class="text-muted f-12">Last Time Active :
                                            {{ $friend->last_seen ? Carbon\Carbon::parse($friend->last_seen)->diffForHumans() : 'unknown' }}</span>
                                    </div>

                                    {{-- Friend Gender --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-solid fa-venus-mars"></i>
                                            Gender</span>
                                        <span
                                            class="text-secondary">{{ $friend->gender ? $friend->gender : 'Not Mention' }}</span>
                                    </div>
                                    {{-- Friend Email Address --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-regular fa-envelope"></i> Email</span>
                                        <span class="text-secondary">{{ $friend->email }}</span>
                                    </div>
                                    {{-- Friend Phone Number --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-solid fa-mobile-screen-button"></i>
                                            Phone Number</span>
                                        @if ($friend->phone != null)
                                            <span class="text-secondary">
                                                {{ $friend->phone }}
                                            </span>
                                        @else
                                            <span class="text-secondary">
                                                Not Mention
                                            </span>
                                        @endif
                                    </div>
                                    {{-- Friend Address --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-sharp fa-solid fa-location-dot"></i>
                                            Address</span>
                                        @if ($friend->address != null)
                                            <span class="text-secondary">
                                                {{ $friend->address }}
                                            </span>
                                        @else
                                            <span class="text-secondary">
                                                Not Mention
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Friendship Since --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-regular fa-calendar"></i> Friendship
                                            Since</span>
                                        <span
                                            class="text-secondary">{{ optional(auth()->user()->getDetailOfFriendship($friend))->created_at->format('d M Y, h:i A') }}</span>
                                    </div>

                                    {{-- Friend Lists of Friends --}}
                                    <div class="d-flex align-items-center justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-solid fa-users-line"></i> Friends
                                            With</span>
                                        <span class="text-muted">
                                            @if (count(auth()->user()->fofList($friend->id)) != 0)
                                                @foreach (auth()->user()->fofList($friend->id) as $fof)
                                                    <img class="img-30 img-fluid rounded-circle bg-dark"
                                                        src="/storage/{{ $fof->profile_image_path }}" alt=""
                                                        data-container="body" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title=""
                                                        data-bs-original-title="{{ $fof->name }}">
                                                @endforeach
                                            @else
                                                No Friends.
                                            @endif
                                        </span>
                                    </div>
                                    {{-- Request Sent By --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-solid fa-user-plus"></i> Request
                                            Sent By</span>
                                        <span class="text-primary"><i class="fa-regular fa-user"></i>
                                            {{ optional(auth()->user()->getDetailOfFriendship($friend))->requestSender->name }}</span>
                                    </div>

                                    {{-- Chatify Joined --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-success"><i class="fa-sharp fa-solid fa-award"></i> Joined
                                            Chatify</span>
                                        <span class="text-secondary"><i class="fa-solid fa-clock"></i>
                                            {{ $friend->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                {{-- Remove Friend & Close Button --}}
                                <div class="modal-footer d-flex justify-content-between">
                                    <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter{{ $friend->id }}"
                                        data-bs-original-title="" title="">Remove Friend</a>
                                        <button class="btn btn-info" type="button" data-bs-dismiss="modal"
                                            data-bs-original-title="" title="">Close</button>
                                </div>
                            </div>
                        </div>
                        {{-- style code for hover effects --}}
                        <style>
                            .frnDetails:hover {
                                background-color: rgb(210, 213, 213);
                                cursor: pointer;

                            }

                            .friendName:hover {
                                cursor: pointer;
                            }
                        </style>
                    </div>

                    {{-- Opens when remove friend is clicked --}}
                    <div class="modal fade" id="exampleModalCenter{{ $friend->id }}" tabindex="-1"
                        aria-labelledby="exampleModalCenter{{ $friend->id }}" style="display: none;"
                        aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Remove {{ $friend->first_name }}</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                        aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure! want to remove friend?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-dark" type="button" data-bs-dismiss="modal"
                                        data-bs-original-title="" title="">Cancel</button>
                                    <button class="btn btn-danger" type="button" data-bs-original-title=""
                                        title="" wire:click="removeFriend({{ $friend->id }})">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Customizing the scroll bar & Friendlist hover effects --}}

        <style>
            /*Our Friendlist custom scrollbar styles & hover effects */
            /* .scroll-bar {
                height: 400px;
                overflow-y: scroll;
                overflow-x: hidden;
                scrollbar-width: thin;
            }

            .scroll-bar::-webkit-scrollbar {
                width: 10px;
            }

            .scroll-bar::-webkit-scrollbar-track {
                background-color: #e4e4e4;
                border-radius: 100px;
            }

            .scroll-bar::-webkit-scrollbar-thumb {
                background-color: #777a7b;
                border-radius: 100px;
            } */

            .friendBox:hover {
                cursor: pointer;
                /* background-color: #d5dbdd; */
                background-color: #a9acaca5;
                border-radius: 5px;
            }
        </style>
    </div>
</div>
