@extends('auth.admin.design.main')
@section('subtitle', 'Dashboard')

{{-- by using the contentsection display in the dashboard --}}
@section('contentsection')
    <div class="container-fluid d-flex align-items-center justify-content-center" style="height: 60vh">
        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto text-gray-700" data-text="404">404</div>
            <h3 class="text-danger text-800 mb-5 py-3">Page Not Found!</h3>
            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
            {{-- @if (session('previous_url'))
                <a href="{{ session('previous_url') }}">← Back to Previous</a>
            @else
            @endif --}}
            <a class="btn btn-dark rounded-pill mt-5 " href="{{ route('adminDashboard') }}">← Back to Dashboard</a>
        </div>
    </div>
@endsection
