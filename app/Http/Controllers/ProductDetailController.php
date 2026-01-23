<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function show($slug)
    {
        $product = Product::whereSlug($slug)->firstOrFail(); //first find imporatant

        $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('stock_status', 1)
        ->latest()
        ->take(4)
        ->get();

        return view('product.product-detail',compact('product','relatedProducts'));    
    }
}
