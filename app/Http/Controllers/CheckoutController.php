<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nnjeim\World\Models\Country;

class CheckoutController extends Controller
{
    // cart checkout
    public function index()
    {   
        $cartItems = Cart::where('user_id', Auth::id())
        ->with('product')
        ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $countries = Country::all();

        return view('order.checkout-index', [
            'checkoutType' => 'cart',
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'countries' => $countries,
        ]);
    }

    // direct buy single product
    public function buynow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        $subtotal = $product->price * $request->quantity;

        $countries = Country::all();

        return view('order.checkout-index', [
            'checkoutType' => 'buynow',
            'product' => $product,
            'quantity' => $request->quantity,
            'subtotal' => $subtotal,
            'countries' => $countries,
        ]);

    }

    public function process(Request $request)
    {
        $request->validate([
            'checkout_type' => 'required|in:cart,buynow',
            'payment_method' => 'required|in:cod,upi,bank_transfer',
            'address' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        $subtotal = 0;
        $orderItemsData = [];

        // cheack cart or buynow
        if($request->checkout_type  == 'cart'){

            $cartItems = Cart::where('user_id', Auth::id())->get();

            foreach($cartItems as $cartItem){

                $itemSubtotal = $cartItem->quantity * $cartItem->product->price;
                $subtotal += $itemSubtotal;
                
                $orderItemsData[] = [
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    ];
            }
        }else{

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);
            
            $product = Product::findOrFail($request->product_id);

            $itemSubtotal = $product->price * $request->quantity;
            $subtotal = $itemSubtotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                ];
        }

         // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'total' => $subtotal,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'country_id' => $request->country_id,
        ]);

        // copy cartitems to orderitems
        foreach ($orderItemsData as $itemData) {
            Order_item::create([
                'order_id' => $order->id,  //from upper create order
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'],
                'price' => $itemData['price'],
            ]);

            // Update product sales count
            Product::where('id', $itemData['product_id'])
                ->increment('sales_count', $itemData['quantity']);
        } 
        
        // clear cart
        if ($request->checkout_type === 'cart') {
            $deletedCount = Cart::where('user_id', Auth::id())->delete();
        }

        return redirect()->route('order.success', $order->id)
                ->with('success', 'Order placed successfully! Your cart has been cleared.');

    }


}
