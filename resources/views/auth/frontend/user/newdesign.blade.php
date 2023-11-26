{{-- @extends('auth.frontend.user.bestlayout.user_body') --}}
@extends('layouts.app')
@section('main_title', 'Chatify | Chats')

@section('main_content')
    <!-- Container-fluid starts-->
    <div class="row p-t-5" style="height:max-content;">
            <div class="col call-chat-sidebar">
                @livewire('chat-list')
            </div>

            <div class="col call-chat-body" >
                @livewire('chat-box')
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/themes/nest.css">

    <!-- Container-fluid Ends-->


@endsection
