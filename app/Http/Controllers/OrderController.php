<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function success($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with(['items.product', 'city', 'state', 'country'])
            ->firstOrFail();

        return view('order.success', compact('order'));
    }

    public function index()
    {
        $orders = Order::whereUserId(Auth::user()->id)->latest()->paginate(3);
        return view('order.my-orders',compact('orders'));    
    }

    public function show($id)
    {
        $order = Order::find($id);
        return view('order.order-detail',compact('order'));
    }

    public function cancel($id)
    {
        
        $order = Order::find($id);
        if($order->user_id == Auth::user()->id){
            $order->update(['status' => 'cancelled']);  //security

            return redirect()->route('orders.index')->with('success', 'Order cancelled successfully');
   
        }
        return back();
    }
}
