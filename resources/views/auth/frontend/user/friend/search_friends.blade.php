@extends('layouts.app')
@section('main_title', 'Chatify | Search Friends')
@section('main_content')
    {{-- Search bar to perform search --}}

    @livewire('friend-searchbar')




    {{-- display search result --}}
    {{-- <div class="row shadow">
        <div class="text-center mt-5">
            <div class="text-muted mb-4">
                <h3>Suggested Friends</h3>
            </div>
            <div class="border-top border-bottom mb-5"></div>
        </div>
        @foreach ($suggestedUsers as $su)
            <div class="col-md-3 col-lg-3 col-xl-3 box-col-6 border-bottom">
                <div class="card custom-card">
                    <div class="card-profile"><img class="rounded-circle "
                            src="{{ asset('storage/' . $su->profile_image_path) }}" alt=""
                            style="max-width:200px; max-height: 200px; height: 100%; width:100%"></div>

                    <div class="text-center profile-details"><a href="user-profile.html">
                            <h4>{{ $su->first_name . ' ' . $su->last_name }}</h4>
                        </a>
                        <h6>Bio Here</h6>
                    </div>
                    <div class="card-footer row">
                        <div class="col-6 col-sm-6">
                            <h6>Friends</h6>
                            <h3 class="counter">956</h3>
                        </div>
                        <div class="col-6 col-sm-6">
                            <button class="btn btn-dark mt-2"  type="submit" onclick="">Add Friend</button>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}



@endsection
