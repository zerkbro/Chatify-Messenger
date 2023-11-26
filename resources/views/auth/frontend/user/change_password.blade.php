@extends('layouts.app')

@section('main_title', 'Chatify | Password Reset')

{{-- @push('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"
    integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"
    integrity="sha512-0p3K0H3S6Q4bEWZ/WmC94Tgit2ular2/n0ESdfEX8l172YyQj8re1Wu9s/HT9T/T2osUw5Gx/6pAZNk3UKbESw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
@endpush --}}

@section('main_content')
    {{-- Change Password Section --}}
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="login">
                        <div class="container rounded mt-5 mb-5 card shadow">
                            <div class="row">
                                <div class="col-md-3 border-end mt-3 mb-3">
                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                                            class="rounded-circle mt-5" width="200px"
                                            src="{{ asset('storage/' . auth()->user()->profile_image_path) }}">
                                        <span
                                            class="fw-bold mt-3">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span><span
                                            class="text-muted"><i class="fa-solid fa-envelope fa-lg pe-1"></i>{{ auth()->user()->email }}</span><span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="px-5 py-5">
                                        @if (Session::has('updateSuccess'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                Congrats! Password has been changed successfully.
                                                <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert"
                                                    aria-label="Close" style="cursor: pointer;"></i>
                                            </div>
                                        @endif
                                        @if (Session::has('info'))
                                            <div class="alert alert-info alert-dismissible fade show text-danger"
                                                role="alert">
                                                No changes were made to the database!
                                                <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert"
                                                    aria-label="Close" style="cursor: pointer;"></i>
                                            </div>
                                        @endif
                                        @if (Session::has('error'))
                                            <div class="alert alert-info alert-dismissible fade show text-danger"
                                                role="alert">
                                                You have entered incorrect password!
                                                <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert"
                                                    aria-label="Close" style="cursor: pointer;"></i>
                                            </div>
                                        @endif
                                        <div class=" text-center mb-3 border-bottom py-3">
                                            <h3 class="text-muted mb-2"><i class="fa-solid fa-key fa-sm pe-2"></i>Update Password </h3>
                                        </div>

                                        <form method="POST"
                                            {{-- action="{{ route('user_password_update', ['user_id' => auth()->user()->id]) }}"> --}}
                                            action="{{ route('update_user_password') }}">
                                            @csrf
                                            <div class="row mt-3">
                                                <div class="col-md-12 mt-2"><label class="labels"><i class="fa-solid fa-lock pe-1"></i>Current Password <span
                                                            class="text-danger">*</span></label><input type="password"
                                                        class="form-control rounded-pill py-3 @error('old_password') is-invalid @else border-success @enderror"
                                                        name="old_password" placeholder="Enter your current password">
                                                    @error('old_password')
                                                        <span class="invalid-feedback mt-2">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6 mt-2"><label class="labels"><i class="fa-solid fa-key pe-1"></i>New Password<span
                                                            class="text-danger">*</span></label><input type="password"
                                                        name="new_password"
                                                        class="form-control rounded-pill py-3 @error('new_password') is-invalid @else border-success @enderror"
                                                        placeholder="Enter your new password">
                                                    @error('new_password')
                                                        <span class="invalid-feedback mt-2">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2"><label class="labels"><i class="fa-solid fa-key pe-1"></i>Confirm Password <span
                                                            class="text-danger">*</span></label><input type="password"
                                                        name="confirm_password"
                                                        class="form-control rounded-pill py-3 @error('confirm_password') is-invalid @else border-success @enderror"
                                                        placeholder="Enter password confirmation">
                                                    @error('confirm_password')
                                                        <span class="invalid-feedback mt-2">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-5 text-center">
                                                <button class="btn btn-info rounded-pill text-white py-3"
                                                    type="submit"><i class="fa-solid fa-rotate pe-1"></i>Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Forget Password Section --}}
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="login">
                        <div class="container rounded mt-5 mb-5 card shadow">
                            <div class="row">
                                <div class="col-sm-12">
                                        <div class="card-header pb-0">
                                            <h5 class="text-danger"><i class="fa-solid fa-wrench pe-1"></i>Reset Password</h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted f-12">Have you forget your account password? Just click on the forget password button
                                                <span class="text-danger"> ( We will send you a code in your email to recover your account! )</span>
                                                <a href="{{ route('verified.forget.password') }}" class="btn-danger float-end px-3 py-1 b-r-3"
                                                    onclick="return confirm('Are you sure to reset your password ? \n\nNote : You will be logout from this session.')">
                                                    <i class="fa-solid fa-right-left pe-1"></i>Reset Password</a>
                                            </p>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
