<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="text-center">
            <img src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}" alt="" width="80%" height="80%">
            <h1 class="display-1 fw-bold">403</h1>
            <p class="fs-3"> <span class="text-danger">Access Denied!</span></p>
            <p class="lead mb-5">
                It looks like you want to access unauthorized area!
                {{-- You are not allowed to visit there! --}}
              </p>
            <a class="btn btn-dark rounded-pill" href="{{ route('user_register') }}">← Back to Home</a>
        </div>
    </div>
    @include('layouts.script')
</body>
</html>

