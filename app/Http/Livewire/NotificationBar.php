<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class NotificationBar extends Component
{
    public function mount(){
        /** @var \App\Models\User $user */

        $notificationCount = auth()
                    ->user()
                    // ->notifications
                    ->unreadNotifications
                    ->count();
        $totalNotificationCount = auth()
                    ->user()
                    ->notifications
                    ->count();
        $notifications = auth()
                    ->user()
                    ->notifications
                    ->sortByDesc('created_at');
        compact('notificationCount','totalNotificationCount','notifications');
    }
    public function render()
    {
        /** @var \App\Models\User $user */

        $notificationCount = auth()
                    ->user()
                    ->unreadNotifications
                    ->count();
        $totalNotificationCount = auth()
                    ->user()
                    ->notifications
                    ->count();
        $notifications = auth()
                    ->user()
                    ->notifications
                    ->sortByDesc('created_at');
        return view('livewire.notification-bar',compact('notificationCount','totalNotificationCount','notifications'));
    }

    public function refresh(){
        // leaving blank for rerender the NotificationBar component
    }

    /**
     *
     * Mark Notification as Read ( BULK)
     *
     */

    public function markAllReadNotification(){
        $user = auth()->user(); // Current User
        $user->unreadNotifications->markAsRead(); //Using Default laravel function to make it as read.
        $this->refresh();
    }

    /**
     *
     * Single Notification as Read
     *
     */

    //  public function markNotificationAsSeen($notificationId){
    //     $user = auth()->user(); // current user
    //     $singleNotification = Notification::findOrFail($notificationId);
    //     if($singleNotification && !$singleNotification->read_at){
    //         // Mark this as read.
    //         $singleNotification->update(['read_at' => now()]);
    //     }
    // }
}
