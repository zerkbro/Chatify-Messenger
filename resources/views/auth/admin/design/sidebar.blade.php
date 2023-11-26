<!-- Sidebar -->
{{-- <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"> --}}
<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon ">
            {{-- <i class="fas fa-graduation-cap"></i> --}}
            {{-- <i class="fas fa-user-graduate"></i> --}}
            {{-- <a class="navbar-brand" href="#"> --}}
            <img src="{{ asset('talkster/chatify-website-favicon-white.png') }}" alt="..." style="height: 45px">
            {{-- </a> --}}

            <div class="sidebar-brand-text mx-3">Chatify</div>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('adminDashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Admins
    </div>

    <!-- Nav Item - Admin Hub Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-crown"></i>
            <span>Admin Hub</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar" >
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin Management</h6>
                <a class="collapse-item" href="{{ route('show_admins') }}">Show All Admin</a>
                @role('superadmin')
                    <a class="collapse-item" href="{{ route('add_admin') }}">Manage Admin</a>
                @endrole
            </div>
        </div>
    </li>
    <!-- Nav Item - Roles & Permission Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-lock"></i>
            <span>Roles & Permission</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Customize Roles</h6>
                <a class="collapse-item" href="{{ route('view_roles') }}">View Roles</a>
                <a class="collapse-item" href="{{ route('view_permissions') }}">View Permission</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Users
    </div>
    <!-- Nav Item - User Management Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudent"
            aria-expanded="true" aria-controls="collapseStudent">
            <i class="fas fa-fw fa-user"></i>
            <span>Manage Users</span>
        </a>
        <div id="collapseStudent" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management</h6>
                <a class="collapse-item" href="{{ route('show_users') }}">Show All Users</a>
                <a class="collapse-item" href="{{ route('add_newuser') }}">Manage User</a>
                <a class="collapse-item text-danger fw-600" href="{{ route('show_inactive_users') }}">Disabled Users</a>
            </div>
        </div>
    </li>

    {{-- <!-- Currently we are not going to use in the project demo. -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMessage"
            aria-expanded="true" aria-controls="collapseMessage">
            <i class="fas fa-fw fa-comment"></i>
            <span>Messages</span>
        </a>
        <div id="collapseMessage" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Feedbacks</h6>
                <a class="collapse-item" href="utilities-border.html">Messages</a>
                <a class="collapse-item" href="utilities-border.html">Send Emails</a>
            </div>
        </div>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
            aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-fw fa-hammer"></i>
            <span>Settings</span>
        </a>
        <div id="collapseSettings" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Setting Management</h6>
                <a class="collapse-item" href="{{ route('change_password') }}">Change Password</a>
                <a class="collapse-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </div>
    </li>


    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
