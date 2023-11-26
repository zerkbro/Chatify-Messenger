{{-- Friend Profile Model Box --}}
@if (auth()->user()->getFriendshipStatusWith($sr) === "accepted")

    {{-- Friend Details Modal Section --}}
    <div class="modal fade" id="exampleModal{{ $sr->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"><i class="fa-regular fa-address-card"></i> Profile
                        Details</h4>

                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                        data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    {{-- Friend Profile Picture --}}
                    <div class="d-flex justify-content-center p-3">
                        <div class="row gallery my-gallery" id="aniimated-thumbnials1" itemscope="" data-pswp-uid="7">
                            <figure class="col-md-3 img-hover hover-1" itemprop="associatedMedia" itemscope="">
                                <a href="{{ asset('storage/' . $sr->profile_image_path) }}" itemprop="contentUrl">
                                    <div><img class="rounded-pill" src="/storage/{{ $sr->profile_image_path }}"
                                            itemprop="thumbnail" alt="Image description" height="170px" width="170px">
                                    </div>
                                </a>
                            </figure>
                        </div>
                    </div>
                    {{-- Friend Name & online status --}}
                    <div class="f-w-600 f-20 text-center pt-4 friendName"><i class="fa-regular fa-user"></i>
                        {{ $sr->first_name . ' ' . $sr->last_name }}

                        @if (Cache::has('user-is-online-' . $sr->id))
                            <span class="badge bg-success f-12 rounded-pill text-light">online</span>
                        @else
                            <span class="badge badge-warning f-12 rounded-pill text-light">offline</span>
                        @endif
                        {{-- </h5> --}}
                    </div>

                    {{-- Last Time Active Status --}}
                    <div class="text-center border-bottom pb-3 pt-2">
                        <span class="text-muted f-12">Last Time Active :
                            {{ $sr->last_seen ? Carbon\Carbon::parse($sr->last_seen)->diffForHumans() : 'unknown' }}</span>
                    </div>

                    {{-- Friend Gender --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-solid fa-venus-mars"></i>
                            Gender</span>
                        <span class="text-secondary">{{ $sr->gender ? $sr->gender : 'Not Mention' }}</span>
                    </div>
                    {{-- Friend Email Address --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-regular fa-envelope"></i>
                            Email</span>
                        <span class="text-secondary">{{ $sr->email }}</span>
                    </div>
                    {{-- Friend Phone Number --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-solid fa-mobile-screen-button"></i>
                            Phone Number</span>
                        @if ($sr->phone != null)
                            <span class="text-secondary">
                                {{ $sr->phone }}
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
                        @if ($sr->address != null)
                            <span class="text-secondary">
                                {{ $sr->address }}
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
                            class="text-secondary">{{ optional(auth()->user()->getDetailOfFriendship($sr))->created_at->format('d M Y, h:i A') }}</span>
                    </div>

                    {{-- Friend Lists of Friends --}}
                    <div class="d-flex align-items-center justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-solid fa-users-line"></i> Friends
                            With</span>
                        <span class="text-muted">
                            @if (count(auth()->user()->fofList($sr->id)) != 0)
                                @foreach (auth()->user()->fofList($sr->id) as $fof)
                                    <img class="img-30 img-fluid rounded-circle bg-dark"
                                        src="/storage/{{ $fof->profile_image_path }}" alt=""
                                        data-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="" data-bs-original-title="{{ $fof->name }}">
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
                            {{ optional(auth()->user()->getDetailOfFriendship($sr))->requestSender->name }}</span>
                    </div>

                    {{-- Chatify Joined --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-success"><i class="fa-sharp fa-solid fa-award"></i> Joined
                            Chatify</span>
                        <span class="text-secondary"><i class="fa-solid fa-clock"></i>
                            {{ $sr->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Remove Friend & Close Button --}}
                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter{{ $sr->id }}" data-bs-original-title=""
                        title="">Remove Friend</a>
                        <button class="btn btn-info" type="button" data-bs-dismiss="modal" data-bs-original-title=""
                            title="">Close</button>
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
@else
    {{-- Friend Details Modal Section --}}
    <div class="modal fade" id="exampleModal{{ $sr->id }}" tabindex="-1"
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
                            <figure class="col-md-3 img-hover hover-1" itemprop="associatedMedia" itemscope="">
                                <a href="{{ asset('storage/' . $sr->profile_image_path) }}"
                                    itemprop="contentUrl">
                                    <div><img class="rounded-pill"
                                            src="/storage/{{ $sr->profile_image_path }}"
                                            itemprop="thumbnail" alt="Image description" height="170px"
                                            width="170px"></div>
                                </a>
                            </figure>
                        </div>
                    </div>
                    {{-- Friend Name --}}
                    <div class="f-w-600 f-20 text-center border-bottom p-4 friendName"><i
                            class="fa-regular fa-user"></i>
                        {{ $sr->first_name . ' ' . $sr->last_name }}
                    </div>

                    {{-- Friend Gender Address --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-solid fa-venus-mars"></i> Gender</span>
                        <span
                            class="text-secondary">{{ $sr->gender ? $sr->gender : 'Not Mention' }}</span>
                    </div>
                    {{-- Friend Email Address --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-regular fa-envelope"></i> Email</span>
                        <span class="text-secondary">{{ $sr->email }}</span>
                    </div>
                    {{-- Friend Phone Number --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-solid fa-mobile-screen-button"></i> Phone
                            Number</span>

                        <span class="text-danger">
                            <i class="fa-solid fa-circle-xmark"></i> friends only
                        </span>
                    </div>
                    {{-- Friend Address --}}
                    <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                        <span class="text-secondary"><i class="fa-sharp fa-solid fa-location-dot"></i> Lives In</span>
                        @if ($sr->address != null)
                            <span class="text-secondary">
                                {{ $sr->address }}
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
                        <span class="text-secondary"><i class="fa-solid fa-clock"></i>
                            {{ $sr->created_at->diffForHumans() }}</span>
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
@endif
