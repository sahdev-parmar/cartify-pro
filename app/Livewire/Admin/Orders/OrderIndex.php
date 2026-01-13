<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class OrderIndex extends Component
{
    public $openDropdown;
    public $search,$statusFilter = 'all',$dateFilter = 'all';
    public $viewOrder = [],$showViewModal;
    
    public function render()
    {
       $orders = Order::query();

        if ($this->search) {
            $orders->where('order_number', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
        }

        if($this->statusFilter != 'all'){
            $orders->whereStatus($this->statusFilter);
        }

        if($this->dateFilter != "all"){
            match ($this->dateFilter) {

                'today' => $orders->whereDate('created_at', Carbon::today()),

                'week' => $orders->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]),

                'month' => $orders->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year),

                'year' => $orders->whereYear('created_at', now()->year),
            };
        }

        $orders = $orders->latest()->paginate(10);


        return view('livewire.admin.orders.order-index',[
            'orders' => $orders
        ]);
    }

    public function toggleDropdown($id)
    {
        $this->openDropdown = ($this->openDropdown === $id) ? null : $id; //second time click  so hide
    }
    
    public function viewShowOrder($id)
    {
        $this->viewOrder = Order::find($id);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->reset('viewOrder');
        $this->showViewModal = false;
    }
}
