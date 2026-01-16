<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class Dashboard extends Component
{
    public $totalRevenue,$totalOrders,$totalCustomers;
    public $revenueGrowth,$ordersGrowth,$customersGrowth;
    public $topProducts;
    public $latestCustomers;
    public $recentOrders;

    public function mount()
    {
        $this->totalRevenue = Order::where('status', 'confirmed')->sum('total');
        $this->totalOrders = Order::all()->count();
        $this->totalCustomers = User::where('type', 'user')->count();
        $this->topProducts = Product::orderBy('sales_count', 'desc')->limit(4)->get()->map(function ($order) {
                            $order->growth = rand(5, 10);
                            return $order;
                        });;
        $this->latestCustomers = User::where('type','user')->latest()->limit(4)->get();
        $this->recentOrders = Order::latest()->limit(4)->get();
        $this->revenueGrowth = rand(5, 10);
        $this->ordersGrowth = rand(5, 10);
        $this->customersGrowth = rand(5, 10);

    }
    public function render()
    {
        return view('livewire.admin.dashboard.dashboard');
    }
}
