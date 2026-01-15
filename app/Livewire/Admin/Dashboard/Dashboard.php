<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard.dashboard');
    }
}
