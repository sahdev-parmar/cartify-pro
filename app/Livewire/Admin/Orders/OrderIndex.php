<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class OrderIndex extends Component
{
    public function render()
    {
        $orders = Order::paginate(10);
        return view('livewire.admin.orders.order-index',[
            'orders' => $orders
        ]);
    }
}
