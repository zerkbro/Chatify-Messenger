@if (!auth()->check())
    {{-- Content for guest users --}}
    @include('errors.frontend.guest_404')
@elseif (auth()->user()->hasRole('admin|superadmin'))
    @include('errors.admin.admin_404')
@else
    {{-- Content for normal users --}}
    @include('errors.frontend.user_404')
@endif
