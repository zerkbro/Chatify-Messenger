@extends('auth.admin.design.main')
@section('subtitle', 'Roles And Permission')

{{-- by using the content section display in the dashboard --}}
@section('contentsection')

    <!-- Content Row -->
    <div class="container">

        <div class="row card-shadow">
            <div class="col">
                <ul class="list-group">
                    @foreach ($permissions as $permission)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="badge rounded-pill bg-dark text-white py-2 px-3">{{ $permission->name }}</span>
                        <div class="float-right">
                            <i class="fas fa-trash fa-lg float-right text-danger" data-bs-dismiss="alert" aria-label="Close"
                            style="cursor: pointer;"></i>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

        @endsection
