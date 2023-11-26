@extends('auth.admin.design.body')
@section('admin_title', 'Chatify | Admin - Dashboard')

@section('contents')

    <div id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">

            {{-- side navigation bar --}}
            <div class="sidenavbar">

                @include('auth.admin.design.sidebar')
            </div>

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="mycontentWrapper d-flex flex-column">

                <!-- Main Content -->
                <div id="content mb-5">
                    {{-- top nav bar --}}
                    <div id="admin-navbar" style="width:100%;">

                        @include('auth.admin.design.admin_navbar')
                    </div>
                    <!-- Begin Page Content -->
                    <div class="container-fluid mt-5">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">@yield('subtitle')</h1>
                        </div>

                        <div class="scrollable-content mb-5">
                            @yield('contentsection')
                        </div>
                        {{-- @yield('contentsection') --}}

                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
{{--                 @include('auth.admin.design.footerbar')--}}
            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
        @include('auth.admin.design.logoutModel')
    </div>



    <style>
        .sidenavbar {
            position: fixed;
            top: 0;
            bottom: 0;
            z-index: 1000000000;
        }

        .mycontentWrapper {
            display: none;
            height: 100vh;
            margin-left: 225px
        }

        .mycontentWrapper.active {
            margin-left: 100px;
        }

        @media(max-width:767px) {
            .mycontentWrapper {
                margin-left: 100px;
            }
        }
    </style>

    <script>
        const btn = document.querySelector("#sidebarToggle");
        btn.addEventListener("click", () => {
            const mycontentWrap = document.querySelector(".mycontentWrapper");
            // console.log(mycontentWrap);
            mycontentWrap.classList.toggle("active");
        })
    </script>

@endsection
