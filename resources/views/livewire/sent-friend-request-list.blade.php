<div class="col-xl-12 col-lg-6 col-md-12 col-sm-6">

    <div class="card">
        <div class="card-header bg-dark">
            <h5 class="text-center">
                <span class="btn btn-link text-white" data-bs-toggle="collapse" data-bs-target="#collapseicon11"
                    aria-expanded="true" aria-controls="collapseicon11"><i class="fa-solid fa-user-check fa-lg pe-2 text-light" ></i>Sent Requests  {{ '( '.count(auth()->user()->sentFriendRequests).' )' }}</span>
            </h5>
        </div>
        {{-- @dd(auth()->user()->sentFriendRequests) --}}
        <div class="collapse hide" id="collapseicon11" aria-labelledby="collapseicon11" data-parent="#accordion">
            <div class="card-body social-list filter-cards-view">
                {{-- sendFriendRequests is relationship from user model --}}
                @if (count(auth()->user()->sentFriendRequests) > 0) {{-- counting the no of sent request --}}
                    @foreach (auth()->user()->sentFriendRequests as $requestList)
                        <div class="media border-bottom pb-3">
                            {{-- {{ count(auth()->user()->sentFriendRequests) }} --}}
                            <img class="img-60 img-fluid m-r-20 rounded-circle" alt=""
                                src="/storage/{{ $requestList->friend->profile_image_path }}" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $requestList->friend->id }}">
                            <div class="media-body">
                                <span
                                    class="d-block">{{ $requestList->friend->first_name . ' ' . $requestList->friend->last_name }}
                                    <span
                                        class="text-muted f-right f-12"><i class="fa-regular fa-clock"></i> {{ $requestList->created_at->diffForHumans() }}</span>

                                </span>
                                {{-- Here i am using $requestList->friend relationship from the friendship model. --}}

                                    <button class="btn text px-2 -secondary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $requestList->friend->id }}">
                                        <i class="fa-solid fa-id-badge"></i><span class="text-muted f-12"> Profile Details</span></button>
                                    <button class="btn-danger f-right mt-2" wire:click="cancelRequest({{ $requestList->friend->id }})">
                                        <i class="fa-solid fa-user-xmark f-12"></i><span class="text-light f-12"> Cancel Request</span></button>
                            </div>
                        </div>


                                            {{-- Friend Details Modal Section --}}
                    <div class="modal fade" id="exampleModal{{ $requestList->friend->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">Profile Details</h4>

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
                                                <a href="{{ asset('storage/' . $requestList->friend->profile_image_path) }}"
                                                    itemprop="contentUrl">
                                                    <div><img class="rounded-pill"
                                                            src="/storage/{{ $requestList->friend->profile_image_path }}"
                                                            itemprop="thumbnail" alt="Image description" height="170px"
                                                            width="170px"></div>
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                    {{-- Friend Name --}}
                                    <div class="f-w-600 f-20 text-center border-bottom p-4 friendName"><i class="fa-regular fa-user"></i>
                                        {{ $requestList->friend->first_name . ' ' . $requestList->friend->last_name }}
                                    </div>

                                    {{-- Friend Request Sent Time --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-warning"><i class="fa-solid fa-user-plus"></i> Request Sent</span>
                                        <span
                                            class="text-muted"><i class="fa-regular fa-clock"></i> {{ $requestList->created_at->diffForHumans() }}</span>
                                    </div>
                                    {{-- Friend Gender Address --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-solid fa-venus-mars"></i> Gender</span>
                                        <span
                                            class="text-secondary">{{ $requestList->friend->gender ? $requestList->friend->gender : 'Not Mention' }}</span>
                                    </div>
                                    {{-- Friend Email Address --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-regular fa-envelope"></i> Email</span>
                                        <span class="text-secondary">{{ $requestList->friend->email }}</span>
                                    </div>
                                    {{-- Friend Phone Number --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-solid fa-mobile-screen-button"></i> Phone Number</span>

                                        <span class="text-danger">
                                            <i class="fa-solid fa-circle-xmark"></i> friends only
                                        </span>
                                    </div>
                                    {{-- Friend Address --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-sharp fa-solid fa-location-dot"></i> Lives In</span>
                                        @if ($requestList->friend->address != null)
                                            <span class="text-secondary">
                                                {{ $requestList->friend->address }}
                                            </span>
                                        @else
                                            <span class="text-secondary">
                                                Not Mention
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Chatify Joined --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-success"><i class="fa-sharp fa-solid fa-award"></i> Joined Chatify</span>
                                        <span class="text-secondary"><i class="fa-solid fa-clock"></i> {{ $requestList->friend->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                {{-- Close Button --}}
                                <div class="modal-footer f-right">
                                    <button class="btn btn-info text-light" type="button" data-bs-dismiss="modal"
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
                    @endforeach
                @else
                    <div class="media">
                        <div class="text-center text-muted">Box is Empty!</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
