@extends('auth.admin.design.main')
{{-- @section('subtitle', 'Roles Management') --}}

{{-- by using the contentsection display in the dashboard --}}

@section('contentsection')
    <div class="d-flex align-items-center justify-content-between ">
        <h1 class="mb-0">All Roles & Permissions
            <i class="fas fa-lock"></i>
        </h1>
        @role('superadmin')
            <a href="{{ route('show_admins') }}" class="btn btn-secondary">Goto Admins</a>
        @endrole
    </div>
    <hr />
    {{-- <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive"> --}}
                <table id="DataTable" class="table table-hover mb-5">
                    {{-- <table class="table table-bordered" id="myDataTable" width="100%" cellspacing="0"> --}}
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Role Names</th>
                            <th>Permissions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    {{-- <td class="align-middle"><img src="#" alt="Admin Image" style="max-width: 200px; max-height: 200px;"></td> --}}
                                    <td class="align-middle">
                                        {{-- <span class="badge {{ $role->name === 'superadmin' ? 'bg-danger' : 'bg-primary' }} text-white rounded-pill">{{ $role->name }}</span> --}}
                                        <span class="badge px-2 py-1 {{ $role->name === 'superadmin' ? 'bg-danger' : ($role->name === 'admin' ? 'bg-primary' : 'bg-warning') }} text-white rounded-pill">{{ $role->name }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @foreach($role->permissions as $permission)
                                        {{-- <span class="badge {{ $admin->getRoleNames()[0] === 'superadmin' ? 'bg-danger' : 'bg-primary' }} text-white rounded-pill">{{ $admin->getRoleNames()[0] }}</span> --}}
                                        <span class="badge bg-dark text-white rounded pill">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="align-middle"><span class="badge bg-success text-white">active</span></td>
                                    {{-- <td class="align-middle">{{ Str::limit($admin->course_description, 30, '...') }}</td> --}}
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            {{-- </div>
        </div>
    </div> --}}
@endsection

