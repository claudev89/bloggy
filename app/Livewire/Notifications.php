<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class Notifications extends Component
{
    public $notifications;
    public $perPage = 8;
    public $loadedNotifications = 0;
    public $userId;
    public $hasMoreNotifications = true;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->notifications = collect();
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $newNotifications = Notification::forUser($this->userId)
            ->latest()
            ->skip($this->loadedNotifications)
            ->take($this->perPage)
            ->get();

        $this->notifications = $this->notifications->merge($newNotifications);
        $this->loadedNotifications += $this->perPage;

        if ( $newNotifications->count() < $this->perPage){
            $this->hasMoreNotifications = false;
        }
    }

    public function loadMoreNotifications()
    {
        if($this->hasMoreNotifications) {
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.notifications', ['notifications' => $this->notifications]);
    }
}
