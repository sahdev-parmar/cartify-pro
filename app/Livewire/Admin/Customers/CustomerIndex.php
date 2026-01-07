<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class CustomerIndex extends Component
{
    public function render()
    {   
        $users = User::paginate(10);
        return view('livewire.admin.customers.customer-index',[
            'users' => $users
        ]);
    }
}
