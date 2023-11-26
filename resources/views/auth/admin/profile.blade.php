@extends('auth.admin.design.main')

@section('subtitle', 'Profile Management')
@section('contentsection')

    <div class="container rounded bg-white mt-5 mb-5 card-shadow">
        <div class="row">
            <div class="col-md-3 border-right mt-3">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                        width="150px" src="{{ asset('storage/' . auth()->user()->profile_image_path) }}">
                        <span class="font-weight-bold mt-3">username</span><span
                        class="text-black-50">{{ auth()->user()->email }}</span><span>
                    </span></div>
            </div>
            <div class="col-md-9">
                <div class="px-5 py-5">
                    @if (Session::has('updateSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Profile has been updated successfully!
                        <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert" aria-label="Close"
                            style="cursor: pointer;"></i>
                    </div>
                    @endif
                    @if (Session::has('info'))
                    <div class="alert alert-info alert-dismissible fade show text-danger" role="alert">
                        No changes were made to the database!
                        <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert" aria-label="Close"
                            style="cursor: pointer;"></i>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom py-3">
                        <h3 class="text-right">Update Your Information
                            <i class="fas fa-fw fa-wrench"></i>
                        </h3>
                    </div>
                    <form method="POST" action="{{ route('update_dashboard_profile', ['id' => auth()->user()->id]) }}">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-6 mt-2"><label class="labels">Full Name</label><input type="text"
                                    class="form-control" name="name" placeholder="your name"
                                    value="{{ auth()->user()->name }}"></div>
                            <div class="col-md-6 mt-2"><label class="labels">Email</label><input type="text"
                                    class="form-control text-white bg-dark text-center" value="{{ auth()->user()->email }}"
                                    disabled></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 "><label class="labels">Mobile Number</label><input type="text"
                                    name="phone" class="form-control" placeholder="enter phone number"
                                    value="{{ auth()->user()->phone }}"></div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels ">Role<span
                                        class="text-danger">*</span></label><input type="text"
                                    class="form-control bg-dark text-white" placeholder="role_type"
                                    value="{{ auth()->user()->getRoleNames()[0] }}" disabled></div>
                            <div class="col-md-6"><label class="labels">Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary rounded-pill" type="submit">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
