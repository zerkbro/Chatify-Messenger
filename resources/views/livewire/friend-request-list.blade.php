<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="card" wire:poll.30000ms>
        <div class="card-header bg-dark">
            <h5 class="text-center">
                <span class="btn btn-link text-white" data-bs-toggle="collapse" data-bs-target="#collapseicon9"
                    aria-expanded="true" aria-controls="collapseicon9"><span class="text-light f-14"><i class="fa-solid fa-user-plus fa-lg"></i></span> Friend Requests {{ '( '.count(auth()->user()->receivedFriendRequests).' )' }}</span>
            </h5>
        </div>
        <div class="collapse show" id="collapseicon9" aria-labelledby="collapseicon9" data-parent="#accordion"
            >
            {{-- We are not using wire:poll in order to maintain the page consistent --}}
            <div class="card-body social-list filter-cards-view">
                {{-- Displaying pending friend requests if we have some --}}
                @foreach (auth()->user()->receivedFriendRequests as $request)
                    <div class="media border-bottom pb-3 px-2"><img class="img-70 img-fluid m-r-15 rounded-circle" alt=""
                            src="/storage/{{ $request->user->profile_image_path }}"
                           type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $request->user->id }}">
                        <div class="media-body"><span class="d-block pb-2">{{ $request->user->name }} <span class="f-right text-muted f-12"><i class="fa-regular fa-clock"></i> {{ $request->created_at->diffForHumans() }}</span></span>
                            <div class="d-flex justify-content-between pt-2">
                            <button class="btn-success rounded-pill"
                                wire:click="acceptNewRequest({{ $request->user->id }})"><span class="f-12 text-light px-3"><i class="fa-solid fa-check fa-lg pe-2"></i>Accept</span></button>
                                <button class="btn-danger rounded-pill"
                                    wire:click="removeNewRequest({{ $request->user->id }})"><span class="f-12 text-light px-3"><i class="fa-solid fa-xmark fa-lg pe-2"></i> Remove</span></button>
                            </div>
                        </div>
                    </div>

                    {{-- Friend Details Modal Section --}}
                    <div class="modal fade" id="exampleModal{{ $request->user->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel"><i class="fa-regular fa-address-card"></i> Profile Details</h4>

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
                                                <a href="{{ asset('storage/' . $request->user->profile_image_path) }}"
                                                    itemprop="contentUrl">
                                                    <div><img class="rounded-pill"
                                                            src="/storage/{{ $request->user->profile_image_path }}"
                                                            itemprop="thumbnail" alt="Image description" height="170px"
                                                            width="170px"></div>
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                    {{-- Friend Name & online status --}}
                                    <div class="f-w-600 f-20 text-center border-bottom p-4 friendName"><i class="fa-regular fa-user"></i>
                                        {{ $request->user->first_name . ' ' . $request->user->last_name }}
                                    </div>

                                    {{-- Friend Request Sent Time --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-warning"><i class="fa-solid fa-user-plus"></i> Request Received</span>
                                        <span
                                            class="text-muted"><i class="fa-regular fa-clock"></i> {{ $request->created_at->diffForHumans() }}</span>
                                    </div>
                                    {{-- Friend Email Address --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-solid fa-venus-mars"></i> Gender</span>

                                        <span
                                            class="text-secondary">{{ $request->user->gender ? $request->user->gender : 'Not Mention' }}</span>
                                    </div>
                                    {{-- Friend Email Address --}}
                                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                                        <span class="text-secondary"><i class="fa-regular fa-envelope"></i> Email</span>
                                        <span class="text-secondary">{{ $request->user->email }}</span>
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
                                        @if ($request->user->address != null)
                                            <span class="text-secondary">
                                                {{ $request->user->address }}
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

                                        <span class="text-secondary"><i class="fa-solid fa-clock"></i> {{ $request->user->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                {{-- Remove Friend & Close Button --}}
                                <div class="modal-footer">
                                    <button class="btn btn-info f-right" type="button" data-bs-dismiss="modal"
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

                {{-- @if (!$isPendingRequest) --}}
                @if (count(auth()->user()->receivedFriendRequests)==0)
                    <div class="text-center text-muted">No pending request !</div>
                @endif
            </div>
        </div>
    </div>
</div>
