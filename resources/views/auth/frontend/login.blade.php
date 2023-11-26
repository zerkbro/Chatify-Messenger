{{-- @extends('layouts.app')
@section('contents')
    @livewire('login-page')
@endsection --}}



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chatify | Login</title>
    @include('layouts.header')
    @livewireStyles()
</head>

<body>
    @livewire('login-page')

    {{-- @include('layouts.script') --}}
    {{-- <script src="{{ asset('user_assets/js/jquery-3.5.1.min.js') }}"></script> --}}
    <script src="{{ asset('user_assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/bootstrap/bootstrap.min.js') }}"></script>

    @livewireScripts()
</body>

</html>
