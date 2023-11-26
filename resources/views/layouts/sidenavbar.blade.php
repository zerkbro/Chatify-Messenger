<header class="main-nav">
    <nav>
        <div class="main-navbar">
            {{-- <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div> --}}
            <ul class="nav-menu custom-scrollbar">
                <li class="back-btn">
                    <div class="mobile-back text-end"><span>Back</span><i
                            class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>

                {{-- Dashboard Items Title Here --}}
                {{-- <li class="sidebar-main-title">
                    <div>
                        <h6>General</h6>
                    </div>
                </li> --}}
                <li class="dropdown py-4">
                    <a class="nav-link menu-title " href="{{ route('userDashboard') }}"><i
                            data-feather="home"></i><span>Home</span></a>
                </li>

                {{-- Dashboard Items Title Here --}}

                <li class="dropdown py-4">
                    <a class="nav-link menu-title " href="{{ route('userProfile') }}"><i
                            data-feather="user"></i><span>Profile </span></a>
                </li>
                <li class="dropdown py-4">
                    <a class="nav-link menu-title " href="{{ route('chat_body') }}"><i
                            data-feather="message-square"></i><span>Chats</span></a>
                </li>
                <li class="dropdown py-4">
                    <a class="nav-link menu-title " href="{{ route('search_friends') }}"><i
                            data-feather="search"></i><span>Search</span></a>
                </li>
                <li class="dropdown py-4">
                    <a class="nav-link menu-title " href="{{ route('change_user_password') }}"><i
                            data-feather="settings"></i><span>Settings</span></a>
                </li>
                <li class="dropdown">
                    <a class="nav-link menu-title " href="{{ route('user_logout') }}"><i
                            data-feather="log-out"></i><span>Log out</span></a>
                </li>

                {{-- add multiple dashboard items as necessary --}}
            {{-- </ul> --}}
            {{-- <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div> --}}
        </div>
    </nav>
</header>
