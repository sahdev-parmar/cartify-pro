<?php

namespace App\Livewire\Admin\Notification;

use App\Models\Order;
use Livewire\Component;

class Notification extends Component
{
    public $unreadCount;
    public $showDropdown = false;
    
    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAllAsRead()
    {
        $this->unreadCount = 0;
    }

    public function closeDropdown()
    {
        $this->showDropdown = false;
    }

    public function mount()
    {
        $this->unreadCount = Order::where('created_at', '>=', now()->subHour())->count();
    }

    public function render()
    {
        $notifications = Order::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        
        return view('livewire.admin.notification.notification',[
            'notifications' => $notifications
        ]);
    }
}
