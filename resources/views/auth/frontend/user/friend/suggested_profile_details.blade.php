<div class="modal fade" id="exampleModal{{ $su->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel"
    style="display: none;" aria-hidden="true">
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
                    <div class="row gallery my-gallery" id="aniimated-thumbnials1" itemscope="" data-pswp-uid="7">
                        <figure class="col-md-3 img-hover hover-1" itemprop="associatedMedia" itemscope="">
                            <a href="{{ asset('storage/' . $su->profile_image_path) }}" itemprop="contentUrl">
                                <div><img class="rounded-pill" src="/storage/{{ $su->profile_image_path }}"
                                        itemprop="thumbnail" alt="Image description" height="170px" width="170px">
                                </div>
                            </a>
                        </figure>
                    </div>
                </div>
                {{-- Friend Name --}}
                <div class="f-w-600 f-20 text-center border-bottom p-4 friendName"><i class="fa-regular fa-user"></i>
                    {{ $su->first_name . ' ' . $su->last_name }}
                </div>

                {{-- Friend Gender Address --}}
                <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                    <span class="text-secondary"><i class="fa-solid fa-venus-mars"></i> Gender</span>
                    <span class="text-secondary">{{ $su->gender ? $su->gender : 'Not Mention' }}</span>
                </div>
                {{-- Friend Email Address --}}
                <div class="d-flex justify-content-between border-bottom p-3 frnDetails">
                    <span class="text-secondary"><i class="fa-regular fa-envelope"></i> Email</span>
                    <span class="text-secondary">{{ $su->email }}</span>
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
                    @if ($su->address != null)
                        <span class="text-secondary">
                            {{ $su->address }}
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
                        {{ $su->created_at->diffForHumans() }}</span>
                </div>
            </div>

            {{-- Close Button --}}
            <div class="modal-footer f-right">
                <button class="btn btn-info text-light" type="button" data-bs-dismiss="modal" data-bs-original-title=""
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
