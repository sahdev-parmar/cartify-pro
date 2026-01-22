<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show()
    {
        $categories = Category::whereStatus(1)->latest()->get();
        $featuredProducts = Product::query()
            ->where(function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('status', 1);
                })
                ->where('stock_status', 1);
            })
            ->orderByDesc('sales_count')
            ->limit(4)
            ->get();
        return view('home.index',compact(['categories','featuredProducts']));
    }
}
