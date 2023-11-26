<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    <title>Chatify | 404</title>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="text-center">
            <img src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}" alt="" width="80%" height="80%">
            <h1 class="error mx-auto display-1 fw-bold" data-text="404">404</h1>
            <p class="fs-3"> <span class="text-danger">Page Not Found!</span></p>
            <p class="lead mb-5">
                It looks like you found a glitch in the matrix...
              </p>
            <a class="btn btn-dark rounded-pill" href="{{ route('user_login') }}">← Back to Home</a>
        </div>
    </div>
    @include('layouts.script')
</body>
</html>


