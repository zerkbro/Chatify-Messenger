<li class="onhover-dropdown" wire:poll.10s> {{-- We are refreshing this component every 10 sec. --}}
    <div class="notification-box"><i class="fa-regular fa-bell fa-lg"></i>
        <span class="@if ($notificationCount > 0) dot-animated @endif"></span>
    </div>
    <ul class="notification-dropdown onhover-show-div">
        <li>
            {{-- display how many unread notification we have right now --}}
            <p class="f-w-700 mb-0">{{ $notificationCount > 0 ? $notificationCount : 'No' }}
                New Notifications
            </p>
        </li>
        @if ($totalNotificationCount > 0)
            {{-- Executes when there is notifications --}}
            @foreach ($notifications as $notification)
                {{-- checking a notification is whethere friend request sent or accepted or other notification type --}}

                @if ($notification->data['type'] == 'request_sent')
                    <li class="noti-danger" >
                        {{-- <dd>{{ $notification->id }}</dd> --}}
                            <div class="media">
                                <span class="notification-bg bg-light-danger">
                                    <i class="fa-solid fa-user-plus"></i></span>
                                <div class="media-body">
                                    <p
                                        class="{{ $notification->read_at ? 'f-12 f-w-400 text-muted' : 'f-12 f-w-600' }}">
                                        {{ $notification->data['sender_name'] }} wants to be
                                        friend</p>
                                    <span
                                        class="f-12 text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                    </li>
                @elseif ($notification->data['type'] == 'request_accept')
                    <li class="noti-secondary" >
                        <div class="media">
                            <span class="notification-bg bg-light-success">
                                <i class="fa-solid fa-user-check"></i></span>
                            <div class="media-body">
                                <p class="{{ $notification->read_at ? 'f-12 f-w-400 text-muted' : 'f-12 f-w-600' }}">
                                    {{ $notification->data['sender_name'] }} has accepted
                                    your request.</p>
                                <span class="f-12 text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach


            {{-- Mark All As Read --}}
            @if ($notificationCount != 0)
                <li class="text-center">
                    <span class="text-danger f-12 f-w-600" wire:click='markAllReadNotification'>Mark All As Read</span>
                </li>
            @endif
        @else
            {{-- If Total Notification Count is 0 then this executes --}}
            <li>
                <span class="text-muted text-center f-12">
                    Nothing to show!
                </span>
            </li>
        @endif
    </ul>
</li>
