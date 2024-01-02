@extends('auth.admin.design.main')

{{-- @section('subtitle', 'Course Management') --}}
@section('contentsection')
    <div class="d-flex align-items-center justify-content-between ">
        <h1 class="mb-0">All Users List
            <i class="fas fa-users"></i>
        </h1>
        <div>
            <a href="{{ route('add_user') }}" class="btn btn-primary">Add Users</a>
            <a href="{{ route('show_inactive_users') }}" class="btn btn-secondary">Disabled Users Accounts</a>
        </div>
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congrats!</strong> New User has been created successfully!
            <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert" aria-label="Close"
                style="cursor: pointer;"></i>
        </div>
    @endif
    @if (Session::has('updateSuccess'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            User has been updated successfully!
            <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert" aria-label="Close"
                style="cursor: pointer;"></i>
        </div>
    @endif
    @if (Session::has('info'))
        <div class="alert alert-info alert-dismissible fade show text-danger" role="alert">
            No changes were made to the database!
            <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert" aria-label="Close"
                style="cursor: pointer;"></i>
        </div>
    @endif
    @if (Session::has('deleteSuccess'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            User has been deleted successfully!.
            <i class="fas fa-trash fa-lg float-right text-danger" data-bs-dismiss="alert" aria-label="Close"
                style="cursor: pointer;"></i>
        </div>
    @endif
    <table id="myDataTable" class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created Date</th>
                <th>Status</th>
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
                                style="max-width: 80px; max-height: 80px;"></td>
                        {{-- <td class="align-middle"><img src="#" alt="User Image" style="max-width: 200px; max-height: 200px;"></td> --}}
                        <td class="align-middle">{{ strtoupper($alluser->name) }}</td>
                        <td class="align-middle">{{ $alluser->email }}</td>
                        {{-- <td class="align-middle "><span class="badge bg-success text-white rounded-pill">{{ $alluser->getRoleNames()[0] }}</span></td> --}}
                        <td class="align-middle">{{ $alluser->phone != null ? $alluser->phone : 'NA' }}</td>
                        <td class="align-middle">{{ Carbon\Carbon::parse($alluser->created_at)->diffForHumans() }}</td>
                        <td class="align-middle"><span
                                class="badge text-white  @if (Cache::has('user-is-online-' . $alluser->id)) bg-success
                            @else
                                bg-warning @endif">
                                @if (Cache::has('user-is-online-' . $alluser->id))
                                    Online
                                @else
                                    Offline
                                @endif
                            </span></td>
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
                                                <form action="{{ route('suspend_this_user', ['user_id' => $alluser->id]) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('If Proceed, this user will not be able to use the system anymore.')"
                                                            class="btn btn-danger float-start" > Ban
                                                        {{ $alluser->first_name }}</button>
                                                </form>

                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <a href="#" type="button" class="btn btn-warning">Edit</a> --}}
                                <a href="{{ route('delete_user', ['user_id' => $alluser->id]) }}"
                                    class="btn btn-danger m-0"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Remove</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center alert alert-warning py-3 text-danger" colspan="8">Courses not found!</td>
                </tr>
            @endif
        </tbody>
    </table>






@endsection
