<!-- Page Header Start-->
<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            {{-- Top Nav Goes Here --}}
            <div class="logo-wrapper"><a href="#"><img class="img-fluid" src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}" alt=""></a></div>
            <div class="dark-logo-wrapper"><a href="#"><img class="img-fluid" src="{{ asset('talkster/chatify-high-resolution-logo-white-on-transparent-background.png')}}" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle text-dark" data-feather="align-center" id="sidebar-toggle"></i></div>

        </div>
        <div class="left-menu-header col">
            <ul>
                <li>
                  <form class="form-inline search-form">
                    <div class="search-bg"><i class="fa fa-search"></i><input class="form-control-plaintext" placeholder="Search here....."></div>
                  </form>
                  <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                </li>
            </ul>

        </div>

        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                <li class="onhover-dropdown">
                    <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span>
                    </div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            <p class="f-w-700 mb-0">You have 3 Notifications<span
                                    class="pull-right badge badge-primary badge-pill">4</span></p>
                        </li>
                        <li class="noti-primary">
                            <div class="media">
                                <span class="notification-bg bg-light-primary"><i data-feather="activity">
                                    </i></span>
                                <div class="media-body">
                                    <p>Delivery processing </p>
                                    <span>10 minutes ago</span>
                                </div>
                            </div>
                        </li>
                        <li class="noti-secondary">
                            <div class="media">
                                <span class="notification-bg bg-light-secondary"><i data-feather="check-circle">
                                    </i></span>
                                <div class="media-body">
                                    <p>Order Complete</p>
                                    <span>1 hour ago</span>
                                </div>
                            </div>
                        </li>
                        <li class="noti-success">
                            <div class="media">
                                <span class="notification-bg bg-light-success"><i data-feather="file-text">
                                    </i></span>
                                <div class="media-body">
                                    <p>Tickets Generated</p>
                                    <span>3 hour ago</span>
                                </div>
                            </div>
                        </li>
                        <li class="noti-danger">
                            <div class="media">
                                <span class="notification-bg bg-light-danger"><i data-feather="user-check">
                                    </i></span>
                                <div class="media-body">
                                    <p>Delivery Complete</p>
                                    <span>6 hour ago</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <a href="#">
                    <img class="rounded-circle user-image" src="/storage/{{ auth()->user()->profile_image_path }}" alt="user_img" style="max-height:50px; max-width: 50px; height:100%; width:100%">
                </a>
            </ul>
        </div>
    </div>
</div>
