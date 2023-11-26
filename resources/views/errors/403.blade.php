@if (!auth()->check())
    {{-- Content for guest users --}}
    @include('errors.frontend.guest_403')
@elseif (auth()->user()->hasRole('admin|superadmin'))
    @include('errors.admin.admin_403')
@else
    {{-- Content for normal users --}}
    @include('errors.frontend.user_403')
@endif
