@extends('layouts.app')
@section('main_title', 'Chatify | Access Denied')
@section('main_content')

<div class="container d-flex align-items-center justify-content-center" style="height: 80vh;">
    <div class="text-center">
        <h1 class="display-1 fw-bold">403</h1>
        <p class="fs-3"> <span class="text-danger">Access Denied!</span></p>
        <p class="lead mb-5">
            It looks like you want to access unauthorized area!
            {{-- You are not allowed to visit there! --}}
          </p>
        {{-- <a href="{{ route('userDashboard') }}" class="btn btn-primary">Go Back</a> --}}
        @if (session('previous_url'))
        <a class="btn btn-dark rounded-pill" href="{{ session('previous_url') }}">← Back to Previous</a>
        @else
        <a class="btn btn-dark rounded-pill" href="{{ route('userDashboard') }}">← Back to Dashboard</a>
        @endif
    </div>
</div>
@endsection
