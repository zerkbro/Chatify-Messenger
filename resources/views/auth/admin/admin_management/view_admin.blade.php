@extends('auth.admin.design.main')

{{-- @section('subtitle', 'Course Management') --}}
@section('contentsection')
    <div class="d-flex align-items-center justify-content-between ">
        <h1 class="mb-0">All Admins List
            <i class="fas fa-crown"></i>
        </h1>
        @role('superadmin')
            <a href="{{ route('add_admin') }}" class="btn btn-secondary">Add Admins</a>
        @endrole
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congrats!</strong> New admin has been added successfully.
            <i class="fas fa-trash fa-lg float-right text-dark" data-bs-dismiss="alert" aria-label="Close"
                style="cursor: pointer;"></i>
        </div>
    @endif
    @if (Session::has('updateSuccess'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Admin has been updated successfully!
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
            Admin has been deleted successfully!.
            <i class="fas fa-trash fa-lg float-right text-danger" data-bs-dismiss="alert" aria-label="Close"
                style="cursor: pointer;"></i>
        </div>
    @endif
    {{-- <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive"> --}}
                <table id="myDataTable" class="table table-hover mb-5">
                    {{-- <table class="table table-bordered" id="myDataTable" width="100%" cellspacing="0"> --}}
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($admins->count() > 0)
                            @foreach ($admins as $admin)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle"><img class="rounded-circle"
                                            src="{{ asset('storage/' . $admin->profile_image_path) }}" alt="Admin Image"
                                            style="max-width: 80px; max-height: 80px;"></td>
                                    {{-- <td class="align-middle"><img src="#" alt="Admin Image" style="max-width: 200px; max-height: 200px;"></td> --}}
                                    <td class="align-middle">{{ $admin->name }}</td>
                                    <td class="align-middle">{{ $admin->email }}</td>
                                    {{-- <td class="align-middle "><span class="badge bg-success text-white rounded-pill">{{ $admin->getRoleNames()[0] }}</span></td> --}}
                                    <td class="align-middle">
                                        <span
                                            class="badge {{ $admin->getRoleNames()[0] === 'superadmin' ? 'bg-danger' : 'bg-primary' }} text-white rounded-pill">{{ $admin->getRoleNames()[0] }}</span>
                                    </td>
                                    <td class="align-middle">{{ Carbon\Carbon::parse($admin->created_at)->diffForHumans() }}</td>

                                    <td class="align-middle"><span class="badge bg-success text-white">active</span></td>
                                    {{-- <td class="align-middle">{{ Str::limit($admin->course_description, 30, '...') }}</td> --}}
                                    <td class="align-middle">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            {{-- <a href="#" type="button" class="btn btn-secondary">Detail</a> --}}
                                            @role('superadmin')
                                            <a href="{{ route('edit_admin', ['admin_id' => $admin->id]) }}" type="button" class="btn btn-warning">Modify</a>
                                            <a href="{{ route('delete_admin', ['admin_id' => $admin->id]) }}" class="btn btn-danger m-0"
                                                onclick="return confirm('Are you sure you want to delete this admin?')">Remove</a>
                                            @endrole
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center alert alert-warning py-3 text-danger" colspan="8">Courses not
                                    found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            {{-- </div>
        </div>
    </div> --}}
@endsection
