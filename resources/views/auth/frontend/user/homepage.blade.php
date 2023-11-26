@extends('layouts.app')
@section('main_title', 'Chatify | Dashboard')
@section('main_content')
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <span class="summernote">Welcome to chatify!</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @livewire('friend-request-list')
                @livewire('sent-friend-request-list')
            </div>
            <div class="col-md-4">
                @livewire('all-friendslist')
            </div>
            <div class="col-md-4" wire:key="friends-list">
                @livewire('friends-list')
                {{-- @livewire('blocked-friend-list') --}}

            </div>
        </div>
    </div>
@endsection
