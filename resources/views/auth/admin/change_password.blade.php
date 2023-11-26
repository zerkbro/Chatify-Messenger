@extends('auth.admin.design.main')

@section('subtitle', 'Password Management')
@section('contentsection')

    <div class="container rounded bg-white mt-5 mb-5 card-shadow">
        <div class="row">
            <div class="col-md-3 border-right mt-3">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                        width="150px" src="{{ asset('storage/' . auth()->user()->profile_image_path) }}">
                    <span class="font-weight-bold mt-3">username</span><span
                        class="text-black-50">{{ auth()->user()->email }}</span><span>
                    </span>
                </div>
            </div>
            <div class="col-md-9">
                <div class="px-5 py-5">
                    @if (Session::has('updateSuccess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Congrats! Password has been changed successfully.
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
                    @if (Session::has('error'))
                        <div class="alert alert-info alert-dismissible fade show text-danger" role="alert">
                            You have entered incorrect password!
                            <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert" aria-label="Close"
                                style="cursor: pointer;"></i>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom py-3">
                        <h3 class="text-right">Update Your Password
                            <i class="fas fa-fw fa-wrench"></i>
                        </h3>
                    </div>

                    <form method="POST" action="{{ route('update_profile_password', ['admin_id'=> auth()->user()->id]) }}">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-12 mt-2"><label class="labels">Current Password <span
                                        class="text-warning">*</span></label><input type="password"
                                    class="form-control rounded-pill py-4 @error('old_password') is-invalid @enderror"
                                    name="old_password" placeholder="Enter your current password">
                                @error('old_password')
                                    <span class="invalid-feedback mt-2">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mt-2"><label class="labels">New Password <span
                                        class="text-danger">*</span></label><input type="password" name="new_password"
                                    class="form-control rounded-pill py-4 @error('new_password') is-invalid @enderror"
                                    placeholder="Enter your new password">
                                @error('new_password')
                                    <span class="invalid-feedback mt-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-2"><label class="labels">Confirm Password <span
                                        class="text-danger">*</span></label><input type="password" name="confirm_password"
                                    class="form-control rounded-pill py-4 @error('confirm_password') is-invalid @enderror"
                                    placeholder="Enter password confirmation">
                                @error('confirm_password')
                                    <span class="invalid-feedback mt-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-dark rounded-pill text-white" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
