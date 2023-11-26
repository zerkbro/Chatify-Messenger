<!-- Page Header Start-->
<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            {{-- Top Nav Goes Here --}}
            <div class="logo-wrapper"><a href="#"><img class="img-fluid"
                        src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}"
                        alt=""></a></div>
            <div class="dark-logo-wrapper"><a href="#"><img class="img-fluid"
                        src="{{ asset('talkster/chatify-high-resolution-logo-white-on-transparent-background.png') }}"
                        alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle text-dark" data-feather="align-center"
                    id="sidebar-toggle"></i></div>

        </div>

        @php
            $notificationCount = auth()
                ->user()
                ->notifications()
                ->count();
            $notifications = auth()
                ->user()
                ->notifications()
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp

        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                            data-feather="maximize"></i></a></li>


                            @livewire('notification-bar')
                {{-- <li class="onhover-dropdown"> --}}
                    {{-- <div class="notification-box"><i data-feather="bell"></i>
                        <span class="@if ($notificationCount > 0) dot-animated @endif"></span>
                    </div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            <p class="f-w-700 mb-0">You have {{ $notificationCount > 0 ? $notificationCount : 'No' }}
                                New Notifications
                            </p>
                        </li>
                        @if ($notificationCount > 0)
                            @foreach ($notifications as $notification)
                                @if ($notification->data['type'] == 'request_sent')
                                    <li class="noti-danger">
                                        <div class="media">
                                            <span class="notification-bg bg-light-danger">
                                                <i data-feather="user-plus"></i></span>
                                            <div class="media-body">
                                                <p class="f-12">{{ $notification->data['sender_name'] }} wants to be
                                                    friend</p>
                                                <span
                                                    class="f-12 text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @elseif ($notification->data['type'] == 'request_accept')
                                    <li class="noti-danger">
                                        <div class="media">
                                            <span class="notification-bg bg-light-danger">
                                                <i data-feather="user-check"></i></span>
                                            <div class="media-body">
                                                <p class="f-12">{{ $notification->data['sender_name'] }} has accepted your request.</p>
                                                <span
                                                    class="f-12 text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li>
                                <span class="text-muted text-center f-12">
                                    Nothing to show!
                                </span>
                            </li>
                        @endif
                    </ul> --}}
                {{-- </li> --}}


                {{-- <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li> --}}

                <a href="{{ route('userProfile') }}">
                    <img class="rounded-circle user-image" src="/storage/{{ auth()->user()->profile_image_path }}"
                        alt="user_img" style="max-height:50px; max-width: 50px; height:100%; width:100%">
                </a>
            </ul>
        </div>
    </div>
</div>
