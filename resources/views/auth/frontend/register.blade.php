{{-- @extends('layouts.app')
@section('contents')
    @livewire('register-page')
@endsection --}}


<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    {{-- <title>Chatify|login</title> --}}
    @livewireStyles()
</head>
<body>
    @livewire('register-page')

    {{-- @include('layouts.script') --}}
    @livewireScripts()
</body>
</html>
