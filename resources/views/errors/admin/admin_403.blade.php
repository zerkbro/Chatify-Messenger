@extends('auth.admin.design.main')
@section('subtitle', 'Dashboard')

{{-- by using the contentsection display in the dashboard --}}
@section('contentsection')
    <div class="container-fluid d-flex align-items-center justify-content-center" style="height: 60vh">
        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto text-danger" data-text="403">403</div>
            <div class="text-danger">
                <h3 class="text-danger text-800 mb-5 py-3">Access Denied!</h3>
            </div>
            <p class="text-gray-500 mb-0">It looks like you want to access the wrong kingdom!</p>
            {{-- @if (session('previous_url'))
                <a href="{{ session('previous_url') }}">← Back to Previous</a>
            @else --}}
                <a class="btn btn-dark rounded-pill mt-5 " href="{{ route('adminDashboard') }}">← Back to Dashboard</a>
            {{-- @endif --}}
        </div>
    </div>
@endsection
