@extends('layouts.app')
@section('main_title', 'Chatify | PageNotFound')
@section('main_content')

<div class="container d-flex align-items-center justify-content-center" style="height: 80vh">
    <div class="text-center">
        <h1 class="error mx-auto display-1 fw-bold" data-text="404">404</h1>
        <p class="fs-3"> <span class="text-danger">Page Not Found!</span></p>
        <p class="lead mb-5">
            It looks like you found a glitch in the matrix...
            {{-- You are not allowed to visit there! --}}
          </p>
        {{-- <a href="{{ route('userDashboard') }}" class="btn btn-primary">Go Back</a> --}}
        @if (session('previous_url'))
        <a class="btn btn-dark rounded-pill" href="{{ session('previous_url') }}">← Back to Previous</a>
        @else
        <a class="btn btn-dark rounded-pill" href="{{ route('userDashboard') }}">← Back to Home</a>
        @endif
        {{-- <a class="btn btn-dark rounded-pill" href="{{ session('previous_url') }}">Home</a> --}}
    </div>
</div>
@endsection
