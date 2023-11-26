@extends('layouts.app')
@section('main_title','Chatify | Email Verification')
@section('main_content')

<div class="container-fluid">
    <div class="row">
        <div class="card shadow">
            @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (Session::has('alert'))
            <div class="alert alert-{{ Session::get('alert-type') }} alert-dismissible fade show" role="alert">
                {{ Session::get('alert') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="text-center">
                <span class="badge badge-info m-t-10 m-b-5">Check Your Mail</span>
                <h3><i class="fa-regular fa-envelope fa-lg text-danger"></i> Verification Link Has Been Sent! <i class="fa fa-check text-success"></i></h3>
            </div>
            <form action="{{ route('verification.send') }}" method="post">
                @csrf
                <div class="text-center m-t-5 p-b-10">

                    <button class="btn btn-dark rounded-pill text-white" type="submit">Resend Verification Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
