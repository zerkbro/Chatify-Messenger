<!DOCTYPE html>
<html lang="en">
    <head>
        @include('auth.frontend.user.bestlayout.header')
    </head>

<body>
    <!-- Loader starts-->
    {{-- <div class="loader-wrapper">
        <div class="theme-loader"></div>
      </div> --}}
      <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper compact-sidebar" id="pageWrapper">
        {{-- Page Header Top Nav Start --}}
        @include('auth.frontend.user.bestlayout.user_topnav')
        {{-- <!-- Page Header Ends --> --}}

        {{-- Page Body Starts --}}
        <div class="page-body-wrapper sidebar-icon">
            <!-- Page Sidebar Start-->
            @include('auth.frontend.user.bestlayout.user_sidenav')

            <!-- Page Sidebar Ends-->
            <div class="page-body">
            {{-- <div class="page-body" style=" margin-bottom:-60px;"> --}}

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    @yield('main_content')
                </div>
                <!-- Container-fluid Ends-->

                <!-- footer start-->
                {{-- <div class="container-fluid">
                    @extends('auth.frontend.user.bestlayout.user_footer')
                </div> --}}
            </div>
            @extends('auth.frontend.user.bestlayout.user_footer')
        </div>
        {{-- Page Body Ends --}}

    </div>
    {{-- page wrapper Ends --}}
    @include('auth.frontend.user.bestlayout.script')

</body>
</html>
