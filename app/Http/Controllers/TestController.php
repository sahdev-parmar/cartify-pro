<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function show()
    {
        $categories = Category::latest()->get();
        $featuredProducts = Product::all();
        return view('test',compact(['categories','featuredProducts']));
    }
}
