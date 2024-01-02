@extends('layouts.app')
@section('main_title', 'Chatify | Search Friends')
@section('main_content')
    {{-- Search bar to perform search --}}
    @livewire('friend-searchbar')
@endsection
