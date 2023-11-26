@extends('auth.admin.design.main')

{{-- @section('subtitle', 'Course Management') --}}
@section('contentsection')
    <div class="d-flex align-items-center justify-content-between ">
        <h1 class="mb-0">Disabled Users List
            <i class="fas fa-fw fa-users-slash"></i>
        </h1>
        <a href="{{ route('show_users') }}" class="btn btn-secondary">View Active Users</a>
    </div>
    <hr />

    <table id="myDataTable" class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Disabled Date</th>
                <th>Disabled Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($allusers->count() > 0)
                @foreach ($allusers as $alluser)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle"><img class="rounded-circle"
                                src="{{ asset('storage/' . $alluser->profile_image_path) }}" alt="Course Image"
                                style="max-width: 60px; max-height: 60px;"></td>
                        <td class="align-middle">{{ strtoupper($alluser->name) }}</td>
                        <td class="align-middle">{{ $alluser->email }}</td>
                        <td class="align-middle">{{ $alluser->account_inactive_since }}</td>
                        <td class="align-middle">
                            <span class="badge {{ $alluser->account_inactive_reason == "Admin Banned" ? 'bg-danger' : 'bg-info' }} text-white rounded-pill px-3 py-1">
                                {{ $alluser->account_inactive_reason }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                {{-- <a href="#" type="button" class="btn btn-secondary">Detail</a> --}}
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $alluser->id }}">
                                    Detail
                                </button>

                                <!-- Modal -->
                                {{-- Opening the detail of the user --}}
                                <div class="modal fade" id="exampleModal{{ $alluser->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title fs-6" id="exampleModalLabel">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/' . $alluser->profile_image_path) }}"
                                                        alt="Course Image" style="max-width: 50px; max-height: 50px;">
                                                    {{ $alluser->name }}
                                                    @if (Cache::has('user-is-online-' . $alluser->id))
                                                        <span class="badge badge-success rounded-pill">Online</span>
                                                    @else
                                                        <span class="badge badge-warning rounded-pill fs-6">Offline</span>
                                                    @endif
                                                </h4>
                                                <button type="button" class="btn text-danger btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close">X</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-muted">Email</span>
                                                    <span class="text-muted">{{ $alluser->email }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-muted">Email Status</span>
                                                    @if ($alluser->email_verified_at!=null)
                                                        <span class="text-success">Verified User</span>
                                                    @else
                                                        <span class="text-danger">Not Verified</span>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-muted">Verified Since</span>
                                                    <span
                                                        class="text-muted">
                                                        @if ( $alluser->email_verified_at != null )
                                                            {{ $alluser->email_verified_at->format('F j, Y, g:i a') }}
                                                        @else
                                                            No date available
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-muted">Phone</span>
                                                    <span class="text-muted">@if ($alluser->phone!= null)
                                                        {{ $alluser->phone }}
                                                    @else
                                                        Not mention
                                                    @endif</span>
                                                </div>
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-primary">Total Friends</span>
                                                    <span class="text-muted">{{ count($alluser->friendslist()) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-muted">Total Request Sent</span>
                                                    <span
                                                        class="text-muted">{{ count($alluser->sentFriendRequests) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-muted">Total Request Received</span>
                                                    <span
                                                        class="text-muted">{{ count($alluser->receivedFriendRequests) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between px-3 border-bottom pb-4 pt-4">
                                                    <span class="text-info">Account Created Date</span>
                                                    <span
                                                        class="text-muted">{{ $alluser->created_at->format('F j, Y, g:i a') }}</span>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onclick="return confirm('This feature is comming soon!')"
                                                 class="btn btn-danger float-start" >Permanently Delete
                                                    {{ $alluser->first_name }}</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('restore_user', ['user_id' => $alluser->id]) }}"
                                    class="btn btn-danger m-0"
                                    onclick="return confirm('This cannot be undone, if proceed.\nAre you still want to do this?')">Restore Account</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
{{--            @else--}}
{{--                <tr>--}}
{{--                    <td class="text-center alert alert-danger py-3 text-danger" colspan="8">No Disable Accounts!</td>--}}
{{--                </tr>--}}
            @endif
        </tbody>
    </table>
@endsection
