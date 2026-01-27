<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        }else {    
            Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
         }
    }

    public function getCount()
    {
        $cartCount = Auth::user()->cart()->count();
        $total = Auth::user()->cart()->with('product')->get()->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'cart_count' => $cartCount,
            'total' => $total
        ]);
    }

    public function getItems()
    {
        $cartitems = Cart::Where('user_id',Auth::user()->id)->with('product')->get();
        $total = $cartitems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        return response()->json([
            'items' => $cartitems,
            'total' => $total
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id'
        ]);

        Cart::find($request->cart_id)->delete();

        $this->getCount();
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('id', $request->cart_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        $this->getCount();
    }
}
